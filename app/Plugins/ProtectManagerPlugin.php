<?php

namespace Pterodactyl\Plugins;

use Pterodactyl\Models\User;
use Pterodactyl\Models\Server;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProtectManagerPlugin
{
    protected $adminId;
    protected $settings;
    
    public function __construct()
    {
        $this->adminId = Auth::id();
        $this->settings = Cache::remember('protect_settings', 3600, function () {
            return DB::table('protect_settings')->first();
        });
    }
    
    /**
     * Cek apakah user adalah Root Admin (ID 1)
     */
    public function isRootAdmin()
    {
        return $this->adminId === 1;
    }
    
    /**
     * Cek apakah proteksi tertentu aktif
     */
    public function isProtectActive($protectName)
    {
        if (!$this->settings) return false;
        return (bool) ($this->settings->{$protectName} ?? false);
    }
    
    /**
     * Dapatkan pesan abort kustom
     */
    public function getAbortMessage($type)
    {
        $customMessage = $this->settings->abort_message ?? 'Akses ditolak! Anda tidak memiliki izin.';
        
        $messages = [
            'delete_server' => '❌ PROTECT1 AKTIF: Anda tidak diizinkan menghapus server! Hanya Root Admin.',
            'modify_user' => '❌ PROTECT2 AKTIF: Anda tidak diizinkan mengubah/menghapus data user!',
            'access_location' => '❌ PROTECT3 AKTIF: Menu Location dikunci oleh Root Admin!',
            'access_nodes' => '❌ PROTECT4 AKTIF: Menu Nodes dikunci oleh Root Admin!',
            'access_nests' => '❌ PROTECT5 AKTIF: Menu Nests disembunyikan oleh Root Admin!',
            'access_settings' => '❌ PROTECT6 AKTIF: Menu Settings dikunci oleh Root Admin!',
            'server_file' => '❌ PROTECT7 AKTIF: Anda tidak bisa mengakses file server ini!',
            'server_controller' => '❌ PROTECT8 AKTIF: Kontrol server diblokir oleh Root Admin!',
            'modify_server' => '❌ PROTECT9 AKTIF: Modifikasi server dilarang! Hanya Root Admin.',
            'server_link' => '❌ PROTECT10 AKTIF: Tautan server dilindungi!',
            'server_link_v2' => '❌ PROTECT11 AKTIF: Tautan server dikunci ketat (v2)!',
            'consolidation' => '❌ PROTECT12 AKTIF: Konsolidasi proteksi menyeluruh aktif!',
            'app_api' => '❌ PROTECT13 AKTIF: Application API dikunci oleh Root Admin!',
            'create_delete_admin' => '❌ PROTECT14 AKTIF: Hanya Root Admin yang bisa mengelola admin!',
            'api_admin' => '❌ PROTECT14 AKTIF: Operasi admin via API diblokir!',
        ];
        
        return $messages[$type] ?? $customMessage;
    }
    
    // ==================== 14 PROTECTION METHODS ====================
    
    /**
     * PROTECT 1: Anti Delete Server
     * Mencegah penghapusan server oleh admin selain Root Admin (ID 1)
     */
    public function protect1_antiDeleteServer()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect1')) {
            $routeName = request()->route()->getName();
            $blockedRoutes = [
                'admin.servers.delete',
                'admin.servers.destroy',
                'admin.servers.mass-delete'
            ];
            
            if (in_array($routeName, $blockedRoutes)) {
                abort(403, $this->getAbortMessage('delete_server'));
            }
            
            // Blokir API delete
            if (request()->is('api/application/servers/*') && request()->isMethod('delete')) {
                abort(403, $this->getAbortMessage('delete_server'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 2: Anti Hapus/Ubah User
     * Melindungi data user dari penghapusan dan modifikasi oleh admin lain
     */
    public function protect2_antiModifyUser()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect2')) {
            $blockedRoutes = [
                'admin.users.delete',
                'admin.users.edit',
                'admin.users.update',
                'admin.users.destroy',
                'admin.users.modify'
            ];
            
            $routeName = request()->route()->getName();
            
            if (in_array($routeName, $blockedRoutes)) {
                abort(403, $this->getAbortMessage('modify_user'));
            }
            
            // Blokir API user modification
            if (request()->is('api/application/users/*') && 
                in_array(request()->method(), ['PUT', 'PATCH', 'DELETE'])) {
                abort(403, $this->getAbortMessage('modify_user'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 3: Anti Akses Location
     * Memblokir akses menu Location untuk admin selain Root Admin
     */
    public function protect3_antiAccessLocation()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect3')) {
            if (request()->is('admin/locations*') || 
                request()->is('admin/location*')) {
                abort(403, $this->getAbortMessage('access_location'));
            }
            
            // Blokir API locations
            if (request()->is('api/application/locations*')) {
                abort(403, $this->getAbortMessage('access_location'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 4: Anti Akses Nodes
     * Memblokir akses menu Nodes untuk admin selain Root Admin
     */
    public function protect4_antiAccessNodes()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect4')) {
            if (request()->is('admin/nodes*') || 
                request()->is('admin/node*')) {
                abort(403, $this->getAbortMessage('access_nodes'));
            }
            
            // Blokir API nodes
            if (request()->is('api/application/nodes*')) {
                abort(403, $this->getAbortMessage('access_nodes'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 5: Nests + Branding + Welcome Banner
     * Menyembunyikan Nests, menambah branding footer & welcome banner
     */
    public function protect5_nestsBrandingBanner()
    {
        if ($this->isProtectActive('protect5')) {
            // Sembunyikan Nests untuk non-Root Admin
            if (!$this->isRootAdmin()) {
                if (request()->is('admin/nests*')) {
                    abort(403, $this->getAbortMessage('access_nests'));
                }
            }
            
            // Share branding data ke semua views
            view()->share('brand_name', $this->settings->brand_name ?? 'ProtectKal');
            view()->share('show_welcome_banner', true);
            view()->share('welcome_title', $this->settings->welcome_title ?? 'Selamat Datang!');
            view()->share('welcome_message', $this->settings->welcome_message ?? '');
        }
        return true;
    }
    
    /**
     * PROTECT 6: Anti Akses Settings
     * Memblokir akses menu Settings untuk admin selain Root Admin
     */
    public function protect6_antiAccessSettings()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect6')) {
            if (request()->is('admin/settings*')) {
                abort(403, $this->getAbortMessage('access_settings'));
            }
            
            // Blokir API settings
            if (request()->is('api/application/settings*')) {
                abort(403, $this->getAbortMessage('access_settings'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 7: Anti Akses Server File
     * Memproteksi file controller server dari akses tidak sah
     */
    public function protect7_antiServerFileAccess()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect7')) {
            if (request()->is('admin/servers/*/files*') || 
                request()->is('api/client/servers/*/files*')) {
                
                $segments = request()->segments();
                $serverIndex = array_search('servers', $segments);
                
                if ($serverIndex !== false && isset($segments[$serverIndex + 1])) {
                    $serverId = $segments[$serverIndex + 1];
                    
                    // Cek apakah admin punya akses ke server ini
                    if (!$this->canAccessServer($serverId)) {
                        abort(403, $this->getAbortMessage('server_file'));
                    }
                }
            }
        }
        return true;
    }
    
    /**
     * PROTECT 8: Anti Akses Server Controller
     * Memproteksi server controller utama dari admin lain
     */
    public function protect8_antiServerController()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect8')) {
            $blockedActions = ['setState', 'updateBuild', 'manage', 'suspend', 'unsuspend'];
            $currentAction = request()->route()->getActionName();
            
            foreach ($blockedActions as $action) {
                if (strpos($currentAction, $action) !== false && 
                    strpos($currentAction, 'ServersController') !== false) {
                    abort(403, $this->getAbortMessage('server_controller'));
                }
            }
            
            // Blokir API server control
            if (request()->is('api/application/servers/*/suspend') || 
                request()->is('api/application/servers/*/unsuspend')) {
                abort(403, $this->getAbortMessage('server_controller'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 9: Anti Modifikasi Server
     * Mencegah perubahan detail server oleh admin lain
     */
    public function protect9_antiModifyServer()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect9')) {
            $blockedActions = ['update', 'edit', 'modify', 'transfer', 'build'];
            
            foreach ($blockedActions as $action) {
                if (request()->is("admin/servers/*/$action*") || 
                    request()->is("api/application/servers/*/$action*")) {
                    abort(403, $this->getAbortMessage('modify_server'));
                }
            }
        }
        return true;
    }
    
    /**
     * PROTECT 10: Anti Tautan Server v1
     * Mencegah perubahan tautan/link server
     */
    public function protect10_antiServerLink_v1()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect10')) {
            $blockedPaths = ['connection', 'allocation'];
            
            foreach ($blockedPaths as $path) {
                if (request()->is("admin/servers/*/$path*") || 
                    request()->is("api/application/servers/*/$path*")) {
                    abort(403, $this->getAbortMessage('server_link'));
                }
            }
        }
        return true;
    }
    
    /**
     * PROTECT 11: Anti Tautan Server v2
     * Versi lanjutan proteksi tautan dengan pengamanan lebih ketat
     */
    public function protect11_antiServerLink_v2()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect11')) {
            $blockedPaths = ['connection', 'allocation', 'network', 'ip', 'port', 'link', 'url', 'domain'];
            
            foreach ($blockedPaths as $path) {
                if (request()->is("admin/servers/*/$path*") || 
                    request()->is("api/application/servers/*/$path*")) {
                    abort(403, $this->getAbortMessage('server_link_v2'));
                }
            }
            
            // Blokir modifikasi allocation via API
            if (request()->is('api/application/servers/*/allocations*') && 
                in_array(request()->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                abort(403, $this->getAbortMessage('server_link_v2'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 12: Konsolidasi Proteksi
     * Gabungan proteksi Nodes, Client API, App API, API Key, Locations
     */
    public function protect12_consolidation()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect12')) {
            $blockedResources = [
                'nodes', 'locations', 
                'api/application', 'api/client',
                'api-keys', 'api/permissions'
            ];
            
            foreach ($blockedResources as $resource) {
                if (request()->is("admin/$resource*") || 
                    request()->is("$resource*")) {
                    abort(403, $this->getAbortMessage('consolidation'));
                }
            }
        }
        return true;
    }
    
    /**
     * PROTECT 13: Proteksi Application API
     * Menyembunyikan menu Application API dan memblokir akses controller
     */
    public function protect13_appApiProtection()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect13')) {
            if (request()->is('admin/api*') || 
                request()->is('admin/application-api*') ||
                request()->is('api/application*')) {
                abort(403, $this->getAbortMessage('app_api'));
            }
        }
        return true;
    }
    
    /**
     * PROTECT 14: Anti Create/Delete Admin
     * Mengunci hak akses pembuatan & penghapusan admin
     */
    public function protect14_antiCreateDeleteAdmin()
    {
        if (!$this->isRootAdmin() && $this->isProtectActive('protect14')) {
            $blockedRoutes = [
                'admin.users.new',
                'admin.users.create',
                'admin.users.store',
                'admin.users.delete',
                'admin.users.destroy',
                'admin.users.mass-delete'
            ];
            
            $routeName = request()->route()->getName();
            
            if (in_array($routeName, $blockedRoutes)) {
                abort(403, $this->getAbortMessage('create_delete_admin'));
            }
            
            // Blokir API admin management
            if (request()->is('api/application/users') && 
                in_array(request()->method(), ['POST', 'DELETE'])) {
                abort(403, $this->getAbortMessage('api_admin'));
            }
            
            // Blokir akses ke panel.js (bot automation)
            if (request()->is('*/panel.js*') || 
                request()->is('*/bot*')) {
                abort(403, $this->getAbortMessage('api_admin'));
            }
        }
        return true;
    }
    
    // ==================== HELPER METHODS ====================
    
    /**
     * Cek apakah admin memiliki akses ke server tertentu
     */
    private function canAccessServer($serverId)
    {
        // Root admin always has access
        if ($this->isRootAdmin()) {
            return true;
        }
        
        // Cek dari cache allowed servers
        $allowedServers = Cache::get("admin_{$this->adminId}_servers", []);
        
        if (empty($allowedServers)) {
            // Fallback: cek dari database
            $allowedServers = Server::where('owner_id', $this->adminId)
                ->pluck('id')
                ->toArray();
            Cache::put("admin_{$this->adminId}_servers", $allowedServers, 3600);
        }
        
        return in_array((int)$serverId, $allowedServers);
    }
    
    /**
     * Dapatkan semua proteksi yang aktif
     */
    public function getActiveProtections()
    {
        $active = [];
        
        for ($i = 1; $i <= 14; $i++) {
            $protectName = "protect{$i}";
            if ($this->isProtectActive($protectName)) {
                $active[] = $protectName;
            }
        }
        
        return $active;
    }
    
    /**
     * Dapatkan jumlah proteksi yang aktif
     */
    public function getActiveCount()
    {
        return count($this->getActiveProtections());
    }
}
