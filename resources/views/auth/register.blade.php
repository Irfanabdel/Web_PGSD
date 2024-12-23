<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mb-4">
            <x-input-label for="role" :value="__('Peran')" />
            <select name="role" id="role" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" onchange="toggleAdditionalFields()">
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Token (Conditional) -->
        <div id="additional-fields" class="hidden mb-4">
            <x-input-label for="token" :value="__('Masukkan Token')" />
            <x-text-input id="token" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" type="text" name="token" :value="old('token')" />
            <x-input-error :messages="$errors->get('token')" class="mt-2" />
        </div>

        <!-- School Name -->
        <div class="mb-4">
            <x-input-label for="school_name" :value="__('Nama Sekolah')" />
            <select name="school_name" id="school_name" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5">
                <option value="SD A">SD A</option>
                <option value="SD B">SD B</option>
                <option value="SD C">SD C</option>
            </select>
            <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
        </div>

        <!-- Kelas -->
        <div class="mb-4">
            <x-input-label for="kelas" :value="__('Kelas')" />
            <select name="kelas" id="kelas" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
            <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Kata sandi')" />
            <x-text-input id="password" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata sandi')" />
            <x-text-input id="password_confirmation" class="block w-full mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 p-2.5" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a class="underline text-sm text-gray-600 hover:text-yellow-500" href="{{ route('login') }}">
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