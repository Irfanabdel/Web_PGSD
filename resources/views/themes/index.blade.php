<x-app-layout title="Tema P5">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <div class="w-full mb-4">
                <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl">Daftar Tema P5</h1>
            </div>
            <!-- Menambahkan container flex untuk tombol -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('themes.create') }}">
                    <button class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Tambah Tema
                    </button>
                </a>
            </div>
        </div>

        <!-- HTML with Tooltips and Checkboxes -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md mt-4">
            <!-- Kontainer dengan overflow-x-auto -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed border">
                    <thead class="bg-red-500 text-gray-700">
                        <tr>
                            <!-- Checkbox for selecting all rows -->
                            <th scope="col" class="p-3 text-xs font-medium text-center text-gray-500 uppercase">
                                <input type="checkbox" id="select-all" class="form-checkbox">
                            </th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Judul Tema</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Dimensi</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Projek 1</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Projek 2</th>
                            <th scope="col" class="p-3 text-xs font-medium text-center text-white uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($themes as $theme)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <!-- Checkbox for each row -->
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                <input type="checkbox" class="form-checkbox row-checkbox" name="selected_themes[]" value="{{ $theme->id }}">
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $theme->title }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                {!! $theme->dimensions_text !!}
                            </td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $theme->project1 }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $theme->project2 }}</td>
                            <td class="p-3 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">
                                <!-- Edit Icon with Tooltip -->
                                <div class="tooltip inline-block mr-2">
                                    <a href="{{ route('themes.edit', $theme->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 rounded-lg hover:text-blue-800 focus:ring-2 focus:ring-blue-300">
                                        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                                    </a>
                                    <span class="tooltiptext">Edit</span>
                                </div>

                                <!-- Delete Icon with Tooltip -->
                                <div class="tooltip inline-block">
                                    <form action="{{ route('themes.destroy', $theme->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
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
            </div>
        </div>

        <!-- JavaScript untuk konfirmasi delete dan checkbox -->
        <script>
            function confirmDelete(event) {
                event.preventDefault(); // Mencegah form submit secara default

                const confirmed = confirm("Apakah Anda yakin ingin menghapus tema ini?");

                if (confirmed) {
                    event.target.submit(); // Lanjutkan dengan submit jika pengguna mengonfirmasi
                }
            }

            // Checkbox functionality
            document.getElementById('select-all').addEventListener('click', function(event) {
                const isChecked = event.target.checked;
                document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
        </script>
    </div>
</x-app-layout>
