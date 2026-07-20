{{-- Welcome Banner Component - Protect Manager --}}

@if(isset($show_welcome_banner) && $show_welcome_banner)
    @php
        $settings = \Pterodactyl\Helpers\ProtectHelper::getSettings();
        $banner = \Pterodactyl\Helpers\ProtectHelper::getWelcomeBanner();
    @endphp
    
    @if($banner)
        <div class="welcome-banner" style="
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        ">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-1">
                        <i class="fas fa-hand-sparkles"></i> 
                        {{ $banner['title'] }}
                    </h4>
                    @if($banner['message'])
                        <p class="mb-0" style="opacity: 0.9;">
                            {{ $banner['message'] }}
                        </p>
                    @endif
                </div>
                <div class="col-md-4 text-right">
                    @if($banner['telegram_admin1'])
                        <a href="https://t.me/{{ str_replace('@', '', $banner['telegram_admin1']) }}" 
                           class="btn btn-light btn-sm mr-1" target="_blank">
                            <i class="fab fa-telegram"></i> Admin 1
                        </a>
                    @endif
                    @if($banner['telegram_admin2'])
                        <a href="https://t.me/{{ str_replace('@', '', $banner['telegram_admin2']) }}" 
                           class="btn btn-light btn-sm" target="_blank">
                            <i class="fab fa-telegram"></i> Admin 2
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endif
