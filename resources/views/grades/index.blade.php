<x-app-layout title="Daftar Asesmen Siswa">
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <div class="w-full mb-1">
                <div class="mb-4 flex justify-between items-center">
                    <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Daftar Asesmen Siswa</h1>
                </div>
                <div class="flex justify-end mb-4">
                    @if($themesExist)
                    <a href="{{ route('grades.create') }}">
                        <button class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                            Tambah Asesmen Siswa
                        </button>
                    </a>
                    @else
                    <div class="flex items-center">
                        <p class="text-red-600 mr-4">Tema belum ada. Silakan tambahkan tema terlebih dahulu.</p>
                        <a href="{{ route('themes.create') }}">
                            <button class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                                Tambah Tema
                            </button>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- HTML with Tooltips and Checkboxes -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

        <!-- Tabel Nilai -->
        @if($themesExist)
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md mt-4">
            <!-- Keterangan di atas tabel -->
            <p class="text-sm text-gray-600 mb-2">Keterangan:</p>
            <p class="text-sm text-gray-600 mb-4">BB: Baru Berkembang | MB: Masih Berkembang | BSH: Berkembang Sesuai Harapan | SB: Sangat Berkembang</p>
            <!-- Kontainer dengan overflow-x-auto -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-red-500 text-gray-700">
                        <tr>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-gray-500 uppercase">
                                <input type="checkbox" id="select-all" class="form-checkbox h-4 w-4 text-blue-600">
                            </th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Nama Siswa</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Nama Sekolah</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Kelas</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Tema</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Dimensi</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Asesmen</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($grades as $grade)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" name="grade_ids[]" value="{{ $grade->id }}">
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->user->name }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->user->school_name }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->user->kelas }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $grade->theme->title }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                {!! $grade->theme->dimensions_text !!}
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                {!! $grade->assessments_text !!}
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                <!-- Edit Icon with Tooltip -->
                                <div class="tooltip inline-block mr-2">
                                    <a href="{{ route('grades.edit', $grade->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                                    </a>
                                    <span class="tooltiptext">Edit</span>
                                </div>

                                <!-- Delete Icon with Tooltip -->
                                <div class="tooltip inline-block">
                                    <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300">
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
            </div>
        </div>
        @endif
    </div>

    <script>
        function confirmDelete(event) {
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                event.preventDefault();
            }
        }

        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="grade_ids[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>
</x-app-layout>