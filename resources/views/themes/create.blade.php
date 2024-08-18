<x-app-layout title="Tambah Tema">
    <div class="p-4 sm:ml-64">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Tambah Tema</h1>
            <form action="{{ route('themes.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Input Title -->
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul Tema</label>
                    <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-400 focus:border-red-400 block w-full p-2.5" required>
                </div>

                <!-- Dimensi Table -->
                <div class="mb-6">
                    <table id="dimension-table" class="w-full border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-red-500">
                            <tr>
                                <th class="p-4 text-sm font-medium text-white">Dimensi Profil Pelajar Pancasila</th>
                                <th class="p-4 text-sm font-medium text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dimension-tbody" class="bg-white divide-y divide-gray-200">
                            <!-- Baris dimensi akan ditambahkan di sini oleh JavaScript -->
                        </tbody>
                    </table>
                    <button type="button" onclick="addDimensionRow()" class="mt-4 text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Dimensi</button>
                </div>

                <!-- Input Project 1 -->
                <div>
                    <label for="project1" class="block mb-2 text-sm font-medium text-gray-900">Projek 1</label>
                    <input type="text" name="project1" id="project1" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-300 focus:border-red-300 block w-full p-2.5" required>
                </div>

                <!-- Input Project 2 -->
                <div>
                    <label for="project2" class="block mb-2 text-sm font-medium text-gray-900">Projek 2</label>
                    <input type="text" name="project2" id="project2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-red-300 focus:border-red-300 block w-full p-2.5" required>
                </div>

                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            addDimensionRow(); // Add an initial row on page load
        });

        function addDimensionRow() {
            const tbody = document.getElementById('dimension-tbody');
            const row = tbody.insertRow();

            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            cell2.classList.add('text-center');

            cell1.innerHTML = `
                <select name="dimensions[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required>
                    <option value="1">Beriman dan Bertaqwa Kepada Tuhan YME dan Berakhlak Mulia</option>
                    <option value="2">Berkebinekaan Global</option>
                    <option value="3">Bergotong Royong</option>
                    <option value="4">Kreatif</option>
                    <option value="5">Mandiri</option>
                    <option value="6">Bernalar Kritis</option>
                </select>
            `;

            cell2.innerHTML = `
                <button type="button" onclick="removeDimensionRow(this)" class="text-red-600 hover:text-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
        }

        function removeDimensionRow(button) {
            const row = button.closest('tr');
            const tbody = document.getElementById('dimension-tbody');
            if (tbody.rows.length > 1) { // Ensure at least one row remains
                row.remove();
            } else {
                alert("Minimal satu dimensi harus dipilih.");
            }
        }
    </script>
</x-app-layout>
