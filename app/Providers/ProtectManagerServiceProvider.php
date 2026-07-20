<?php

namespace Pterodactyl\Providers;

use Illuminate\Support\ServiceProvider;
use Pterodactyl\Plugins\ProtectManagerPlugin;

class ProtectManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register singleton ProtectManagerPlugin
        $this->app->singleton(ProtectManagerPlugin::class, function ($app) {
            return new ProtectManagerPlugin();
        });
        
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/protect.php', 'protect'
        );
    }
    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        
        // Load routes
        if (file_exists(base_path('routes/protect-routes.php'))) {
            $this->loadRoutesFrom(base_path('routes/protect-routes.php'));
        }
        
        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'protect');
        
        // Publish config
        $this->publishes([
            __DIR__.'/../../config/protect.php' => config_path('protect.php'),
        ], 'protect-config');
        
        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/protect'),
        ], 'protect-views');
        
        // Publish assets
        $this->publishes([
            __DIR__.'/../../resources/scripts' => public_path('resources/scripts'),
        ], 'protect-assets');
        
        // Register blade directives
        $this->registerBladeDirectives();
    }
    
    /**
     * Register custom Blade directives
     */
    protected function registerBladeDirectives(): void
    {
        // @protectBrand - Menampilkan brand name
        \Blade::directive('protectBrand', function () {
            return "<?php echo config('protect.brand_name', 'ProtectKal'); ?>";
        });
        
        // @isRootAdmin - Cek apakah user adalah Root Admin
        \Blade::directive('isRootAdmin', function () {
            return "<?php if(auth()->id() === 1): ?>";
        });
        
        // @endIsRootAdmin
        \Blade::directive('endIsRootAdmin', function () {
            return "<?php endif; ?>";
        });
        
        // @protectionActive($name) - Cek apakah proteksi tertentu aktif
        \Blade::directive('protectionActive', function ($name) {
            return "<?php if(app(\Pterodactyl\Plugins\ProtectManagerPlugin::class)->isProtectActive({$name})): ?>";
        });
        
        // @endProtectionActive
        \Blade::directive('endProtectionActive', function () {
            return "<?php endif; ?>";
        });
    }
}
