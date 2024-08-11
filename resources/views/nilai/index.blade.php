<x-app-layout title="Nilai Guru">
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Daftar Nilai Siswa</h1>
                </div>
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100">
                    <div class="flex justify-between items-center mb-4 sm:mb-0">
                    </div>
                    <a href="{{ route('nilai.create') }}">
                        <button class="text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                            Tambah Nilai Siswa
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabel Nilai -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="p-4 text-center">
                            <div class="flex items-center justify-center">
                                <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-yellow-300">
                                <label for="checkbox-all" class="sr-only">Checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase">Nama Siswa</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase">Kelas</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase">Nama Sekolah</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase">Mata Pelajaran</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase">Nilai</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($nilai as $item)
                    @foreach($item->mapels as $mapel)
                    <tr class="border-b border-gray-200">
                        <td class="w-4 p-4 text-center border-r border-gray-200">
                            <div class="flex items-center justify-center">
                                <input id="checkbox-{{ $item->id }}" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-yellow-300">
                                <label for="checkbox-{{ $item->id }}" class="sr-only">Checkbox</label>
                            </div>
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $item->user->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $item->user->kelas }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $item->user->school_name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $mapel->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center border-r border-gray-200">{{ $mapel->nilai }}</td>

                        <!-- HTML with Tooltips -->
                        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

                        @if($loop->first)
                        <td rowspan="{{ $item->mapels->count() }}" class="p-4 space-x-2 whitespace-nowrap text-center border-r border-gray-200">
                            <!-- Edit Icon with Tooltip -->
                            <div class="tooltip">
                                <a href="{{ route('nilai.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                                    <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                                </a>
                                <span class="tooltiptext">Edit</span>
                            </div>

                            <!-- Delete Icon with Tooltip -->
                            <div class="tooltip">
                                <form action="{{ route('nilai.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-red-500 hover:bg-red-700 focus:ring-4 focus:ring-red-300">
                                        <i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon -->
                                    </button>
                                </form>
                                <span class="tooltiptext">Hapus</span>
                            </div>
                        </td>
                        @endif

                        <!-- JavaScript untuk konfirmasi delete -->
                        <script>
                            function confirmDelete(event) {
                                event.preventDefault(); // Mencegah form submit secara default

                                const confirmed = confirm("Apakah Anda yakin ingin menghapus nilai ini?");

                                if (confirmed) {
                                    event.target.submit(); // Lanjutkan dengan submit jika pengguna mengonfirmasi
                                }
                            }
                        </script>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>