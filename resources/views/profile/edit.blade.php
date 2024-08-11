<x-app-layout>
    <div class="px-4 sm:ml-64">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                <!-- Gambar Profil atau Icon -->
                <div class="p-6 sm:p-8 bg-white shadow-lg rounded-lg border border-gray-200">
                    <div class="flex items-center space-x-4 mb-6">
                        @if (auth()->user()->image)
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile Image" class="w-24 h-24 rounded-full border border-gray-300 object-cover">
                        @else
                        <div class="w-24 h-24 rounded-full border border-gray-300 flex items-center justify-center bg-gray-200">
                            <!-- Ikon Orang Kosong -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zM4.5 18.75A6.75 6.75 0 0112 12a6.75 6.75 0 017.5 6.75" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Formulir Unggah atau Ganti Gambar Profil -->
                    <form action="{{ route('profile.updateImage') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                {{ __('Upload') }}
                            </button>
                        </div>
                    </form>

                    <!-- Tombol Hapus Foto -->
                    @if (auth()->user()->image)
                    <form action="{{ route('profile.deleteImage') }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                            {{ __('Delete Photo') }}
                        </button>
                    </form>
                    @endif
                </div>


                <!-- Update Profile Information Form -->
                <div class="p-6 sm:p-8 bg-white shadow-lg rounded-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ __('Update Profile Information') }}
                    </h3>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Form -->
                <div class="p-6 sm:p-8 bg-white shadow-lg rounded-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        {{ __('Update Password') }}
                    </h3>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Form -->
                <div class="p-6 sm:p-8 bg-white shadow-lg rounded-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-red-600 mb-4">
                        {{ __('Delete Account') }}
                    </h3>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>