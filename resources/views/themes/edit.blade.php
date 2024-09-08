<x-app-layout title="Edit Tema">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Edit Tema</h1>
            <form action="{{ route('themes.update', $theme->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Input Title -->
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 mb-2">Judul Tema</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $theme->title) }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
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
                            @foreach(json_decode($theme->dimensions, true) as $dimension)
                            <tr>
                                <td class="p-4">
                                    <select name="dimensions[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                                        <option value="1" {{ $dimension == 1 ? 'selected' : '' }}>Beriman dan Bertaqwa Kepada Tuhan YME dan Berakhlak Mulia</option>
                                        <option value="2" {{ $dimension == 2 ? 'selected' : '' }}>Berkebinekaan Global</option>
                                        <option value="3" {{ $dimension == 3 ? 'selected' : '' }}>Bergotong Royong</option>
                                        <option value="4" {{ $dimension == 4 ? 'selected' : '' }}>Kreatif</option>
                                        <option value="5" {{ $dimension == 5 ? 'selected' : '' }}>Mandiri</option>
                                        <option value="6" {{ $dimension == 6 ? 'selected' : '' }}>Bernalar Kritis</option>
                                    </select>
                                </td>
                                <td class="p-4 text-center">
                                    <button type="button" onclick="removeDimensionRow(this)" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" onclick="addDimensionRow()" class="mt-4 text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah Dimensi</button>
                </div>

                <!-- Input Project 1 -->
                <div>
                    <label for="project1" class="block mb-2 text-sm font-medium text-gray-900 mb-2">Projek 1</label>
                    <input type="text" name="project1" id="project1" value="{{ old('project1', $theme->project1) }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                </div>

                <!-- Input Project 2 -->
                <div>
                    <label for="project2" class="block mb-2 text-sm font-medium text-gray-900 mb-2">Projek 2</label>
                    <input type="text" name="project2" id="project2" value="{{ old('project2', $theme->project2) }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize with existing dimensions
            @if(json_decode($theme->dimensions, true))
                // Existing dimensions already handled
            @else
                addDimensionRow(); // Add an initial row if none exist
            @endif
        });

        function addDimensionRow() {
            const tbody = document.getElementById('dimension-tbody');
            const row = tbody.insertRow();

            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            cell2.classList.add('text-center');

            cell1.innerHTML = `
                <select name="dimensions[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                    <option value="1">Beriman dan Bertaqwa Kepada Tuhan YME dan Berakhlak Mulia</option>
                    <option value="2">Berkebinekaan Global</option>
                    <option value="3">Bergotong Royong</option>
                    <option value="4">Kreatif</option>
                    <option value="5">Mandiri</option>
                    <option value="6">Bernalar Kritis</option>
                </select>
            `;

            cell2.innerHTML = `
                <button type="button" onclick="removeDimensionRow(this)" class="text-white bg-red-400 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center">
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
