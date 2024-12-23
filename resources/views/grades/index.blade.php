<x-app-layout title="Daftar Asesmen Siswa">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <div class="w-full mb-1">
                <div class="mb-4 flex justify-between items-center">
                    <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Daftar Asesmen Siswa</h1>
                </div>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('grades.create') }}">
                        <button class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                            Tambah Asesmen Siswa
                        </button>
                    </a>
                </div>

                <!-- HTML with Tooltips and Checkboxes -->
                <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

                <!-- Sorting Controls -->
                <div class="mb-4 flex justify-end space-x-2">
                    <form method="GET" action="{{ route('grades.index') }}" class="flex items-center">
                        <!-- Dropdown untuk Sort By -->
                        <div class="relative mr-2">
                            <select name="sort_by" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="updated_at" {{ $sortBy === 'updated_at' ? 'selected' : '' }}>Update</option>
                                <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="school_name" {{ $sortBy === 'school_name' ? 'selected' : '' }}>Sekolah</option>
                                <option value="kelas" {{ $sortBy === 'kelas' ? 'selected' : '' }}>Kelas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Dropdown untuk Sort Order -->
                        <div class="relative mr-2">
                            <select name="sort_order" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Kecil</option>
                                <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Besar</option>
                            </select>

                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Tombol Sortir -->
                        <button type="submit" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center space-x-2">
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M3 18h18v-2H3v2zm0-5h12v-2H3v2zm0-7v2h6V6H3z" />
                            </svg>
                            <span>Sortir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Nilai Berdasarkan Tema -->
        @if($themesExist)
        @foreach($themes as $theme)
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md mt-4">
            <h2 class="text-xl font-semibold mb-4">{{ $theme->title }}</h2>
            <!-- Keterangan di atas tabel -->
            <p class="text-sm text-gray-600 mb-2">Keterangan:</p>
            <p class="text-sm text-gray-600 mb-4">BB: Baru Berkembang | MB: Masih Berkembang | BSH: Berkembang Sesuai Harapan | SB: Sangat Berkembang</p>
            <!-- Kontainer dengan overflow-x-auto -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed border">
                    <thead class="bg-red-500 text-gray-700">
                        <tr>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-gray-500 uppercase">
                                <input type="checkbox" id="select-all-{{ $theme->id }}" class="form-checkbox h-4 w-4 text-blue-600">
                            </th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Update Terakhir</th> <!-- Kolom Update Terakhir -->
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Nama Siswa</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Nama Sekolah</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Kelas</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Komentar Projek 1</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Komentar Projek 2</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Dimensi</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Asesmen</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($grades->where('theme_id', $theme->id) as $grade)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="grade_ids[]" value="{{ $grade->id }}">
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                {{ $grade->updated_at->format('d-m-Y H:i:s') }}
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->user->name }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->user->school_name }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->user->kelas }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->comments_1 }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->comments_2 }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                {!! $theme->dimensions_text !!}
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                {!! $grade->assessments_text !!}
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                <!-- Edit Icon with Tooltip -->
                                <div class="tooltip inline-block mr-2">
                                    <a href="{{ route('grades.edit', $grade->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 rounded-lg hover:text-blue-800 focus:ring-2 focus:ring-blue-300">
                                        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                                    </a>
                                    <span class="tooltiptext">Edit</span>
                                </div>

                                <!-- Delete Icon with Tooltip -->
                                <div class="tooltip inline-block">
                                    <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-600 rounded-lg hover:text-red-800 focus:ring-2 focus:ring-red-300">
                                            <i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon -->
                                        </button>
                                    </form>
                                    <span class="tooltiptext">Hapus</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Display Project 1 and 2 below the table -->
                <div class="mt-4 p-4 rounded-lg">
                    <!-- Proyek 1 -->
                    <p class="text-sm text-gray-700">
                        <strong>Proyek 1 :</strong> {{ $theme->project1 }}
                    </p>

                    <!-- Proyek 2 -->
                    <p class="text-sm text-gray-700 mt-4">
                        <strong>Proyek 2 :</strong> {{ $theme->project2 }}
                    </p>
                </div>

            </div>
        </div>
        @endforeach
        @endif
    </div>

    <script>
        function confirmDelete(event) {
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                event.preventDefault();
            }
        }

        document.querySelectorAll('[id^="select-all-"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var themeId = this.id.split('-').pop();
                var checkboxes = document.querySelectorAll(`input[name="grade_ids[]"][value*="${themeId}"]`);
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = this.checked;
                }, this);
            });
        });
    </script>
</x-app-layout>