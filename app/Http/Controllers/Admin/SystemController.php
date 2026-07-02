<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SystemController extends Controller
{
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
