<x-app-layout title="Edit Nilai">
    <div class="p-4 sm:ml-64">
        <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Edit Nilai</h1>
        <form action="{{ route('nilai.update', $nilai->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- User Selection -->
            <div class="mb-6">
                <label for="user_id" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Siswa</label>
                <input type="text" id="user_id" value="{{ $nilai->user->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" readonly>
                <input type="hidden" name="user_id" value="{{ $nilai->user_id }}">
            </div>

            <!-- Mapel Table -->
            <div class="mb-6">
                <h2 class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Mata Pelajaran</h2>
                <table id="mapel-table" class="w-full border border-gray-200 rounded-lg shadow-sm dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="p-4 text-sm font-medium text-gray-500 dark:text-gray-400">Mapel</th>
                            <th class="p-4 text-sm font-medium text-gray-500 dark:text-gray-400">Nilai</th>
                            <th class="p-4 text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mapel-tbody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($nilai->mapels as $index => $mapel)
                        <tr>
                            <td class="p-3">
                                <input type="text" name="mapel[{{ $index }}][name]" value="{{ $mapel->name }}" class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            </td>
                            <td class="p-3">
                                <select name="mapel[{{ $index }}][nilai]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Pilih Nilai</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $mapel->nilai == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                            <td class="p-3">
                                <button type="button" onclick="removeMapelRow(this)" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-900">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" onclick="addMapelRow()" class="mt-4 text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-900">Tambah Mapel</button>
            </div>

            <!-- Nama Sekolah -->
            <div class="mb-6">
                <label for="nama_sekolah" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" id="nama_sekolah" value="{{ $nilai->nama_sekolah }}" class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Sekolah" required>
            </div>

            <!-- Alamat Sekolah -->
            <div class="mb-6">
                <label for="alamat_sekolah" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Alamat Sekolah</label>
                <input type="text" name="alamat_sekolah" id="alamat_sekolah" value="{{ $nilai->alamat_sekolah }}" class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alamat Sekolah" required>
            </div>

            <!-- Projek 1 -->
            <div class="mb-6">
                <label for="projek_1" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Projek 1</label>
                <textarea id="projek_1" name="projek_1" rows="4" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Deskripsi Projek 1....." required>{{ $nilai->projek_1 }}</textarea>
            </div>

            <!-- Projek 2 -->
            <div class="mb-6">
                <label for="projek_2" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Projek 2</label>
                <textarea id="projek_2" name="projek_2" rows="4" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Deskripsi Projek 2....." required>{{ $nilai->projek_2 }}</textarea>
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(count($nilai->mapels) === 0)
                addMapelRow(); // Optional: Add an initial row if no rows exist
            @endif
        });

        function addMapelRow() {
            const tbody = document.getElementById('mapel-tbody');
            const rowCount = tbody.rows.length;
            const row = tbody.insertRow();

            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);

            cell1.innerHTML = `<input type="text" name="mapel[${rowCount}][name]" class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>`;
            cell2.innerHTML = `<select name="mapel[${rowCount}][nilai]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">Pilih Nilai</option>
                                ${Array.from({ length: 10 }, (_, i) => `<option value="${i + 1}">${i + 1}</option>`).join('')}
                              </select>`;
            cell3.innerHTML = `<button type="button" onclick="removeMapelRow(this)" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-900">Hapus</button>`;
        }

        function removeMapelRow(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
</x-app-layout>
