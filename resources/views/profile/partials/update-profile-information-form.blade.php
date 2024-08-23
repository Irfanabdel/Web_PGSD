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
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Nama Sekolah -->
        <div>
            <x-input-label for="school_name" :value="__('Nama Sekolah')" />
            <select name="school_name" id="school_name" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5">
                <!-- Menampilkan kelas lama yang sudah dipilih -->
                <option value="{{ $user->school_name }}" selected>{{ $user->school_name }}</option>
                <!-- Opsi kelas lainnya -->
                <option value="SD A" {{ old('school_name') == 'SD A' ? 'selected' : '' }}>SD A</option>
                <option value="SD B" {{ old('school_name') == 'SD B' ? 'selected' : '' }}>SD B</option>
                <option value="SD C" {{ old('school_name') == 'SD C' ? 'selected' : '' }}>SD C</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('school_name')" />
        </div>

        <!-- Kelas -->
        <div>
            <x-input-label for="kelas" :value="__('Kelas')" />
            <select name="kelas" id="kelas" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5">
                <!-- Menampilkan kelas lama yang sudah dipilih -->
                <option value="{{ $user->kelas }}" selected>{{ $user->kelas }}</option>
                <!-- Opsi kelas lainnya -->
                <option value="1" {{ old('kelas') == '1' ? 'selected' : '' }}>1</option>
                <option value="2" {{ old('kelas') == '2' ? 'selected' : '' }}>2</option>
                <option value="3" {{ old('kelas') == '3' ? 'selected' : '' }}>3</option>
                <option value="4" {{ old('kelas') == '4' ? 'selected' : '' }}>4</option>
                <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>5</option>
                <option value="6" {{ old('kelas') == '6' ? 'selected' : '' }}>6</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('kelas')" />
        </div>


        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" :value="old('email', $user->email)" required autocomplete="username" />
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