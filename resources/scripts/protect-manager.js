/**
 * ╔══════════════════════════════════════════════════════════════╗
 * ║     🛡️ PROTECT MANAGER v2.0 - CANVA EDITION                ║
 * ║     👑 KALL XTREME X untuk MULIA                           ║
 * ║     📁 File: resources/scripts/protect-manager.js          ║
 * ╚══════════════════════════════════════════════════════════════╝
 * 
 * @description JavaScript untuk Protect Manager Pterodactyl Panel
 * @author KALL XTREME X
 * @version 2.0.0 Canva Edition
 * @license Proprietary
 */

;(function($, window, document, undefined) {
    'use strict';

    // ============================================================
    // PROTECT MANAGER OBJECT
    // ============================================================
    const ProtectManager = {

        // ----------------------------------------------------------
        // CONFIGURATION
        // ----------------------------------------------------------
        config: {
            totalProtects: 14,
            animationDuration: 400,
            toastDuration: 3000,
            apiBaseUrl: '/admin/protect-manager',
            csrfToken: null,
            isRootAdmin: false,
            debug: false
        },

        // ----------------------------------------------------------
        // STATE
        // ----------------------------------------------------------
        state: {
            activeProtects: 0,
            inactiveProtects: 14,
            currentTab: 'protections',
            isUpdating: false,
            searchQuery: '',
            activeFilters: []
        },

        // ----------------------------------------------------------
        // DOM REFERENCES (Cached)
        // ----------------------------------------------------------
        dom: {},

        // ============================================================
        // INITIALIZATION
        // ============================================================
        init: function(options) {
            // Merge options
            if (options) {
                $.extend(this.config, options);
            }

            // Get CSRF token
            this.config.csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            // Check if Root Admin
            this.config.isRootAdmin = this.detectRootAdmin();

            // Cache DOM elements
            this.cacheDom();

            // Bind all events
            this.bindEvents();

            // Initialize features
            this.initSearchFilter();
            this.initKeyboardShortcuts();
            this.initTooltips();
            this.initLazyAnimations();
            this.restoreTabState();
            this.updateStats();

            // Log initialization
            this.log('🚀 Protect Manager v2.0 Canva Edition initialized!');
            this.log('👑 Root Admin:', this.config.isRootAdmin ? 'YES' : 'NO');
            this.log('💡 Ketik ProtectManager.help() untuk melihat perintah.');

            // Expose public API
            this.exposePublicAPI();
        },

        // ----------------------------------------------------------
        // DETECT ROOT ADMIN
        // ----------------------------------------------------------
        detectRootAdmin: function() {
            // Try to detect from the page
            const adminId = $('#adminId').val() || 
                           $('.pm-admin-badge').text().replace('ID: ', '') ||
                           null;
            
            if (adminId && parseInt(adminId) === 1) {
                return true;
            }

            // Check if toggles are disabled
            const firstToggle = $('.toggle-protect').first();
            if (firstToggle.length && !firstToggle.prop('disabled')) {
                return true;
            }

            return false;
        },

        // ----------------------------------------------------------
        // CACHE DOM ELEMENTS
        // ----------------------------------------------------------
        cacheDom: function() {
            this.dom = {
                // Stats
                activeProtectsEl: $('#activeProtects'),
                inactiveProtectsEl: $('#inactiveProtects'),
                activeCountEl: $('#activeCount'),
                statusBadge: $('#statusBadge'),
                statusText: $('#statusText'),
                statusFill: $('#statusFill'),
                tabActiveCount: $('#tabActiveCount'),

                // Cards
                protectCards: $('.pm-protect-card'),
                toggleSwitches: $('.toggle-protect'),

                // Tabs
                tabs: $('.pm-tab'),
                tabProtections: $('#tab-protections'),
                tabKonfigurasi: $('#tab-konfigurasi'),
                tabMassal: $('#tab-massal'),
                tabBranding: $('#tab-branding'),

                // Search
                searchInput: $('#searchProtect'),
                noResults: $('#noResults'),
                protectGrid: $('#protectCards'),

                // Buttons
                bulkInstallBtn: $('.bulk-install-btn'),
                bulkUninstallBtn: $('.bulk-uninstall-btn'),
                saveConfigBtn: $('#saveConfigBtn'),

                // Toast
                toastContainer: $('#toastContainer')
            };
        },

        // ----------------------------------------------------------
        // BIND EVENTS
        // ----------------------------------------------------------
        bindEvents: function() {
            const self = this;

            // Toggle protection switches
            $(document).on('change', '.toggle-protect', function(e) {
                self.handleToggle($(this), e);
            });

            // Tab navigation
            $(document).on('click', '.pm-tab', function(e) {
                e.preventDefault();
                self.switchTab($(this));
            });

            // Search filter
            if (this.dom.searchInput.length) {
                this.dom.searchInput.on('keyup', $.debounce(300, function() {
                    self.filterProtects($(this).val());
                }));
            }

            // Window resize handler
            $(window).on('resize', $.debounce(250, function() {
                self.handleResize();
            }));

            // Keyboard escape to clear search
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    self.clearSearch();
                }
            });

            // Before unload - save state
            $(window).on('beforeunload', function() {
                self.saveState();
            });
        },

        // ============================================================
        // TOGGLE PROTECTION HANDLER
        // ============================================================
        handleToggle: function($toggle, event) {
            const self = this;
            
            // Prevent multiple simultaneous updates
            if (this.state.isUpdating) {
                $toggle.prop('checked', !$toggle.is(':checked'));
                this.showToast('warning', '⏳ Tunggu sebentar...');
                return;
            }

            const protectId = $toggle.attr('name');
            const protectName = $toggle.data('name') || protectId;
            const isChecked = $toggle.is(':checked');
            const status = isChecked ? 1 : 0;
            const $card = $('#card-' + protectId);

            // Validate
            if (!protectId) {
                this.log('ERROR: No protect ID found on toggle');
                return;
            }

            // Lock state
            this.state.isUpdating = true;
            $toggle.prop('disabled', true);
            this.showCardLoading($card);

            // Optimistic UI update
            this.updateCardUI($card, isChecked);

            // Send AJAX request
            $.ajax({
                url: this.config.apiBaseUrl + '/toggle',
                type: 'POST',
                dataType: 'json',
                data: {
                    protect: protectId,
                    status: status,
                    _token: this.config.csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        // Update stats with animation
                        self.updateStats();
                        
                        // Show success toast
                        self.showToast('success', 
                            '✅ ' + protectName + ' berhasil ' + 
                            (isChecked ? 'diaktifkan' : 'dinonaktifkan') + '!'
                        );
                        
                        // Pulse animation on card
                        self.pulseElement($card);
                        
                        // Log
                        self.log('Toggle:', protectId, '->', isChecked ? 'ON' : 'OFF');
                        
                        // Dispatch custom event
                        $(document).trigger('protect:toggled', {
                            id: protectId,
                            status: isChecked,
                            name: protectName
                        });
                    } else {
                        // Revert on failure
                        self.revertToggle($toggle, $card, !isChecked);
                        self.showToast('error', '❌ Gagal: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    // Revert on error
                    self.revertToggle($toggle, $card, !isChecked);
                    
                    let errorMsg = 'Terjadi kesalahan server';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.status === 403) {
                        errorMsg = 'Akses ditolak! Hanya Root Admin yang bisa mengubah proteksi.';
                    } else if (xhr.status === 419) {
                        errorMsg = 'Session expired. Silakan refresh halaman.';
                    } else if (xhr.status === 500) {
                        errorMsg = 'Internal server error. Coba lagi nanti.';
                    }
                    
                    self.showToast('error', '❌ ' + errorMsg);
                    self.log('ERROR:', error, xhr.status);
                },
                complete: function() {
                    // Unlock state
                    $toggle.prop('disabled', false);
                    self.hideCardLoading($card);
                    self.state.isUpdating = false;
                }
            });
        },

        // ----------------------------------------------------------
        // REVERT TOGGLE
        // ----------------------------------------------------------
        revertToggle: function($toggle, $card, previousState) {
            $toggle.prop('checked', previousState);
            this.updateCardUI($card, previousState);
            this.updateStats();
        },

        // ----------------------------------------------------------
        // UPDATE CARD UI
        // ----------------------------------------------------------
        updateCardUI: function($card, isActive) {
            const $badge = $card.find('.pm-badge-status');
            const $iconWrapper = $card.find('.pm-protect-icon-wrapper');
            const $badgeDot = $card.find('.pm-badge-dot');

            if (isActive) {
                $card.addClass('active-protect');
                $iconWrapper.addClass('active');
                $badge.css('background', 'var(--gradient-4)');
                $badge.html('<span class="pm-badge-dot active"></span> AKTIF');
            } else {
                $card.removeClass('active-protect');
                $iconWrapper.removeClass('active');
                $badge.css('background', 'rgba(255,255,255,0.1)');
                $badge.html('<span class="pm-badge-dot"></span> NONAKTIF');
            }
        },

        // ----------------------------------------------------------
        // CARD LOADING STATE
        // ----------------------------------------------------------
        showCardLoading: function($card) {
            $card.addClass('pm-loading');
        },

        hideCardLoading: function($card) {
            $card.removeClass('pm-loading');
        },

        // ============================================================
        // STATISTICS UPDATE
        // ============================================================
        updateStats: function() {
            const active = $('.toggle-protect:checked').length;
            const total = this.config.totalProtects;
            const inactive = total - active;
            const percentage = Math.round((active / total) * 100);

            // Update state
            this.state.activeProtects = active;
            this.state.inactiveProtects = inactive;

            // Animate number changes
            this.animateNumber(this.dom.activeProtectsEl, active);
            this.animateNumber(this.dom.inactiveProtectsEl, inactive);
            this.animateNumber(this.dom.activeCountEl, active);
            
            // Update tab count
            if (this.dom.tabActiveCount.length) {
                this.dom.tabActiveCount.text(active);
            }

            // Update status fill bar
            if (this.dom.statusFill.length) {
                this.dom.statusFill.css('width', percentage + '%');
            }

            // Update status badge
            this.updateStatusBadge(active, total);

            // Update button states
            this.updateButtonStates(active, total);

            return { active, inactive, percentage };
        },

        // ----------------------------------------------------------
        // UPDATE STATUS BADGE
        // ----------------------------------------------------------
        updateStatusBadge: function(active, total) {
            const $badge = this.dom.statusBadge;
            const $text = this.dom.statusText;
            const $fill = this.dom.statusFill;

            if (!$text.length) return;

            if (active === total) {
                $text.html('🛡️ FULL PROTECTION - ' + active + '/' + total);
                if ($badge.length) {
                    $badge.css('border-color', 'rgba(67, 233, 123, 0.5)');
                }
                if ($fill.length) {
                    $fill.css('background', 'var(--gradient-4)');
                }
            } else if (active > 0) {
                $text.html('⚠️ PARTIAL - ' + active + '/' + total);
                if ($badge.length) {
                    $badge.css('border-color', 'rgba(250, 112, 154, 0.5)');
                }
                if ($fill.length) {
                    $fill.css('background', 'var(--gradient-5)');
                }
            } else {
                $text.html('🔓 NO PROTECTION - 0/' + total);
                if ($badge.length) {
                    $badge.css('border-color', 'rgba(255,255,255,0.2)');
                }
                if ($fill.length) {
                    $fill.css('background', 'rgba(255,255,255,0.2)');
                }
            }
        },

        // ----------------------------------------------------------
        // UPDATE BUTTON STATES
        // ----------------------------------------------------------
        updateButtonStates: function(active, total) {
            if (active === total) {
                this.dom.bulkInstallBtn.prop('disabled', true);
                this.dom.bulkUninstallBtn.prop('disabled', false);
            } else if (active === 0) {
                this.dom.bulkInstallBtn.prop('disabled', false);
                this.dom.bulkUninstallBtn.prop('disabled', true);
            } else {
                this.dom.bulkInstallBtn.prop('disabled', false);
                this.dom.bulkUninstallBtn.prop('disabled', false);
            }
        },

        // ----------------------------------------------------------
        // ANIMATE NUMBER
        // ----------------------------------------------------------
        animateNumber: function($element, newValue) {
            if (!$element || !$element.length) return;

            const currentValue = parseInt($element.text()) || 0;
            
            if (currentValue === newValue) return;

            const duration = 400;
            let startTime = null;

            const animate = (currentTime) => {
                if (!startTime) startTime = currentTime;
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (ease-out)
                const eased = 1 - Math.pow(1 - progress, 3);
                const value = Math.round(currentValue + (newValue - currentValue) * eased);
                
                $element.text(value);
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };

            requestAnimationFrame(animate);
        },

        // ============================================================
        // TAB NAVIGATION
        // ============================================================
        switchTab: function($tab) {
            const tabId = $tab.data('tab');
            
            if (!tabId || this.state.currentTab === tabId) return;

            // Update active tab
            this.dom.tabs.removeClass('active');
            $tab.addClass('active');

            // Hide all tab content
            this.dom.tabProtections.fadeOut(150);
            this.dom.tabKonfigurasi.fadeOut(150);
            this.dom.tabMassal.fadeOut(150);
            this.dom.tabBranding.fadeOut(150);

            // Show selected tab with delay
            const targetTab = $('#tab-' + tabId);
            setTimeout(() => {
                targetTab.fadeIn(250);
            }, 150);

            // Update state
            this.state.currentTab = tabId;
            this.saveTabState(tabId);
        },

        // ----------------------------------------------------------
        // SAVE/RESTORE TAB STATE
        // ----------------------------------------------------------
        saveTabState: function(tabId) {
            try {
                localStorage.setItem('pmActiveTab', tabId);
            } catch (e) {
                // localStorage not available
            }
        },

        restoreTabState: function() {
            try {
                const savedTab = localStorage.getItem('pmActiveTab');
                if (savedTab && savedTab !== 'protections') {
                    const $tab = $('.pm-tab[data-tab="' + savedTab + '"]');
                    if ($tab.length) {
                        $tab.trigger('click');
                    }
                }
            } catch (e) {
                // localStorage not available
            }
        },

        // ============================================================
        // SEARCH & FILTER
        // ============================================================
        initSearchFilter: function() {
            if (!this.dom.searchInput.length) return;

            // Clear search on page load
            this.dom.searchInput.val('');
        },

        filterProtects: function(query) {
            this.state.searchQuery = query.toLowerCase().trim();
            let visibleCount = 0;

            if (!this.state.searchQuery) {
                // Show all
                this.dom.protectCards.show();
                this.dom.noResults.hide();
                this.dom.protectGrid.show();
                return;
            }

            this.dom.protectCards.each((index, card) => {
                const $card = $(card);
                const cardText = $card.text().toLowerCase();
                const category = $card.data('category') || '';
                
                if (cardText.includes(this.state.searchQuery) || 
                    category.toLowerCase().includes(this.state.searchQuery)) {
                    $card.show();
                    visibleCount++;
                } else {
                    $card.hide();
                }
            });

            // Show/hide no results
            if (visibleCount === 0) {
                this.dom.protectGrid.hide();
                this.dom.noResults.fadeIn(200);
            } else {
                this.dom.noResults.hide();
                this.dom.protectGrid.show();
            }
        },

        clearSearch: function() {
            if (this.dom.searchInput.length) {
                this.dom.searchInput.val('');
                this.filterProtects('');
            }
        },

        // ============================================================
        // BULK OPERATIONS
        // ============================================================
        bulkInstall: function() {
            const self = this;

            if (!this.config.isRootAdmin) {
                this.showToast('error', '❌ Hanya Root Admin yang bisa melakukan bulk install!');
                return;
            }

            Swal.fire({
                title: '🚀 Konfirmasi Bulk Install',
                html: `
                    <p>Anda akan <strong>mengaktifkan SEMUA ${this.config.totalProtects} proteksi</strong> sekaligus.</p>
                    <p style="color: var(--text-muted); font-size: 0.9em;">
                        Ini akan mengamankan panel secara penuh.
                    </p>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-shield-haltered"></i> Ya, Install Semua!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff',
                confirmButtonColor: '#43e97b',
                cancelButtonColor: '#F43F5E'
            }).then((result) => {
                if (result.isConfirmed) {
                    self.executeBulkAction('install');
                }
            });
        },

        bulkUninstall: function() {
            const self = this;

            if (!this.config.isRootAdmin) {
                this.showToast('error', '❌ Hanya Root Admin yang bisa melakukan bulk uninstall!');
                return;
            }

            Swal.fire({
                title: '⚠️ Konfirmasi Bulk Uninstall',
                html: `
                    <p>Anda akan <strong>menonaktifkan SEMUA ${this.config.totalProtects} proteksi</strong>.</p>
                    <p style="color: #F43F5E; font-weight: 600;">
                        ⚠️ Panel akan TIDAK TERLINDUNGI!
                    </p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-unlock"></i> Ya, Uninstall Semua!',
                cancelButtonText: 'Batal',
                background: '#1a1a2e',
                color: '#fff',
                confirmButtonColor: '#F43F5E',
                cancelButtonColor: '#666'
            }).then((result) => {
                if (result.isConfirmed) {
                    self.executeBulkAction('uninstall');
                }
            });
        },

        executeBulkAction: function(action) {
            const self = this;
            const actionText = action === 'install' ? 'mengaktifkan' : 'menonaktifkan';

            // Show loading
            Swal.fire({
                title: '⏳ Memproses...',
                text: 'Sedang ' + actionText + ' semua proteksi...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                background: '#1a1a2e',
                color: '#fff',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: this.config.apiBaseUrl + '/bulk/' + action,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: this.config.csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '✅ Berhasil!',
                            text: response.message,
                            timer: 2500,
                            showConfirmButton: false,
                            background: '#1a1a2e',
                            color: '#fff'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '❌ Gagal!',
                            text: response.message || 'Terjadi kesalahan',
                            background: '#1a1a2e',
                            color: '#fff'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Error!',
                        text: xhr.responseJSON?.message || 'Gagal melakukan bulk ' + action,
                        background: '#1a1a2e',
                        color: '#fff'
                    });
                }
            });
        },

        // ============================================================
        // KEYBOARD SHORTCUTS
        // ============================================================
        initKeyboardShortcuts: function() {
            const self = this;

            $(document).on('keydown', function(e) {
                // Ctrl/Cmd + S: Focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    self.dom.searchInput.focus();
                }

                // Ctrl/Cmd + 1-4: Switch tabs
                if ((e.ctrlKey || e.metaKey) && e.key >= '1' && e.key <= '4') {
                    e.preventDefault();
                    const tabIndex = parseInt(e.key) - 1;
                    const $tab = self.dom.tabs.eq(tabIndex);
                    if ($tab.length) {
                        $tab.trigger('click');
                    }
                }
            });
        },

        // ============================================================
        // TOOLTIPS
        // ============================================================
        initTooltips: function() {
            // Initialize Bootstrap tooltips if available
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(
                    document.querySelectorAll('[data-bs-toggle="tooltip"]')
                );
                tooltipTriggerList.map(function(el) {
                    return new bootstrap.Tooltip(el);
                });
            }
        },

        // ============================================================
        // LAZY ANIMATIONS
        // ============================================================
        initLazyAnimations: function() {
            // Animate elements when they come into view
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            $(entry.target).css('opacity', '1');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                $('.animate-in').each(function() {
                    observer.observe(this);
                });
            }
        },

        // ============================================================
        // UI UTILITIES
        // ============================================================
        pulseElement: function($el) {
            $el.css({
                'transform': 'scale(1.03)',
                'transition': 'transform 0.2s ease'
            });
            
            setTimeout(() => {
                $el.css('transform', 'scale(1)');
            }, 200);
            
            setTimeout(() => {
                $el.css('transition', '');
            }, 400);
        },

        handleResize: function() {
            // Update any responsive elements
            this.log('Window resized');
        },

        // ============================================================
        // TOAST NOTIFICATIONS
        // ============================================================
        showToast: function(type, message) {
            // Use SweetAlert2 if available
            if (typeof Swal !== 'undefined') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: this.config.toastDuration,
                    timerProgressBar: true,
                    background: '#1a1a2e',
                    color: '#fff',
                    iconColor: type === 'success' ? '#43e97b' : 
                               type === 'error' ? '#F43F5E' : 
                               type === 'warning' ? '#FFD93D' : '#45B7D1',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: type,
                    title: message
                });
            } else {
                // Fallback: console log
                this.log('Toast [' + type + ']:', message);
            }
        },

        // ============================================================
        // STATE MANAGEMENT
        // ============================================================
        saveState: function() {
            const state = {
                activeProtects: this.state.activeProtects,
                currentTab: this.state.currentTab,
                timestamp: Date.now()
            };

            try {
                localStorage.setItem('pmState', JSON.stringify(state));
            } catch (e) {
                // localStorage not available
            }
        },

        loadState: function() {
            try {
                const saved = localStorage.getItem('pmState');
                if (saved) {
                    const state = JSON.parse(saved);
                    this.state.activeProtects = state.activeProtects || 0;
                    this.state.currentTab = state.currentTab || 'protections';
                }
            } catch (e) {
                // Invalid JSON or not available
            }
        },

        // ============================================================
        // PUBLIC API
        // ============================================================
        exposePublicAPI: function() {
            // Make ProtectManager accessible globally
            window.ProtectManager = this;

            // Public methods
            window.ProtectManager.help = this.help;
            window.ProtectManager.getState = this.getState.bind(this);
            window.ProtectManager.refresh = this.refresh.bind(this);
            window.ProtectManager.reset = this.reset.bind(this);
        },

        help: function() {
            console.log('%c🛡️ Protect Manager v2.0 %c- Commands',
                'color: #8B5CF6; font-size: 1.2em; font-weight: bold;',
                'color: #fff;');
            console.log('%c─────────────────────────────────────', 'color: #666;');
            console.log('%cProtectManager.getState()%c - Lihat status saat ini',
                'color: #4ECDC4;', 'color: #fff;');
            console.log('%cProtectManager.refresh()%c - Refresh data',
                'color: #4ECDC4;', 'color: #fff;');
            console.log('%cProtectManager.reset()%c - Reset ke default',
                'color: #4ECDC4;', 'color: #fff;');
            console.log('%cProtectManager.bulkInstall()%c - Aktifkan semua proteksi',
                'color: #4ECDC4;', 'color: #fff;');
            console.log('%cProtectManager.bulkUninstall()%c - Nonaktifkan semua proteksi',
                'color: #4ECDC4;', 'color: #fff;');
        },

        getState: function() {
            console.log('%c📊 Protect Manager State:', 'color: #FFD93D; font-weight: bold;');
            console.log('  Active Protects:', this.state.activeProtects + '/' + this.config.totalProtects);
            console.log('  Current Tab:', this.state.currentTab);
            console.log('  Is Root Admin:', this.config.isRootAdmin);
            console.log('  Is Updating:', this.state.isUpdating);
            return this.state;
        },

        refresh: function() {
            this.log('🔄 Refreshing...');
            this.updateStats();
            this.showToast('info', '🔄 Data diperbarui');
        },

        reset: function() {
            this.log('🔄 Resetting...');
            this.clearSearch();
            this.dom.tabs.removeClass('active');
            this.dom.tabs.first().addClass('active');
            this.dom.tabProtections.show();
            this.dom.tabKonfigurasi.hide();
            this.dom.tabMassal.hide();
            this.dom.tabBranding.hide();
            this.state.currentTab = 'protections';
            this.updateStats();
            this.showToast('info', '🔄 Tampilan direset');
        },

        // ============================================================
        // LOGGING
        // ============================================================
        log: function(...args) {
            if (this.config.debug || window.location.hostname === 'localhost') {
                console.log('%c[PM v2.0]', 'color: #8B5CF6; font-weight: bold;', ...args);
            }
        }
    };

    // ============================================================
    // JQUERY PLUGINS
    // ============================================================
    
    // Debounce plugin
    $.debounce = function(delay, callback) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => callback.apply(this, args), delay);
        };
    };

    // ============================================================
    // DOCUMENT READY
    // ============================================================
    $(document).ready(function() {
        // Initialize Protect Manager
        ProtectManager.init();

        // Easter egg console message
        console.log('%c' + [
            '╔══════════════════════════════════════╗',
            '║  🛡️  PROTECT MANAGER v2.0           ║',
            '║  Canva Edition                      ║',
            '║  KALL XTREME X                      ║',
            '║  Dibuat untuk Mulia 👑              ║',
            '╚══════════════════════════════════════╝'
        ].join('\n'), 'color: #EC4899; font-family: monospace;');
    });

})(jQuery, window, document);