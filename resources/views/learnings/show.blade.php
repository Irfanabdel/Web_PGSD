<x-app-layout :title="$learning->theme->title">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md space-y-8">
            <!-- Judul Detail Pembelajaran dengan Tombol Edit dan Hapus untuk Guru -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl sm:text-3xl font-bold">
                    <span class="text">{{ $learning->theme->title }}</span>
                    <span class="font-normal text-gray-700">| Kelas {{ $learning->user_kelas }}</span>
                </h2>
                @if (auth()->user()->role === 'guru')
                <div class="flex space-x-2 mt-4 sm:mt-0">
                    <!-- Edit Icon with Tooltip -->
                    <div class="tooltip inline-block">
                        <a href="{{ route('learnings.edit.step1', $learning->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 rounded-lg hover:text-blue-800 focus:ring-2 focus:ring-blue-300">
                            <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                        </a>
                        <span class="tooltiptext">Edit</span>
                    </div>

                    <!-- Delete Icon with Tooltip -->
                    <div class="tooltip inline-block">
                        <form action="{{ route('learnings.destroy', $learning->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-600 rounded-lg hover:text-red-800 focus:ring-2 focus:ring-red-300">
                                <i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon -->
                            </button>
                        </form>
                        <span class="tooltiptext">Hapus</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Gambar Cover Pembelajaran -->
            <div class="mb-4">
                @if ($learning->cover_image)
                <img src="{{ Storage::url($learning->cover_image) }}" alt="Cover Image" class="w-full h-48 sm:h-64 object-cover rounded-lg">
                @else
                <!-- Placeholder jika tidak ada gambar -->
                <img src="{{ asset('image/default_cover.jpg') }}" alt="Default Cover Image" class="w-full h-48 sm:h-64 object-cover rounded-lg">
                @endif
            </div>

            <!-- Informasi Tema -->
            <div class="mb-8">
                <!-- Flex container untuk tombol edit, delete, dan judul informasi tema -->
                <div class="flex items-center justify-between mb-4 border-b border-gray-300 pb-2">
                    <!-- Judul Informasi Tema -->
                    <div class="flex-grow">
                        <div class="flex items-center cursor-pointer" onclick="toggleInfo('info-content-theme', 'toggle-icon-theme')">
                            <svg id="toggle-icon-theme" xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5 mr-2 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <p class="text-lg sm:text-xl font-bold">Informasi Tema</p>
                        </div>
                    </div>
                </div>

                <!-- Konten informasi tema yang dapat ditampilkan/ditutup -->
                <div id="info-content-theme" class="hidden space-y-4">
                    <!-- Menampilkan Dimensi dengan Pemisah Koma -->
                    <div class="text-base sm:text-lg">
                        <p class="font-bold">Dimensi:</p>
                        <p>{{ str_replace('<br>', ', ', $learning->theme->dimensions_text ?? 'Dimensi Tidak Tersedia') }}</p>
                    </div>

                    <!-- Menampilkan Elemen -->
                    <div class="text-base sm:text-lg">
                        <p class="font-bold">Elemen:</p>
                        <p>{{ $learning->element ?? 'Elemen Tidak Tersedia' }}</p>
                    </div>

                    <!-- Menampilkan Tujuan -->
                    <div class="text-base sm:text-lg">
                        <p class="font-bold">Tujuan:</p>
                        <p>{{ $learning->goals ?? 'Tujuan Tidak Tersedia' }}</p>
                    </div>
                </div>
            </div>

            <!-- Pembelajaran -->
            <div class="mb-8">
                <div class="relative">
                    <div class="flex items-center cursor-pointer mb-4 border-b border-gray-300 pb-2" onclick="toggleInfo('info-content-module', 'toggle-icon-module')">
                        <svg id="toggle-icon-module" xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5 mr-2 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <p class="text-lg sm:text-xl font-bold">Pembelajaran</p>
                    </div>

                    <!-- Tombol Edit dan Delete untuk Pembelajaran -->
                    @if (auth()->user()->role === 'guru')
                    <div class="absolute top-0 right-0 mt-2 mr-2 flex space-x-2">
                        <!-- Edit Icon with Tooltip -->
                        <div class="tooltip inline-block">
                            <a href="{{ route('learnings.edit.step2', $learning->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 rounded-lg hover:text-blue-800 focus:ring-2 focus:ring-blue-300">
                                <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                            </a>
                            <span class="tooltiptext">Edit</span>
                        </div>
                        
                        <!-- Delete Icon with Tooltip -->
                        @foreach ($learning->modules as $module)
                        <div class="tooltip inline-block">
                            <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-600 rounded-lg hover:text-red-800 focus:ring-2 focus:ring-red-300">
                                    <i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon -->
                                </button>
                            </form>
                            <span class="tooltiptext">Hapus</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div id="info-content-module" class="hidden space-y-6">
                    @forelse ($learning->modules as $module)
                    <div class="mb-4 space-y-4">
                        <!-- Menampilkan File dengan Ikon Default hanya untuk pengguna dengan role 'guru' -->
                        @if (auth()->user()->role === 'guru')
                        @if ($module->file)
                        <p class="font-bold">Module Guru:</p>
                        <a href="{{ Storage::url($module->file) }}" class="text-blue-600" target="_blank">
                            <img src="{{ asset('image/file.png') }}" alt="File Icon" class="inline-block w-8 sm:w-12 h-8 sm:h-12 mr-2">
                            {{ basename($module->file) }}
                        </a>
                        @else
                        <p class="font-bold">File:</p>
                        <p>Tidak Ada File</p>
                        @endif
                        @endif

                        <!-- Menampilkan Student Files -->
                        @if (count($module->student_files) > 0)
                        <p class="font-bold mt-2">File Pembelajaran Siswa:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($module->student_files as $index => $studentFile)
                            <li>
                                <a href="{{ Storage::url($studentFile) }}" class="text-blue-600" target="_blank">
                                    <img src="{{ asset('image/file.png') }}" alt="File Icon" class="inline-block w-8 sm:w-12 h-8 sm:h-12 mr-2">
                                    {{ $module->student_files_titles[$index] ?? 'Judul Tidak Tersedia' }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="font-bold mt-2">File Pembelajaran Siswa:</p>
                        <p>Tidak Ada File Pembelajaran Siswa</p>
                        @endif

                        <!-- Menampilkan Links -->
                        @if (count($module->links) > 0)
                        <p class="font-bold mt-2">Links Pembelajaran:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($module->links as $link)
                            <li><a href="{{ $link }}" class="text-blue-600" target="_blank">{{ $link }}</a></li>
                            @endforeach
                        </ul>
                        @else
                        <p class="font-bold mt-2">Links:</p>
                        <p>Tidak Ada Links</p>
                        @endif

                        <!-- Menampilkan Videos -->
                        @if (count($module->videos) > 0)
                        <p class="font-bold mt-2">Youtube:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($module->videos as $video)
                            <li class="mb-4">
                                <a href="{{ $video }}" class="text-blue-600" target="_blank">{{ $video }}</a>
                                <iframe class="video-thumbnail mt-2 w-full sm:w-64 h-40 sm:h-48" id="video-{{ $loop->index }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var videoUrl = "{{ $video }}";
                                        var videoId = extractVideoId(videoUrl);
                                        document.getElementById('video-{{ $loop->index }}').src = "https://www.youtube.com/embed/" + videoId;
                                    });
                                </script>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="font-bold mt-2">Videos:</p>
                        <p>Tidak Ada Videos</p>
                        @endif
                    </div>
                    @empty
                    <p>Tidak Ada Pembelajaran</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk toggle informasi -->
    <script>
        function toggleInfo(contentId, iconId) {
            var content = document.getElementById(contentId);
            var icon = document.getElementById(iconId);
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Extracts the video ID from the YouTube URL
        function extractVideoId(url) {
            const regex = /(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|v\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
            const match = url.match(regex);
            return match ? match[1] : '';
        }

        function confirmDelete(event) {
            event.preventDefault(); // Mencegah form submit secara default

            const confirmed = confirm("Apakah Anda yakin ingin menghapus tema ini?");

            if (confirmed) {
                event.target.submit(); // Lanjutkan dengan submit jika pengguna mengonfirmasi
            }
        }
    </script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</x-app-layout>