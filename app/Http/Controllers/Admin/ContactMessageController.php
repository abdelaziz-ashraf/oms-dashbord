<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $messages = $this->filteredMessages($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = ContactMessage::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.contact-messages.index', compact('messages', 'counts', 'status', 'search'));
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'contact-messages-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($request) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Status', 'Name', 'Email', 'Phone', 'Company', 'Subject', 'Message', 'Locale', 'Source', 'Received At']);

            $this->filteredMessages($request)
                ->oldest()
                ->chunk(200, function ($messages) use ($output) {
                    foreach ($messages as $message) {
                        fputcsv($output, [
                            $message->id,
                            $message->status,
                            $message->full_name,
                            $message->email,
                            $message->phone,
                            $message->company,
                            $message->subject,
                            $message->message,
                            $message->locale,
                            $message->source,
                            optional($message->created_at)->toDateTimeString(),
                        ]);
                    }
                });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function show(ContactMessage $contactMessage): View
    {
        if (!$contactMessage->read_at) {
            $contactMessage->forceFill([
                'read_at' => now(),
                'status' => $contactMessage->status === 'new' ? 'read' : $contactMessage->status,
            ])->save();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,read,replied,archived'],
        ]);

        $contactMessage->forceFill([
            'status' => $data['status'],
            'read_at' => $data['status'] === 'new' ? null : ($contactMessage->read_at ?? now()),
        ])->save();

        return back()->with('success', 'Message status updated.');
    }

    public function reply(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $data = $request->validate([
            'subject' => ['nullable', 'string', 'max:255'],
            'reply_message' => ['required', 'string', 'max:5000'],
        ]);

        Mail::raw($data['reply_message'], function ($message) use ($contactMessage, $data) {
            $message->to($contactMessage->email)
                ->subject($data['subject'] ?: 'Re: '.($contactMessage->subject ?: 'Landing page inquiry'));
        });

        $contactMessage->forceFill([
            'status' => 'replied',
            'read_at' => $contactMessage->read_at ?? now(),
        ])->save();

        return back()->with('success', 'Reply sent and message marked as replied.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted.');
    }

    public function demoIndex(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $messages = $this->filteredDemoRequests($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = ContactMessage::query()
            ->where('source', 'demo_request')
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $total = ContactMessage::where('source', 'demo_request')->count();

        return view('admin.demo-requests.index', compact('messages', 'counts', 'status', 'search', 'total'));
    }

    public function demoExport(Request $request): StreamedResponse
    {
        $filename = 'demo-requests-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($request) {
            $output = fopen('php://output', 'w');
            fputcsv($output, [
                'ID', 'Status', 'Name', 'Email', 'Phone', 'Company',
                'Industry', 'Job Title', 'Company Size', 'Improvements',
                'Locale', 'Received At',
            ]);

            $this->filteredDemoRequests($request)
                ->oldest()
                ->chunk(200, function ($messages) use ($output) {
                    foreach ($messages as $message) {
                        fputcsv($output, [
                            $message->id,
                            $message->status,
                            $message->full_name,
                            $message->email,
                            $message->phone,
                            $message->company,
                            $message->industry,
                            $message->job_title,
                            $message->company_size,
                            implode(', ', $message->improvements ?? []),
                            $message->locale,
                            optional($message->created_at)->toDateTimeString(),
                        ]);
                    }
                });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function demoShow(ContactMessage $contactMessage): View
    {
        abort_unless($contactMessage->source === 'demo_request', 404);

        if (!$contactMessage->read_at) {
            $contactMessage->forceFill([
                'read_at' => now(),
                'status' => $contactMessage->status === 'new' ? 'read' : $contactMessage->status,
            ])->save();
        }

        return view('admin.demo-requests.show', compact('contactMessage'));
    }

    public function demoDestroy(ContactMessage $contactMessage): RedirectResponse
    {
        abort_unless($contactMessage->source === 'demo_request', 404);
        $contactMessage->delete();

        return redirect()->route('admin.demo-requests.index')
            ->with('success', 'Demo request deleted.');
    }

    private function filteredMessages(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        return ContactMessage::query()
            ->where('source', '!=', 'demo_request')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            });
    }

    private function filteredDemoRequests(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        return ContactMessage::query()
            ->where('source', 'demo_request')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('industry', 'like', "%{$search}%")
                        ->orWhere('job_title', 'like', "%{$search}%");
                });
            });
    }
}
