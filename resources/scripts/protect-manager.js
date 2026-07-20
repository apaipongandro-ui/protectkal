/**
 * Protect Manager JavaScript
 * KALL XTREME X Edition
 * Dibuat untuk Mulia
 */

;(function($, window, document, undefined) {
    'use strict';
    
    var ProtectManager = {
        
        // Inisialisasi
        init: function() {
            this.bindEvents();
            this.updateStats();
            console.log('🛡️ Protect Manager v1.0 initialized');
            console.log('👑 KALL XTREME X at your service, Mulia!');
        },
        
        // Bind events
        bindEvents: function() {
            var self = this;
            
            // Toggle protection
            $(document).on('change', '.toggle-protect', function() {
                self.handleToggle($(this));
            });
            
            // Bulk select all
            $(document).on('click', '#selectAllProtects', function() {
                $('.toggle-protect').each(function() {
                    if (!$(this).is(':checked')) {
                        $(this).prop('checked', true).trigger('change');
                    }
                });
            });
            
            // Bulk deselect all
            $(document).on('click', '#deselectAllProtects', function() {
                $('.toggle-protect').each(function() {
                    if ($(this).is(':checked')) {
                        $(this).prop('checked', false).trigger('change');
                    }
                });
            });
        },
        
        // Handle toggle
        handleToggle: function($toggle) {
            var protect = $toggle.attr('name');
            var status = $toggle.is(':checked') ? 1 : 0;
            var $card = $toggle.closest('.protect-card');
            
            // Disable toggle selama proses
            $toggle.prop('disabled', true);
            
            $.ajax({
                url: '/admin/protect-manager/toggle',
                type: 'POST',
                data: {
                    protect: protect,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Update card style
                        if (status) {
                            $card.addClass('active-protect');
                        } else {
                            $card.removeClass('active-protect');
                        }
                        
                        // Update badge
                        var $badge = $card.find('.badge');
                        if (status) {
                            $badge.removeClass('badge-secondary').addClass('badge-success').text('AKTIF');
                        } else {
                            $badge.removeClass('badge-success').addClass('badge-secondary').text('NONAKTIF');
                        }
                        
                        // Update stats
                        ProtectManager.updateStats();
                        
                        // Show toast
                        ProtectManager.showToast('success', response.message);
                    }
                },
                error: function(xhr) {
                    // Revert toggle
                    $toggle.prop('checked', !status);
                    
                    var message = xhr.responseJSON?.message || 'Gagal mengubah proteksi';
                    ProtectManager.showToast('error', message);
                },
                complete: function() {
                    $toggle.prop('disabled', false);
                }
            });
        },
        
        // Update statistics
        updateStats: function() {
            var active = $('.toggle-protect:checked').length;
            var total = 14;
            var inactive = total - active;
            
            // Update counter
            $('#activeCount').text(active);
            $('#totalCount').text(total);
            
            // Update stat cards
            $('.bg-success h3').text(active);
            $('.bg-danger h3').text(inactive);
            
            // Update status badge
            var $badge = $('#statusBadge');
            if (active === total) {
                $badge.removeClass('badge-light badge-warning badge-danger')
                      .addClass('badge-success')
                      .html('🛡️ FULL PROTECTION - ' + active + '/' + total);
            } else if (active > 0) {
                $badge.removeClass('badge-light badge-success badge-danger')
                      .addClass('badge-warning')
                      .html('⚠️ PARTIAL - ' + active + '/' + total);
            } else {
                $badge.removeClass('badge-light badge-success badge-warning')
                      .addClass('badge-danger')
                      .html('🔓 NO PROTECTION - 0/' + total);
            }
        },
        
        // Show toast notification
        showToast: function(type, message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type,
                    title: message,
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        }
        
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        ProtectManager.init();
    });
    
    // Expose to global scope
    window.ProtectManager = ProtectManager;
    
})(jQuery, window, document);
