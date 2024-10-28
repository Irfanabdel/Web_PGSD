<x-app-layout title="Edit Deskripsi Modul - Step 2">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl flex justify-center font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Edit Detail Aktivitas</h1>
            <form action="{{ route('learnings.update.step2', ['learning' => $learning->id, 'module' => $module->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Box untuk Edit Judul Modul -->
                <div class="p-4 border border-gray-200 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Aktivitas</label>
                    <input type="text" name="title" value="{{ old('title', $module->title) }}" placeholder="Masukkan Judul Modul" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" required />
                    @error('title')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Box Unggah file Pembelajaran Siswa dengan input judul -->
                <div class="p-4 border border-gray-200 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Unggah Pembelajaran Siswa</label>
                    <div class="flex flex-col space-y-4" id="student-files-container">
                        @foreach($module->student_files as $index => $studentFile)
                        <div class="file-entry flex flex-col space-y-2 mb-2">
                            <input type="text" name="student_files_titles[]" value="{{ $module->student_files_titles[$index] ?? '' }}" placeholder="Judul File" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <input type="file" name="student_files[]" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <input type="hidden" name="existing_student_files[]" value="{{ $studentFile }}" />
                            <div class="flex flex-col mt-2">
                                @if(isset($studentFile))
                                <span class="text-gray-500 mt-2 file-name">{{ basename($studentFile) }}</span>
                                @endif
                                <button type="button" class="text-red-600 hover:text-red-800 remove-file flex items-center mt-2">
                                    <i class="fas fa-minus-circle mr-2"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                        <!-- Tambah File Siswa Button -->
                        <div class="mt-2 flex items-center space-x-2">
                            <button type="button" id="add-student-file" class="text-blue-600 hover:text-blue-800 flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah File
                            </button>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file pembelajaran untuk siswa. Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                    @error('student_files.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Box Input untuk link -->
                <div class="p-4 border border-gray-200 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Link Pembelajaran</label>
                    <div class="flex flex-col space-y-2" id="links-container">
                        @foreach($module->links as $link)
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" name="links[]" value="{{ $link }}" placeholder="https://example.com" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" class="text-red-600 hover:text-red-800 remove-link flex items-center">
                                <i class="fas fa-minus-circle mr-2"></i> Hapus
                            </button>
                        </div>
                        @endforeach
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

                <!-- Box Input untuk video -->
                <div class="p-4 border border-gray-200 rounded-lg mb-6">
                    <label class="block text-sm font-medium text-gray-700">Link Video (YouTube)</label>
                    <div class="flex flex-col space-y-2" id="videos-container">
                        @foreach($module->videos as $video)
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" name="videos[]" value="{{ $video }}" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                            <button type="button" class="text-red-600 hover:text-red-800 remove-video flex items-center">
                                <i class="fas fa-minus-circle mr-2"></i> Hapus
                            </button>
                        </div>
                        @endforeach
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

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentFilesContainer = document.getElementById('student-files-container');

            // Delegasi event untuk hapus file siswa
            studentFilesContainer.addEventListener('click', function(e) {
                if (e.target && (e.target.classList.contains('remove-file') || e.target.closest('.remove-file'))) {
                    const fileEntry = e.target.closest('.file-entry');
                    fileEntry.remove();
                }
            });

            // Menambahkan file siswa baru
            document.getElementById('add-student-file').addEventListener('click', function() {
                const newFileEntry = document.createElement('div');
                newFileEntry.classList.add('file-entry', 'flex', 'flex-col', 'space-y-2', 'mb-2');
                newFileEntry.innerHTML = `
                <input type="text" name="student_files_titles[]" placeholder="Judul File" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                <input type="file" name="student_files[]" class="bg-gray-50 mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm" />
                <input type="hidden" name="existing_student_files[]" value="" />
                <div class="flex flex-col mt-2">
                    <span class="text-gray-500 mt-2 file-name">No chosen file</span>
                    <button type="button" class="text-red-600 hover:text-red-800 remove-file flex items-center mt-2">
                        <i class="fas fa-minus-circle mr-2"></i> Hapus
                    </button>
                </div>
            `;
                studentFilesContainer.appendChild(newFileEntry);
            });

            // Menampilkan nama file yang dipilih
            studentFilesContainer.addEventListener('change', function(e) {
                if (e.target && e.target.type === 'file') {
                    const fileInput = e.target;
                    const fileNameSpan = fileInput.parentElement.querySelector('.file-name');
                    if (fileNameSpan) {
                        fileNameSpan.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No chosen file';
                    }
                }
            });

            // Menghapus file lama ketika memilih file baru
            studentFilesContainer.addEventListener('change', function(e) {
                if (e.target && e.target.type === 'file') {
                    const fileInput = e.target;
                    const fileEntry = fileInput.closest('.file-entry');

                    // Menghapus file lama
                    const hiddenInput = fileEntry.querySelector('input[type="hidden"]');
                    if (hiddenInput) {
                        hiddenInput.value = ''; // Kosongkan nilai hidden input untuk file lama
                    }

                    // Update nama file yang dipilih
                    const fileNameSpan = fileEntry.querySelector('.file-name');
                    if (fileNameSpan) {
                        fileNameSpan.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No chosen file';
                    }
                }
            });

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

            // Menghapus link
            document.getElementById('links-container').addEventListener('click', function(e) {
                if (e.target && (e.target.classList.contains('remove-link') || e.target.closest('.remove-link'))) {
                    const linkEntry = e.target.closest('div');
                    linkEntry.remove();
                }
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

            // Menghapus video
            document.getElementById('videos-container').addEventListener('click', function(e) {
                if (e.target && (e.target.classList.contains('remove-video') || e.target.closest('.remove-video'))) {
                    const videoEntry = e.target.closest('div');
                    videoEntry.remove();
                }
            });
        });
    </script>
</x-app-layout>