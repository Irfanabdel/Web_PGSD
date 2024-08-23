<x-app-layout title="Bahan Pembelajaran - Step 2">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <!-- Info Step -->
            <div class="mb-6 flex justify-center items-center">
                <p class="text-2xl font-bold text-gray-900">
                    <span class="text-red-500">Step 2</span> dari 2
                </p>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Bahan Pembelajaran</h1>
            <form action="{{ route('modules.store.step2') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Unggah file Modul Guru -->
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700">Unggah Modul Guru</label>
                    <input type="file" id="file" name="file" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <p class="mt-2 text-sm text-gray-500">Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                    @error('file')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unggah file Pembelajaran Siswa dengan input judul -->
                <div id="student-files-section" class="mb-6">
                    <label for="student_files" class="block text-sm font-medium text-gray-700">Unggah Pembelajaran Siswa</label>
                    <div class="flex flex-col space-y-4" id="student-files-container">
                        <div class="relative flex flex-col space-y-2">
                            <div class="flex items-center space-x-2">
                                <input type="text" name="student_files_titles[]" placeholder="Judul File" class="mt-1 block w-1/3 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                                <input type="file" name="student_files[]" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            </div>
                            <button type="button" id="add-student-file" class="absolute bottom-2 right-2 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-plus-circle"></i> File
                            </button>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file pembelajaran untuk siswa. Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                    @error('student_files.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input untuk link -->
                <div id="links-section" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Link Pembelajaran</label>
                    <div class="flex flex-col space-y-2" id="links-container">
                        <div class="relative flex items-center space-x-2 mb-2">
                            <input type="text" name="links[]" placeholder="https://example.com" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" id="add-link" class="absolute bottom-2 right-2 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-plus-circle"></i> Link
                            </button>
                        </div>
                    </div>
                    @error('links.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input untuk video -->
                <div id="videos-section" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Link Video (YouTube)</label>
                    <div class="flex flex-col space-y-2" id="videos-container">
                        <div class="relative flex items-center space-x-2 mb-2">
                            <input type="text" name="videos[]" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" id="add-video" class="absolute bottom-2 right-2 text-blue-600 hover:text-blue-800">
                                <i class="fas fa-plus-circle"></i> Video
                            </button>
                        </div>
                    </div>
                    @error('videos.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between mt-6">
                    <!-- Tombol Kembali ke Langkah 1 -->
                    <a href="{{ route('learnings.reset.step1') }}" class="text-blue-600 hover:text-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Kembali ke Langkah 1</a>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Modul</button>
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
                newLinkInput.classList.add('relative', 'flex', 'items-center', 'space-x-2', 'mb-2');
                newLinkInput.innerHTML = `
                    <input type="text" name="links[]" placeholder="https://example.com" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <button type="button" class="absolute bottom-2 right-2 text-red-600 hover:text-red-800 remove-link">
                        <i class="fas fa-minus-circle"></i> Hapus
                    </button>
                `;
                container.appendChild(newLinkInput);
            });

            // Menambahkan video baru
            document.getElementById('add-video').addEventListener('click', function() {
                const container = document.getElementById('videos-container');
                const newVideoInput = document.createElement('div');
                newVideoInput.classList.add('relative', 'flex', 'items-center', 'space-x-2', 'mb-2');
                newVideoInput.innerHTML = `
                    <input type="text" name="videos[]" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <button type="button" class="absolute bottom-2 right-2 text-red-600 hover:text-red-800 remove-video">
                        <i class="fas fa-minus-circle"></i> Hapus
                    </button>
                `;
                container.appendChild(newVideoInput);
            });

            // Menambahkan file pembelajaran siswa baru dengan judul
            document.getElementById('add-student-file').addEventListener('click', function() {
                const container = document.getElementById('student-files-container');
                const newFileInput = document.createElement('div');
                newFileInput.classList.add('relative', 'flex', 'items-center', 'space-x-2', 'mb-2');
                newFileInput.innerHTML = `
                    <input type="text" name="student_files_titles[]" placeholder="Judul File" class="mt-1 block w-1/3 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <input type="file" name="student_files[]" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                    <button type="button" class="absolute bottom-2 right-2 text-red-600 hover:text-red-800 remove-file">
                        <i class="fas fa-minus-circle"></i> Hapus
                    </button>
                `;
                container.appendChild(newFileInput);
            });

            // Hapus link atau video
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
