<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Halaman ini hanya boleh diakses oleh akun dengan role "admin".
     * Akun "karyawan" akan ditolak dan dikembalikan ke dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Halaman ini khusus untuk akun Admin.');
        }

        return $next($request);
    }
}
