/**
 * Protect Manager v2.0 - Canva Edition
 * KALL XTREME X untuk Mulia
 */

;(function($, window, document, undefined) {
    'use strict';
    
    const ProtectManager = {
        
        config: {
            animationDuration: 400,
            toastDuration: 2000,
            totalProtects: 14
        },
        
        init: function() {
            this.bindEvents();
            this.updateStats();
            this.initAnimations();
            console.log('%c🛡️ Protect Manager v2.0 - Canva Edition %cloaded!', 
                        'color: #EC4899; font-size: 1.2em; font-weight: bold;',
                        'color: #fff;');
            console.log('%c👑 KALL XTREME X untuk Mulia', 'color: #8B5CF6; font-weight: bold;');
        },
        
        bindEvents: function() {
            const self = this;
            
            $(document).on('change', '.toggle-protect', function() {
                self.handleToggle($(this));
            });
            
            $(document).on('click', '.pm-tab', function() {
                self.switchTab($(this));
            });
        },
        
        handleToggle: function($toggle) {
            const protect = $toggle.attr('name');
            const status = $toggle.is(':checked');
            const $card = $('#card-' + protect);
            
            $toggle.prop('disabled', true);
            this.showLoading($card);
            
            $.ajax({
                url: '/admin/protect-manager/toggle',
                type: 'POST',
                data: {
                    protect: protect,
                    status: status ? 1 : 0,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    if (response.success) {
                        if (status) {
                            $card.addClass('active-protect');
                            $card.find('.pm-badge')
                                .css('background', 'var(--gradient-4)')
                                .text('AKTIF');
                        } else {
                            $card.removeClass('active-protect');
                            $card.find('.pm-badge')
                                .css('background', 'rgba(255,255,255,0.1)')
                                .text('NONAKTIF');
                        }
                        
                        this.updateStats();
                        this.showToast('success', response.message);
                        this.pulseElement($card);
                    }
                },
                error: (xhr) => {
                    $toggle.prop('checked', !status);
                    this.showToast('error', xhr.responseJSON?.message || 'Gagal mengubah proteksi');
                },
                complete: () => {
                    $toggle.prop('disabled', false);
                    this.hideLoading($card);
                }
            });
        },
        
        switchTab: function($tab) {
            const tabId = $tab.data('tab');
            
            $('.pm-tab').removeClass('active');
            $tab.addClass('active');
            
            $('#tab-protections, #tab-konfigurasi, #tab-massal, #tab-branding').fadeOut(200);
            $('#tab-' + tabId).delay(200).fadeIn(300);
        },
        
        updateStats: function() {
            const active = $('.toggle-protect:checked').length;
            const inactive = this.config.totalProtects - active;
            
            this.animateValue($('#activeProtects'), parseInt($('#activeProtects').text()) || 0, active);
            this.animateValue($('#inactiveProtects'), parseInt($('#inactiveProtects').text()) || this.config.totalProtects, inactive);
            this.animateValue($('#activeCount'), parseInt($('#activeCount').text()) || 0, active);
            
            const $badge = $('#statusBadge');
            if (active === this.config.totalProtects) {
                $badge.html('🛡️ FULL PROTECTION - 14/14');
                $badge.css('background', 'var(--gradient-4)');
            } else if (active > 0) {
                $badge.html('⚠️ PARTIAL - ' + active + '/14');
                $badge.css('background', 'var(--gradient-5)');
            } else {
                $badge.html('🔓 NO PROTECTION - 0/14');
                $badge.css('background', 'rgba(255,255,255,0.1)');
            }
        },
        
        animateValue: function($el, start, end) {
            const duration = 500;
            const startTime = performance.now();
            
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const value = Math.floor(start + (end - start) * progress);
                
                $el.text(value);
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };
            
            requestAnimationFrame(animate);
        },
        
        initAnimations: function() {
            $('.animate-in').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
            });
        },
        
        pulseElement: function($el) {
            $el.css('transform', 'scale(1.02)');
            setTimeout(() => {
                $el.css('transform', 'scale(1)');
            }, 300);
        },
        
        showLoading: function($el) {
            $el.css('opacity', '0.7');
        },
        
        hideLoading: function($el) {
            $el.css('opacity', '1');
        },
        
        showToast: function(type, message) {
            if (typeof Swal !== 'undefined') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: this.config.toastDuration,
                    timerProgressBar: true,
                    background: '#1a1a2e',
                    color: '#fff',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                
                Toast.fire({ icon: type, title: message });
            }
        },
        
        bulkInstall: function() {
            Swal.fire({
                title: 'Konfirmasi Bulk Install',
                text: 'Anda akan mengaktifkan SEMUA 14 proteksi. Lanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Install Semua!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/protect-manager/bulk/install',
                        type: 'POST',
                        data: { _token: $('meta[name="csrf-token"]').attr('content') },
                        success: () => location.reload(),
                        error: (xhr) => {
                            Swal.fire({ icon: 'error', title: 'Gagal!', text: xhr.responseJSON?.message, background: '#1a1a2e', color: '#fff' });
                        }
                    });
                }
            });
        },
        
        bulkUninstall: function() {
            Swal.fire({
                title: 'Konfirmasi Bulk Uninstall',
                text: 'Anda akan menonaktifkan SEMUA 14 proteksi. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Uninstall Semua!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/protect-manager/bulk/uninstall',
                        type: 'POST',
                        data: { _token: $('meta[name="csrf-token"]').attr('content') },
                        success: () => location.reload(),
                        error: (xhr) => {
                            Swal.fire({ icon: 'error', title: 'Gagal!', text: xhr.responseJSON?.message, background: '#1a1a2e', color: '#fff' });
                        }
                    });
                }
            });
        }
        
    };
    
    $(document).ready(function() {
        ProtectManager.init();
    });
    
    window.ProtectManager = ProtectManager;
    
})(jQuery, window, document);