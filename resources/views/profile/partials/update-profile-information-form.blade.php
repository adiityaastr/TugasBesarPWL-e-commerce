<section>
    <header>
        <h2 class="text-lg font-medium text-[#0b5c2c]">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div>
            <x-input-label for="photo" :value="__('Foto Profil')" />
            <div class="mt-2 flex items-center gap-4">
                @if($user->profile_photo_path)
                    <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border border-gray-200">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                @endif
                <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#0b5c2c] hover:file:bg-green-100" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full focus:border-[#0b5c2c] focus:ring-[#0b5c2c]" :value="old('username', $user->username)" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Full Name -->
        <div>
            <x-input-label for="full_name" :value="__('Nama Lengkap (Untuk Data Pembelian)')" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full focus:border-[#0b5c2c] focus:ring-[#0b5c2c]" :value="old('full_name', $user->full_name)" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <!-- Name (Display Name) -->
        <div>
            <x-input-label for="name" :value="__('Nama Panggilan')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-[#0b5c2c] focus:ring-[#0b5c2c]" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:border-[#0b5c2c] focus:ring-[#0b5c2c]" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-[#0b5c2c] hover:bg-[#09481f] focus:bg-[#09481f] active:bg-[#06401b]">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
