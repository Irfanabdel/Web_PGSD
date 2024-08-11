<x-app-layout title="Tambah Nilai">
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Tambah Nilai</h1>
            <form action="{{ route('nilai.store') }}" method="POST" class="space-y-6">
                @csrf
                <!-- User Selection -->
                <div class="mb-6">
                    <label for="user_id" class="block text-sm font-medium text-gray-900">Siswa</label>
                    <select name="user_id" id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" data-school-name="{{ $user->school_name }}" data-kelas="{{ $user->kelas }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- School Name Display -->
                <div class="mb-6">
                    <label for="school_name" class="block text-sm font-medium text-gray-900">Nama Sekolah</label>
                    <input type="text" id="school_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                </div>

                <!-- Kelas -->
                <div class="mb-6">
                    <label for="kelas" class="block text-sm font-medium text-gray-900">Kelas</label>
                    <input type="text" id="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" readonly>
                </div>

                <!-- Mapel Table -->
                <div class="mb-6">
                    <h2 class="block text-sm font-medium text-gray-900">Mata Pelajaran</h2>
                    <table id="mapel-table" class="w-full border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-4 text-sm font-medium text-gray-500">Mapel</th>
                                <th class="p-4 text-sm font-medium text-gray-500">Nilai</th>
                                <th class="p-4 text-sm font-medium text-gray-500 ">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="mapel-tbody" class="bg-white divide-y divide-gray-200">
                            <!-- Baris mapel akan ditambahkan di sini oleh JavaScript -->
                        </tbody>
                    </table>
                    <button type="button" onclick="addMapelRow()" class="mt-4 text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Mapel</button>
                </div>

                <!-- Projek 1 -->
                <div class="mb-6">
                    <label for="projek_1" class="block text-sm font-medium text-gray-900">Projek 1</label>
                    <textarea id="projek_1" name="projek_1" rows="4" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi Projek 1....." required></textarea>
                </div>

                <!-- Projek 2 -->
                <div class="mb-6">
                    <label for="projek_2" class="block text-sm font-medium text-gray-900">Projek 2</label>
                    <textarea id="projek_2" name="projek_2" rows="4" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Deskripsi Projek 2....." required></textarea>
                </div>

                <button type="submit" class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            addMapelRow(); // Optional: Add an initial row on page load
            
            // Event listener for user selection change
            const userSelect = document.getElementById('user_id');
            const schoolNameInput = document.getElementById('school_name');
            const kelasInput = document.getElementById('kelas');

            userSelect.addEventListener('change', function() {
                const selectedOption = userSelect.options[userSelect.selectedIndex];
                const schoolName = selectedOption.getAttribute('data-school-name');
                const kelas = selectedOption.getAttribute('data-kelas');
                schoolNameInput.value = schoolName ? schoolName : ''; // Set the school name input value
                kelasInput.value = kelas ? kelas : ''; // Set the kelas input value
            });
        });

        function addMapelRow() {
            const tbody = document.getElementById('mapel-tbody');
            const rowCount = tbody.rows.length;
            const row = tbody.insertRow();

            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);

            cell1.innerHTML = `<input type="text" name="mapel[${rowCount}][name]" class="block w-full p-2.5 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base" required>`;
            cell2.innerHTML = `<select name="mapel[${rowCount}][nilai]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Pilih Nilai</option>
                                ${Array.from({ length: 10 }, (_, i) => `<option value="${i + 1}">${i + 1}</option>`).join('')}
                            </select>`;
            cell3.innerHTML = `<button type="button" onclick="removeMapelRow(this)" class="text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center"><i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon --></button>`;
        }

        function removeMapelRow(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
</x-app-layout>
