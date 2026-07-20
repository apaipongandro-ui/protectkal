<?php

namespace Pterodactyl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminId
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$allowedIds)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
        
        $userId = Auth::id();
        
        // Jika allowedIds kosong, hanya izinkan Root Admin (ID 1)
        if (empty($allowedIds)) {
            if ($userId !== 1) {
                abort(403, 'Akses ditolak! Hanya Root Admin (ID 1) yang diizinkan.');
            }
        } else {
            // Cek apakah user ID ada dalam daftar allowedIds
            if (!in_array($userId, $allowedIds)) {
                abort(403, 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        }
        
        return $next($request);
    }
}
