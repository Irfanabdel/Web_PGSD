<x-app-layout title="Modul P5">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <div class="w-full mb-4">
                <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl">Daftar Modul P5</h1>
            </div>

            <!-- Tombol Tambah Modul -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('teachers.create') }}">
                    <button class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Tambah Modul
                    </button>
                </a>
            </div>
        </div>

        <!-- HTML with Tooltips and Checkboxes -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

        <!-- Tabel Daftar Modul -->
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed border">
                    <thead class="bg-red-500 text-white">
                        <tr>
                            <!-- Checkbox Pilih Semua -->
                            <th scope="col" class="p-3 text-xs font-medium text-center uppercase">
                                <input type="checkbox" id="select-all" class="form-checkbox">
                            </th>
                            <th scope="col" class="p-3 text-xs font-medium text-center uppercase">Tema</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center uppercase">Kelas</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center uppercase">Deskripsi Modul</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center uppercase">File Modul</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($teachers as $teacher)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <!-- Checkbox untuk Setiap Baris -->
                            <td class="p-3 text-sm text-center border-r border-gray-200">
                                <input type="checkbox" class="form-checkbox row-checkbox" name="selected_teachers[]" value="{{ $teacher->id }}">
                            </td>
                            <td class="p-3 text-sm text-center border-r border-gray-200">{{ $teacher->theme->title }}</td>
                            <td class="p-3 text-sm text-center border-r border-gray-200">{{ $teacher->user_kelas }}</td>
                            <td class="p-3 text-sm border-r border-gray-200">{{ $teacher->description }}</td>
                            <td class="p-3 text-sm text-center border-r border-gray-200">
                                @if($teacher->files)
                                <a href="{{ asset('storage/' . $teacher->files) }}" class="text-blue-600 hover:text-blue-800" target="_blank">
                                    Lihat File
                                </a>
                                @else
                                <span class="text-gray-500">Tidak ada file</span>
                                @endif
                            </td>
                            <td class="p-3 text-sm text-center">
                                <!-- Tombol Edit -->
                                <div class="tooltip inline-block mr-2">
                                    <a href="{{ route('teachers.edit', $teacher->id) }}" class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <span class="tooltiptext">Edit</span>
                                </div>

                                <!-- Tombol Hapus -->
                                <div class="tooltip inline-block">
                                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash-alt"></i>
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

        <!-- JavaScript untuk Konfirmasi dan Checkbox -->
        <script>
            function confirmDelete(event) {
                event.preventDefault();
                const confirmed = confirm("Apakah Anda yakin ingin menghapus modul ini?");
                if (confirmed) {
                    event.target.submit();
                }
            }

            document.getElementById('select-all').addEventListener('click', function(event) {
                const isChecked = event.target.checked;
                document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        </script>
    </div>
</x-app-layout>
