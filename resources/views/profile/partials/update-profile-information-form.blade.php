<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbaharui data diri jika ada kesalahan saat daftar !") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Nama Sekolah -->
        <div>
            <x-input-label for="school_name" :value="__('Nama Sekolah')" />
            <x-text-input id="school_name" name="school_name" type="text" class="mt-1 block w-full" :value="old('school_name', $user->school_name)" required autocomplete="school_name" />
            <x-input-error class="mt-2" :messages="$errors->get('school_name')" />
        </div>

        <!-- Kelas -->
        <div>
            <x-input-label for="kelas" :value="__('Kelas')" />
            <select name="kelas" id="kelas" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                <!-- Menampilkan kelas lama yang sudah dipilih -->
                <option value="{{ $user->kelas }}" selected>{{ $user->kelas }}</option>
                <!-- Opsi kelas lainnya -->
                <option value="kelas 2" {{ old('kelas') == 'kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                <option value="kelas 3" {{ old('kelas') == 'kelas 3' ? 'selected' : '' }}>Kelas 3</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('kelas')" />
        </div>


        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600">
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
            <x-primary-button class="ms-3 bg-red-500 hover:bg-red-700">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>