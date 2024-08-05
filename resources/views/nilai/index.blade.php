<x-app-layout title="Welcome">
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Nilai Siswa</h1>
                </div>
                <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex justify-between items-center mb-4 sm:mb-0">
                    </div>
                    <a href="{{ route('nilai.create') }}">
                        <button class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800" type="button">
                            Tambah Nilai Siswa
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-yellow-300 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all" class="sr-only">Checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama Siswa</th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Kelas</th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama Sekolah</th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nilai Berempati</th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nilai Pemahaman Agama</th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nilai Mengutamakan Perasaan</th>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($nilai as $item)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-{{ $item->id }}" aria-describedby="checkbox-1" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-yellow-300 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-{{ $item->id }}" class="sr-only">Checkbox</label>
                            </div>
                        </td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap">{{ $item->user->name  }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap">{{ $item->user->kelas }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap">{{ $item->nama_sekolah }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap">{{ $item->nilai_mapel_1 }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap">{{ $item->nilai_mapel_2 }}</td>
                        <td class="p-4 text-sm font-normal text-gray-800 whitespace-nowrap">{{ $item->nilai_mapel_3 }}</td>
                        <td class="p-4 space-x-2 whitespace-nowrap">
                            <!-- Tambah button View dengan ID siswa -->

                                <a href="{{ route('nilai.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                                    Ubah
                                </a>
                               
                                <form action="{{ route('nilai.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            
                          
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
