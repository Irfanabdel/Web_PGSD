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
                <div id="info-content-theme" class="space-y-4">
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

                    <div class="text-base sm:text-lg">
                        <p class="font-bold">Tujuan:</p>
                        <ol class="goals-list">
                            {!! $learning->goals ?? '<li>Tujuan Tidak Tersedia</li>' !!}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 sm:ml-64 pt-1">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md space-y-8">
            <!-- Informasi Aktivitas -->
            <div class="mb-8">
                <!-- Tombol Tambah Aktivitas -->
                @if (auth()->user()->role === 'guru')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('learnings.create.step2', ['learning' => $learning->id]) }}"
                        class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-xs px-3 py-1.5 text-center">
                        Tambah Aktivitas
                    </a>
                </div>
                @endif

                @if ($learning->modules->isEmpty())
                <p>Tidak ada aktivitas tersedia.</p>
                @else

                @foreach ($learning->modules as $module)
                <div class="flex items-center justify-between mb-4 border-b border-gray-300 pb-2">
                    <div class="flex-grow">
                        <div class="flex items-center cursor-pointer" onclick="toggleInfo('info-content-module-{{ $module->id }}', 'toggle-icon-module-{{ $module->id }}')">
                            <svg id="toggle-icon-module-{{ $module->id }}" xmlns="http://www.w3.org/2000/svg" class="h-4 sm:h-5 w-4 sm:w-5 mr-2 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <p class="text-lg sm:text-xl font-bold">Aktivitas {{ $module->title }}</p>
                        </div>
                    </div>

                    @if (auth()->user()->role === 'guru')
                    <div class="flex space-x-2">
                        <!-- Edit Icon with Tooltip -->
                        <div class="tooltip inline-block">
                            <a href="{{ route('learnings.edit.step2', ['learning' => $module->learning_id, 'module' => $module->id]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 rounded-lg hover:text-blue-800 focus:ring-2 focus:ring-blue-300">
                                <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                            </a>
                            <span class="tooltiptext">Edit</span>
                        </div>

                        <!-- Delete Icon with Tooltip -->
                        <div class="tooltip inline-block">
                            <form
                                action="{{ route('learnings.destroy.module', ['learning' => $learning->id, 'module' => $module->id]) }}"
                                method="POST"
                                class="inline-block"
                                onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-600 rounded-lg hover:text-red-800 focus:ring-2 focus:ring-red-300">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            <span class="tooltiptext">Hapus</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Konten informasi modul yang dapat ditampilkan/ditutup -->
                <div id="info-content-module-{{ $module->id }}" class="space-y-4">
                    <!-- Menampilkan Student Files -->
                    @if (count($module->student_files) > 0)
                    <p class="font-bold mt-2">File Pembelajaran Siswa:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($module->student_files as $index => $studentFile)
                        <li>
                            <a href="{{ Storage::url($studentFile) }}" class="text-blue-600 hover:underline" target="_blank">
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
                        <li><a href="{{ $link }}" class="text-blue-600 hover:underline" target="_blank">{{ $link }}</a></li>
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
                            <a href="{{ $video }}" class="text-blue-600 hover:underline" target="_blank">{{ $video }}</a>
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

                    <!-- Garis Pemisah -->
                    <hr class="border-t border-gray-300 my-6">

                    <!-- Tombol Tambah Evaluasi -->
                    @if (auth()->user()->role === 'guru')
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('learnings.create.step3', ['learning' => $learning->id, 'module' => $module->id]) }}"
                            class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-xs px-3 py-1.5 text-center">
                            Tambah Evaluasi
                        </a>
                    </div>
                    @endif

                    <!-- Menampilkan Evaluasi -->
                    <div id="info-content-evaluation" class="space-y-4">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md relative">
                            @if (count($module->evaluations) > 0)
                            <ul class="list-disc list-inside">
                                @foreach ($module->evaluations as $evaluation)

                                <!-- Tombol Edit untuk Guru -->
                                @if (auth()->user()->role === 'guru')
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <!-- Edit Icon dengan Tooltip -->
                                    <div class="tooltip inline-block">
                                        <a href="{{ route('learnings.edit.step3', ['learning' => $learning->id, 'module' => $module->id, 'evaluation' => $evaluation->id]) }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 rounded-lg hover:text-blue-800 focus:ring-2 focus:ring-blue-300">
                                            <i class="fas fa-edit"></i> <!-- Ikon Edit dari Font Awesome -->
                                        </a>
                                        <span class="tooltiptext">Edit</span>
                                    </div>

                                    <!-- Hapus Icon dengan Tooltip -->
                                    <div class="tooltip inline-block">
                                        <form action="{{ route('learnings.destroy.evaluation', ['learning' => $learning->id, 'module' => $module->id, 'evaluation' => $evaluation->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus evaluasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-600 rounded-lg hover:text-red-800 focus:ring-2 focus:ring-red-300">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <span class="tooltiptext">Hapus</span>
                                    </div>
                                </div>
                                @endif

                                <h3 class="text-lg font-bold mb-2">{{ $evaluation->title }}</h3>
                                <ol class="evaluation-description">{!! $evaluation->description !!}</ol>
                                <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
                                <div class="flex flex-col space-y-2 text-sm text-red-500">
                                    <div class="flex items-center">
                                        <span class="w-20">Mulai</span>
                                        <span class="w-3/4">: {{ $evaluation->start_datetime }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-20">Berakhir</span>
                                        <span class="w-3/4">: {{ $evaluation->end_datetime }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </ul>

                            <!-- Tombol Kerjakan -->
                            @php
                            $now = \Carbon\Carbon::now('Asia/Jakarta'); // Waktu saat ini di zona waktu Asia/Jakarta
                            $endDatetime = \Carbon\Carbon::parse($evaluation->end_datetime)->setTimezone('Asia/Jakarta'); // Konversi end_datetime ke zona waktu Asia/Jakarta
                            @endphp
                            @if ($now->lt($endDatetime))
                            <a href="{{ route('learnings.work', ['evaluation' => $evaluation->id]) }}" class="inline-flex items-center px-4 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-300">
                                Kerjakan
                            </a>
                            @else
                            <p class="mt-4 text-red-600">Sesi Berakhir</p>
                            @endif

                            <!-- Tampilkan Tabel Jawaban -->
                            @if (auth()->user()->role === 'guru')
                            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md mt-4">
                                <div class="overflow-x-auto">
                                    <h3 class="text-lg font-bold mb-2">Jawaban Siswa</h3>
                                    <table class="min-w-full divide-y divide-gray-200 table-fixed border">
                                        <thead class="bg-red-500 text-gray-700">
                                            <tr>
                                                <!-- Checkbox for selecting all rows -->
                                                <th scope="col" class="p-3 text-xs font-medium text-center text-gray-500 uppercase">
                                                    <input type="checkbox" id="select-all" class="form-checkbox">
                                                </th>
                                                <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Waktu Submit</th>
                                                <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Nama</th>
                                                <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Kelas</th>
                                                <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($evaluation->works as $work)
                                            <tr class="hover:bg-gray-100 transition-colors">
                                                <!-- Checkbox for each row -->
                                                <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                                    <input type="checkbox" class="form-checkbox row-checkbox" name="selected_works[]" value="{{ $work->id }}">
                                                </td>
                                                <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                                    {{ \Carbon\Carbon::parse($work->updated_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                                </td>
                                                <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                                    {{ $work->user->name }}
                                                </td>
                                                <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                                    {{ $work->user->kelas }}
                                                </td>
                                                <td class="evaluation-description">{!! $work->answers !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @elseif (auth()->user()->role === 'siswa')
                            <div class="mt-4">
                                <h4 class="text-lg font-bold mb-2">Jawaban Anda</h4>
                                @php
                                // Ambil jawaban siswa untuk evaluasi ini
                                $studentAnswer = $evaluation->works->where('user_id', auth()->user()->id)->first();
                                @endphp
                                @if ($studentAnswer)
                                <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <p class="font-semibold">Waktu Mengumpulkan :</p>
                                    <p>{{ \Carbon\Carbon::parse($studentAnswer->updated_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }}</p>
                                    <p class="font-semibold">Jawaban:</p>
                                    <ol class="evaluation-description">{!! $studentAnswer->answers !!}</ol>
                                </div>
                                @else
                                <p>Belum ada jawaban untuk evaluasi ini.</p>
                                @endif
                            </div>
                            @endif

                            @else
                            <p class="font-bold mt-2">Evaluasi:</p>
                            <p>Tidak Ada Evaluasi</p>
                            @endif
                        </div>
                    </div>
                    <div class="my-6"></div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript untuk toggle informasi -->
    <script>
        function toggleInfo(contentId, iconId) {
            var content = document.getElementById(contentId);
            var icon = document.getElementById(iconId);

            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Extracts the video ID from the YouTube URL
        function extractVideoId(url) {
            const regex = /(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|v\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
            const match = url.match(regex);
            return match ? match[1] : '';
        }

        function confirmDelete(event) {
            event.preventDefault(); // Mencegah form submit secara default

            const confirmed = confirm("Apakah Anda yakin ingin menghapus ini?");

            if (confirmed) {
                event.target.submit(); // Lanjutkan dengan submit jika pengguna mengonfirmasi
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (Array.from(rowCheckboxes).every(checkbox => checkbox.checked)) {
                        selectAllCheckbox.checked = true;
                    } else {
                        selectAllCheckbox.checked = false;
                    }
                });
            });
        });
    </script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</x-app-layout>