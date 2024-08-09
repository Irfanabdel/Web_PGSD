<x-app-layout title="Nilai Guru">
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Daftar Nilai Siswa</h1>
                </div>
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex justify-between items-center mb-4 sm:mb-0">
                    </div>
                    <a href="{{ route('nilai.create') }}">
                        <button class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-900" type="button">
                            Tambah Nilai Siswa
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabel Nilai -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="p-4 text-center">
                            <div class="flex items-center justify-center">
                                <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-yellow-300 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all" class="sr-only">Checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Nama Siswa</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Kelas</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Nama Sekolah</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Mata Pelajaran</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Nilai</th>
                        <th scope="col" class="p-4 text-xs font-medium text-center text-gray-500 uppercase dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($nilai as $item)
                    @foreach($item->mapels as $mapel)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="w-4 p-4 text-center">
                            <div class="flex items-center justify-center">
                                <input id="checkbox-{{ $item->id }}" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-yellow-300 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-{{ $item->id }}" class="sr-only">Checkbox</label>
                            </div>
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center">{{ $item->user->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center">{{ $item->user->kelas }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center">{{ $item->nama_sekolah }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center">{{ $mapel->name }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap text-center">{{ $mapel->nilai }}</td>
                        @if($loop->first)
                        <td rowspan="{{ $item->mapels->count() }}" class="p-4 space-x-2 whitespace-nowrap text-center">
                            <!-- Ubah Icon -->
                            <a href="{{ route('nilai.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800 transition-colors">
                                <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                            </a>

                            <!-- Hapus Icon -->
                            <form action="{{ route('nilai.destroy', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800 transition-colors">
                                    <i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon -->
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>