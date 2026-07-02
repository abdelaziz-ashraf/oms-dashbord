<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SystemController extends Controller
{
    /**
     * Create the public/storage -> storage/app/public symlink.
     * Useful on shared hosting where the `php artisan storage:link`
     * command can't be run over SSH.
     */
    public function storageLink(): JsonResponse
    {
        $link = public_path('storage');
        $target = storage_path('app/public');

        // Already linked correctly.
        if (is_link($link) && readlink($link) === $target) {
            return response()->json([
                'success' => true,
                'status' => 'already-linked',
                'message' => 'Storage link already exists.',
                'link' => $link,
                'target' => $target,
            ]);
        }

        // Remove a stale link or leftover so we can recreate it.
        if (is_link($link) || file_exists($link)) {
            @unlink($link);
        }

        if (! function_exists('symlink')) {
            return response()->json([
                'success' => false,
                'status' => 'symlink-disabled',
                'message' => 'The symlink() function is disabled on this server. Ask your host to enable it or create the link manually.',
                'link' => $link,
                'target' => $target,
            ], 500);
        }

        if (@symlink($target, $link)) {
            return response()->json([
                'success' => true,
                'status' => 'created',
                'message' => 'Storage link created successfully.',
                'link' => $link,
                'target' => $target,
            ]);
        }

        return response()->json([
            'success' => false,
            'status' => 'failed',
            'message' => 'Failed to create the storage link. Check filesystem permissions.',
            'link' => $link,
            'target' => $target,
        ], 500);
    }

    /**
     * Serve a file from storage/app/public through PHP.
     * Fallback for shared hosting where symlink() is disabled, so
     * `/storage/...` URLs work without a real public/storage symlink.
     */
    public function serveStorage(string $path): BinaryFileResponse
    {
        $base = realpath(storage_path('app/public'));
        $full = realpath(storage_path('app/public/'.$path));

        // Missing file or a path that escapes the public storage dir.
        if ($base === false || $full === false || ! str_starts_with($full, $base.DIRECTORY_SEPARATOR)) {
            abort(404);
        }

        return response()->file($full, [
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
