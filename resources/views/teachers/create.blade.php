    <x-app-layout title="Tambah Modul Guru">
        <div class="p-6 sm:ml-64 pt-8">
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Tambah Modul</h1>
                <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Pilih Modul -->
                    <div class="mb-4">
                        <label for="theme_id" class="block text-sm font-medium text-gray-900 mb-2">Pilih Tema</label>
                        <select name="theme_id" id="theme_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih Tema</option>
                            @foreach($themes as $theme)
                            <option value="{{ $theme->id }}" data-dimensions="{{ $theme->dimensions_text }}" {{ isset($learningData['theme_id']) && $learningData['theme_id'] == $theme->id ? 'selected' : '' }}>
                                {{ $theme->title }}
                            </option>
                            @endforeach
                        </select>
                        @error('theme_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas Selection -->
                    <div class="mb-4">
                        <label for="user_kelas" class="block text-sm font-medium text-gray-900 mb-2">Kelas</label>
                        <select name="user_kelas" id="user_kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            @foreach($kelas as $kelasItem)
                            <option value="{{ $kelasItem }}" {{ isset($learningData['user_kelas']) && $learningData['user_kelas'] == $kelasItem ? 'selected' : '' }}>
                                {{ $kelasItem }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_kelas')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Deskripsi -->
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Modul</label>
                        <textarea name="description" id="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required></textarea>
                    </div>

                    <!-- Unggah file Modul Guru -->
                    <div id="teacher-files-section" class="p-4 border border-gray-300 rounded-lg mb-6">
                        <label class="block text-sm font-medium text-gray-700">Unggah Modul Guru</label>
                        <div class="flex flex-col space-y-4" id="teacher-files-container">
                            <div class="flex items-center space-x-2">
                                <input type="file" name="files" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file modul guru. Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                        @error('files.*')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </x-app-layout>