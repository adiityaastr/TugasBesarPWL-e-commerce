<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-[70vh] flex items-center justify-center">
        <div class="w-full max-w-lg">
            <div id="login-card" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 relative overflow-hidden">
                <div class="flex flex-col items-center mb-6">
                    <div class="relative h-20 w-20">
                        <svg id="mascot" viewBox="0 0 120 120" class="h-20 w-20">
                            <defs>
                                <linearGradient id="leafGrad" x1="0%" x2="100%" y1="0%" y2="100%">
                                    <stop offset="0%" stop-color="#0f9b57"/>
                                    <stop offset="100%" stop-color="#0b5c2c"/>
                                </linearGradient>
                            </defs>
                            <path d="M60 10 C30 25 20 55 35 80 C45 97 65 105 82 95 C100 83 105 55 90 32 C80 17 69 11 60 10 Z" fill="url(#leafGrad)" stroke="#0b5c2c" stroke-width="2"/>
                            <g id="mascot-eyes-open" class="mascot-eye">
                                <circle cx="50" cy="55" r="5" fill="#1f2937"/>
                                <circle cx="72" cy="55" r="5" fill="#1f2937"/>
                            </g>
                            <g id="mascot-eyes-closed" class="hidden mascot-eye" stroke="#1f2937" stroke-width="2" stroke-linecap="round">
                                <line x1="45" y1="55" x2="55" y2="55"/>
                                <line x1="67" y1="55" x2="77" y2="55"/>
                            </g>
                            <path d="M50 70 Q60 78 70 70" stroke="#1f2937" stroke-width="2" fill="none" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-gray-900">Masuk ke HerbaMart</h1>
                    <p class="text-gray-600 text-sm mt-1">Akses katalog dan keranjang Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-800" />
                        <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg focus:ring-[#0b5c2c] focus:border-[#0b5c2c]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-800" />
                        <div class="relative mt-1">
                            <x-text-input id="password" class="block w-full border-gray-300 rounded-lg pr-12 focus:ring-[#0b5c2c] focus:border-[#0b5c2c]"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-[#0b5c2c] focus:outline-none">
                                <span id="eye-open" class="hidden" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </span>
                                <span id="eye-closed" class="" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 3l18 18"/>
                                        <path d="M10.58 10.58a3 3 0 0 0 3.84 3.84"/>
                                        <path d="M9.88 5.09A10.94 10.94 0 0 1 12 5c7 0 11 7 11 7a15.62 15.62 0 0 1-2.64 3.19"/>
                                        <path d="M6.61 6.61A11.06 11.06 0 0 0 1 12s4 7 11 7a10.94 10.94 0 0 0 2.88-.39"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0b5c2c] shadow-sm focus:ring-[#0b5c2c]" name="remember">
                            <span class="ms-2 text-sm text-gray-700">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-[#0b5c2c] hover:text-[#0a4a24]" href="{{ route('password.request') }}">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-[#0b5c2c] font-medium">
                            Belum punya akun? Daftar
                        </a>
                        <x-primary-button class="bg-[#0b5c2c] hover:bg-[#0a4a24] focus:ring-[#0b5c2c]">
                            Masuk
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes mascot-blink {
            0%, 90%, 100% { transform: scaleY(1); }
            92%, 98% { transform: scaleY(0.1); }
        }
        @keyframes mascot-shake {
            0%,100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            50% { transform: translateX(6px); }
            75% { transform: translateX(-4px); }
        }
        .mascot-eye { transform-origin: center center; }
        .mascot-blink { animation: mascot-blink 4s infinite ease-in-out; }
        .mascot-shake { animation: mascot-shake 0.45s ease; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pwd = document.getElementById('password');
            const toggle = document.getElementById('toggle-password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            const eyesOpenMascot = document.getElementById('mascot-eyes-open');
            const eyesClosedMascot = document.getElementById('mascot-eyes-closed');
            const mascotSvg = document.getElementById('mascot');
            const loginCard = document.getElementById('login-card');
            const errorsPresent = {{ $errors->any() ? 'true' : 'false' }};

            const setState = (show) => {
                if (show) {
                    pwd.type = 'text';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                    eyesOpenMascot?.classList.remove('hidden');
                    eyesClosedMascot?.classList.add('hidden');
                } else {
                    pwd.type = 'password';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                    eyesOpenMascot?.classList.add('hidden');
                    eyesClosedMascot?.classList.remove('hidden');
                }
            };

            toggle?.addEventListener('click', () => {
                setState(pwd.type === 'password');
            });

            // Mata mengikuti kursor
            const updateEyeDirection = (evt) => {
                if (!loginCard || !eyesOpenMascot) return;
                const rect = loginCard.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const dx = Math.max(-6, Math.min(6, (evt.clientX - centerX) / 20));
                const dy = Math.max(-6, Math.min(6, (evt.clientY - centerY) / 20));
                eyesOpenMascot.style.transform = `translate(${dx}px, ${dy}px)`;
            };

            loginCard?.addEventListener('mousemove', updateEyeDirection);
            loginCard?.addEventListener('mouseleave', () => {
                if (eyesOpenMascot) eyesOpenMascot.style.transform = 'translate(0px, 0px)';
            });

            // Tutup mata saat fokus/ketik password, buka saat fokus email
            const emailInput = document.getElementById('email');
            emailInput?.addEventListener('focus', () => setState(true));
            pwd?.addEventListener('focus', () => setState(false));
            pwd?.addEventListener('input', () => setState(false));
            emailInput?.addEventListener('input', () => setState(true));

            // Blink ringan
            const startBlink = () => {
                eyesOpenMascot?.classList.add('mascot-blink');
            };
            startBlink();

            // Animasi gagal saat ada error validasi
            const triggerFail = () => {
                loginCard?.classList.add('mascot-shake');
                setTimeout(() => loginCard?.classList.remove('mascot-shake'), 500);
            };
            if (errorsPresent) {
                setTimeout(triggerFail, 150);
            }

            // Default: hidden state
            setState(false);
        });
    </script>
</x-guest-layout>
