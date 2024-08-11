<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mb-4">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" id="role" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" onchange="toggleAdditionalFields()">
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Token (Conditional) -->
        <div id="additional-fields" class="hidden mb-4">
            <x-input-label for="token" :value="__('Masukkan Token')" />
            <x-text-input id="token" class="block mt-1 w-full" type="text" name="token" :value="old('token')" />
            <x-input-error :messages="$errors->get('token')" class="mt-2" />
        </div>

        <!-- School Name -->
        <div class="mb-4">
            <x-input-label for="school_name" :value="__('Nama Sekolah')" />
            <x-text-input id="school_name" class="block mt-1 w-full" type="text" name="school_name" :value="old('school_name')" required />
            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
        </div>

        <!-- Kelas -->
        <div class="mb-4">
            <x-input-label for="kelas" :value="__('Kelas')" />
            <select name="kelas" id="kelas" class="block w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                <option value="kelas 2">Kelas 2</option>
                <option value="kelas 3">Kelas 3</option>
            </select>
            <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Kata sandi')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata sandi')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Sudah memiliki akun?') }}
            </a>

            <x-primary-button class="ms-3 bg-red-500 hover:bg-red-800">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function toggleAdditionalFields() {
            var role = document.getElementById('role').value;
            var additionalFields = document.getElementById('additional-fields');

            if (role === 'guru') {
                additionalFields.classList.remove('hidden');
            } else {
                additionalFields.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>