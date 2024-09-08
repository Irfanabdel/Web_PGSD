<x-app-layout title="Bahan Pembelajaran - Step 2">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <!-- Info Step -->
            <div class="flex justify-center items-center">
                <p class="text-2xl font-bold text-gray-900">
                    <span class="text-red-500">Step 2</span> dari 2
                </p>
            </div>
            <h1 class="text-2xl flex justify-center font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Bahan Pembelajaran</h1>
            <form action="{{ route('modules.store.step2') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Unggah file Modul Guru -->
                <div class="p-4 border border-gray-300 rounded-lg mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700">Unggah Modul Guru</label>
                    <input type="file" id="file" name="file" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <p class="mt-2 text-sm text-gray-500">Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                    @error('file')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unggah file Pembelajaran Siswa dengan input judul -->
                <div id="student-files-section" class="p-4 border border-gray-300 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Unggah Pembelajaran Siswa</label>
                    <div class="flex flex-col space-y-4" id="student-files-container">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="student_files_titles[]" placeholder="Judul" class="bg-gray-50 mt-1 block w-1/3 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <input type="file" name="student_files[]" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" class="text-red-600 hover:text-red-800 remove-file flex items-center">
                                <i class="fas fa-minus-circle mr-2"></i> Hapus
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center space-x-2">
                        <button type="button" id="add-student-file" class="text-blue-600 hover:text-blue-800 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah File
                        </button>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file pembelajaran untuk siswa. Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                    @error('student_files.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input untuk link -->
                <div id="links-section" class="p-4 border border-gray-300 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Link Pembelajaran</label>
                    <div class="flex flex-col space-y-2" id="links-container">
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" name="links[]" placeholder="https://example.com" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" class="text-red-600 hover:text-red-800 remove-link flex items-center">
                                <i class="fas fa-minus-circle mr-2"></i> Hapus
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center space-x-2">
                        <button type="button" id="add-link" class="text-blue-600 hover:text-blue-800 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Link
                        </button>
                    </div>
                    @error('links.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input untuk video -->
                <div id="videos-section" class="p-4 border border-gray-300 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Link Video (YouTube)</label>
                    <div class="flex flex-col space-y-2" id="videos-container">
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" name="videos[]" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" class="text-red-600 hover:text-red-800 remove-video flex items-center">
                                <i class="fas fa-minus-circle mr-2"></i> Hapus
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 flex items-center space-x-2">
                        <button type="button" id="add-video" class="text-blue-600 hover:text-blue-800 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Video
                        </button>
                    </div>
                    @error('videos.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between mt-6">
                    <!-- Tombol Kembali ke Langkah 1 -->
                    <a href="{{ route('learnings.reset.step1') }}" class="text-blue-600 hover:text-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kembali ke Langkah 1</a>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menambahkan link baru
            document.getElementById('add-link').addEventListener('click', function() {
                const container = document.getElementById('links-container');
                const newLinkInput = document.createElement('div');
                newLinkInput.classList.add('flex', 'items-center', 'space-x-2', 'mb-2');
                newLinkInput.innerHTML = `
                    <input type="text" name="links[]" placeholder="https://example.com" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <button type="button" class="text-red-600 hover:text-red-800 remove-link flex items-center">
                        <i class="fas fa-minus-circle mr-2"></i> Hapus
                    </button>
                `;
                container.appendChild(newLinkInput);
            });

            // Menambahkan video baru
            document.getElementById('add-video').addEventListener('click', function() {
                const container = document.getElementById('videos-container');
                const newVideoInput = document.createElement('div');
                newVideoInput.classList.add('flex', 'items-center', 'space-x-2', 'mb-2');
                newVideoInput.innerHTML = `
                    <input type="text" name="videos[]" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <button type="button" class="text-red-600 hover:text-red-800 remove-video flex items-center">
                        <i class="fas fa-minus-circle mr-2"></i> Hapus
                    </button>
                `;
                container.appendChild(newVideoInput);
            });

            // Menambahkan file pembelajaran siswa baru dengan judul
            document.getElementById('add-student-file').addEventListener('click', function() {
                const container = document.getElementById('student-files-container');
                const newFileInput = document.createElement('div');
                newFileInput.classList.add('flex', 'items-center', 'space-x-2', 'mb-2');
                newFileInput.innerHTML = `
                    <input type="text" name="student_files_titles[]" placeholder="Judul File" class="mt-1 block w-1/3 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <input type="file" name="student_files[]" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <button type="button" class="text-red-600 hover:text-red-800 remove-file flex items-center">
                        <i class="fas fa-minus-circle mr-2"></i> Hapus
                    </button>
                `;
                container.appendChild(newFileInput);
            });

            // Hapus link, video, atau file
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-link')) {
                    event.target.closest('div').remove();
                }
                if (event.target.classList.contains('remove-video')) {
                    event.target.closest('div').remove();
                }
                if (event.target.classList.contains('remove-file')) {
                    event.target.closest('div').remove();
                }
            });
        });
    </script>
</x-app-layout>
