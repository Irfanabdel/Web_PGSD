<x-app-layout title="Edit Deskripsi Modul - Step 2">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Bahan Pembelajaran</h1>
            <form action="{{ route('modules.update.step2', ['module' => $module->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Unggah file Modul Guru -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">Unggah Modul Guru</label>
                    <input type="file" id="file" name="file" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm" />
                    @if ($module->file)
                        <p class="mt-2 text-sm text-gray-500">File saat ini: <a href="{{ Storage::url($module->file) }}" class="text-blue-600 hover:underline" target="_blank">{{ basename($module->file) }}</a></p>
                    @endif
                    @error('file')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unggah file Pembelajaran Siswa -->
                <div id="student-files-section">
                    <label for="student_files" class="block text-sm font-medium text-gray-700 mb-2">Unggah Pembelajaran Siswa</label>
                    <div class="space-y-4" id="student-files-container">
                        @foreach($module->student_files as $index => $file)
                        <div class="flex flex-col space-y-4 p-4 border border-gray-300 rounded-lg">
                            <input type="text" name="student_files_titles[]" placeholder="Judul File" value="{{ $module->student_files_titles[$index] ?? '' }}" class="mt-1 block w-1/3 text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
                            <input type="file" name="student_files[]" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
                            @if ($file)
                                <p class="mt-2 text-sm text-gray-500">File saat ini: <a href="{{ Storage::url($file) }}" class="text-blue-600 hover:underline" target="_blank">{{ basename($file) }}</a></p>
                            @endif
                            <div class="flex justify-between mt-4">
                                <button type="button" class="text-blue-600 hover:text-blue-800 add-student-file">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800 remove-student-file">
                                    <i class="fas fa-minus-circle"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Anda dapat mengunggah beberapa file pembelajaran untuk siswa. Jenis file yang diterima: PDF, DOC, DOCX, PPT, PPTX</p>
                    @error('student_files.*')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input untuk link -->
                <div id="links-section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Pembelajaran</label>
                    <div class="space-y-4" id="links-container">
                        @foreach($module->links as $link)
                        <div class="flex flex-col space-y-4 p-4 border border-gray-300 rounded-lg">
                            <input type="text" name="links[]" value="{{ $link }}" placeholder="https://example.com" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
                            <div class="flex justify-between mt-4">
                                <button type="button" id="add-link" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800 remove-link">
                                    <i class="fas fa-minus-circle"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('links.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input untuk video -->
                <div id="videos-section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Video (YouTube)</label>
                    <div class="space-y-4" id="videos-container">
                        @foreach($module->videos as $video)
                        <div class="flex flex-col space-y-4 p-4 border border-gray-300 rounded-lg">
                            <input type="text" name="videos[]" value="{{ $video }}" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
                            <div class="flex justify-between mt-4">
                                <button type="button" id="add-video" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-800 remove-video">
                                    <i class="fas fa-minus-circle"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('videos.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Perbarui</button>
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
                newLinkInput.classList.add('flex', 'flex-col', 'space-y-4', 'p-4', 'border', 'border-gray-300', 'rounded-lg');
                newLinkInput.innerHTML = `
                    <input type="text" name="links[]" placeholder="https://example.com" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
                    <div class="flex justify-between mt-4">
                        <button type="button" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                        <button type="button" class="text-red-600 hover:text-red-800 remove-link">
                            <i class="fas fa-minus-circle"></i> Hapus
                        </button>
                    </div>
                `;
                container.appendChild(newLinkInput);
                addRemoveLinkEvent();
            });

            // Menambahkan video baru
            document.getElementById('add-video').addEventListener('click', function() {
                const container = document.getElementById('videos-container');
                const newVideoInput = document.createElement('div');
                newVideoInput.classList.add('flex', 'flex-col', 'space-y-4', 'p-4', 'border', 'border-gray-300', 'rounded-lg');
                newVideoInput.innerHTML = `
                    <input type="text" name="videos[]" placeholder="https://youtube.com/watch?v=VIDEO_ID" class="mt-1 block w-full text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
                    <div class="flex justify-between mt-4">
                        <button type="button" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                        <button type="button" class="text-red-600 hover:text-red-800 remove-video">
                            <i class="fas fa-minus-circle"></i> Hapus
                        </button>
                    </div>
                `;
                container.appendChild(newVideoInput);
                addRemoveVideoEvent();
            });

            function addRemoveLinkEvent() {
                document.querySelectorAll('.remove-link').forEach(button => {
                    button.addEventListener('click', function() {
                        this.parentElement.parentElement.remove();
                    });
                });
            }

            function addRemoveVideoEvent() {
                document.querySelectorAll('.remove-video').forEach(button => {
                    button.addEventListener('click', function() {
                        this.parentElement.parentElement.remove();
                    });
                });
            }

            addRemoveLinkEvent();
            addRemoveVideoEvent();
        });
    </script>
</x-app-layout>
