<?php

namespace Pterodactyl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pterodactyl\Plugins\ProtectManagerPlugin;

class ProtectMiddleware
{
    protected $plugin;
    
    public function __construct(ProtectManagerPlugin $plugin)
    {
        $this->plugin = $plugin;
    }
    
    /**
     * Handle an incoming request.
     * Menerapkan semua 14 proteksi secara otomatis
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip jika tidak login
        if (!Auth::check()) {
            return $next($request);
        }
        
        // Skip untuk Root Admin (ID 1)
        if (Auth::id() === 1) {
            return $next($request);
        }
        
        // Terapkan semua 14 proteksi
        $this->plugin->protect1_antiDeleteServer();
        $this->plugin->protect2_antiModifyUser();
        $this->plugin->protect3_antiAccessLocation();
        $this->plugin->protect4_antiAccessNodes();
        $this->plugin->protect5_nestsBrandingBanner();
        $this->plugin->protect6_antiAccessSettings();
        $this->plugin->protect7_antiServerFileAccess();
        $this->plugin->protect8_antiServerController();
        $this->plugin->protect9_antiModifyServer();
        $this->plugin->protect10_antiServerLink_v1();
        $this->plugin->protect11_antiServerLink_v2();
        $this->plugin->protect12_consolidation();
        $this->plugin->protect13_appApiProtection();
        $this->plugin->protect14_antiCreateDeleteAdmin();
        
        return $next($request);
    }
}
