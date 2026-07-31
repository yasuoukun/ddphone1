<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DDPHONE ดีดีโฟน') }}</title>

        <!-- Favicon / Website Icon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logoddphone.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/logoddphone.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logoddphone.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Alpine.js CDN (Guarantees reactive dropdowns & UI components load) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- SweetAlert2 (admin toast notifications) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/theme.css') }}?v={{ filemtime(public_path('css/theme.css')) }}">
    </head>
    <body class="font-sans antialiased {{ auth()->check() && in_array(auth()->user()->role, ['admin', 'super_admin']) ? 'has-admin-bottom-nav' : '' }}">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Google Material Style Centered Multicolor Spinner (Admin Loader, Non-blocking) -->
        <style>
            @keyframes googleSpinnerRotate {
                100% {
                    transform: rotate(360deg);
                }
            }
            @keyframes googleSpinnerDash {
                0% {
                    stroke-dasharray: 1, 200;
                    stroke-dashoffset: 0;
                }
                50% {
                    stroke-dasharray: 130, 200;
                    stroke-dashoffset: -35px;
                }
                100% {
                    stroke-dasharray: 130, 200;
                    stroke-dashoffset: -160px;
                }
            }
            @keyframes googleSpinnerColors {
                0%, 100% { stroke: #4285F4; } /* Google Blue */
                25%      { stroke: #EA4335; } /* Google Red */
                50%      { stroke: #FBBC05; } /* Google Yellow */
                75%      { stroke: #34A853; } /* Google Green */
            }
            .google-center-spinner-wrapper {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 99999999;
                pointer-events: none;
                opacity: 1;
                visibility: visible;
                transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            .google-spinner {
                width: 68px;
                height: 68px;
                animation: googleSpinnerRotate 1.4s linear infinite;
                filter: drop-shadow(0 6px 16px rgba(0, 0, 0, 0.22));
            }
            .google-spinner-path {
                stroke-dasharray: 1, 200;
                stroke-dashoffset: 0;
                animation: googleSpinnerDash 1.4s ease-in-out infinite, googleSpinnerColors 5.6s ease-in-out infinite;
                stroke-linecap: round;
            }
        </style>

        <div id="admin-mini-loader" class="google-center-spinner-wrapper">
            <svg class="google-spinner" viewBox="25 25 50 50">
                <circle class="google-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"/>
            </svg>
        </div>

        <script>
            (function() {
                const loader = document.getElementById('admin-mini-loader');
                if (!loader) return;

                function showLoader() {
                    loader.style.visibility = 'visible';
                    loader.style.opacity = '1';
                    loader.style.transform = 'translate(-50%, -50%) scale(1)';
                }

                function hideLoader() {
                    setTimeout(() => {
                        loader.style.opacity = '0';
                        loader.style.transform = 'translate(-50%, -50%) scale(0.7)';
                        setTimeout(() => {
                            loader.style.visibility = 'hidden';
                        }, 250);
                    }, 150);
                }

                if (document.readyState === 'complete') {
                    hideLoader();
                } else {
                    window.addEventListener('load', hideLoader);
                }

                document.addEventListener('click', function(e) {
                    const link = e.target.closest('a');
                    if (link && link.href && !link.target && !link.hasAttribute('download') && !link.href.startsWith('javascript:') && !link.getAttribute('href').startsWith('#')) {
                        try {
                            const url = new URL(link.href, window.location.origin);
                            if (url.origin === window.location.origin && url.pathname !== window.location.pathname) {
                                showLoader();
                            }
                        } catch(err) {}
                    }
                });

                window.addEventListener('pageshow', function(e) {
                    if (e.persisted) {
                        hideLoader();
                    }
                });
            })();

            // Global Crystal-Clear Web Audio Manager for DDPHONE Notifications & Chat
            window.DDPhoneAudio = (function() {
                let ctx = null;

                function getAudioContext() {
                    if (!ctx) {
                        const AudioCtx = window.AudioContext || window.webkitAudioContext;
                        if (AudioCtx) {
                            ctx = new AudioCtx();
                        }
                    }
                    if (ctx && ctx.state === 'suspended') {
                        ctx.resume().catch(() => {});
                    }
                    return ctx;
                }

                const unlockEvents = ['click', 'touchstart', 'touchend', 'keydown', 'scroll', 'mousemove'];
                function unlockAudioContext() {
                    const audioCtx = getAudioContext();
                    if (audioCtx && audioCtx.state === 'running') {
                        unlockEvents.forEach(evt => window.removeEventListener(evt, unlockAudioContext, true));
                    }
                }
                unlockEvents.forEach(evt => window.addEventListener(evt, unlockAudioContext, true));

                function playNote(freq, startTime, duration, type = 'sine', maxVol = 0.25) {
                    const audioCtx = getAudioContext();
                    if (!audioCtx) return;

                    const triggerSound = () => {
                        try {
                            const osc = audioCtx.createOscillator();
                            const gain = audioCtx.createGain();

                            osc.type = type;
                            osc.frequency.setValueAtTime(freq, audioCtx.currentTime + startTime);

                            gain.gain.setValueAtTime(maxVol, audioCtx.currentTime + startTime);
                            gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + startTime + duration);

                            osc.connect(gain);
                            gain.connect(audioCtx.destination);

                            osc.start(audioCtx.currentTime + startTime);
                            osc.stop(audioCtx.currentTime + startTime + duration);
                        } catch(e) {
                            console.warn('Audio tone play error:', e);
                        }
                    };

                    if (audioCtx.state === 'suspended') {
                        audioCtx.resume().then(triggerSound).catch(() => {});
                    } else {
                        triggerSound();
                    }
                }

                return {
                    unlock() {
                        getAudioContext();
                    },
                    playNotification() {
                        playNote(783.99, 0, 0.18, 'sine', 0.25);
                        playNote(1046.50, 0.12, 0.22, 'sine', 0.28);
                        playNote(1318.51, 0.26, 0.35, 'sine', 0.30);
                    },
                    playChat() {
                        playNote(1046.50, 0, 0.12, 'sine', 0.22);
                        playNote(1567.98, 0.09, 0.22, 'sine', 0.25);
                    },
                    playRepair() {
                        // Distinct "wrench" tone — lower, punchy double-beep
                        playNote(523.25, 0, 0.14, 'square', 0.18);
                        playNote(659.25, 0.10, 0.14, 'square', 0.20);
                        playNote(783.99, 0.22, 0.25, 'sine', 0.24);
                    }
                };
            })();


        </script>
    </body>
</html>
