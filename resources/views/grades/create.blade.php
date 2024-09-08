<x-app-layout title="Tambah Nilai">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Tambah Nilai</h1>
            <form action="{{ route('grades.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- User Selection -->
                <div class="mb-6">
                    <label for="user_id" class="block text-sm font-medium text-gray-900 mb-2">Siswa</label>
                    <select name="user_id" id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                        <option value="" disabled selected>Pilih Siswa</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" data-school-name="{{ $user->school_name }}" data-kelas="{{ $user->kelas }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- School Name Display -->
                <div class="mb-6">
                    <label for="school_name" class="block text-sm font-medium text-gray-900 mb-2">Nama Sekolah</label>
                    <div id="school_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">-</div>
                </div>

                <!-- Kelas -->
                <div class="mb-6">
                    <label for="kelas" class="block text-sm font-medium text-gray-900 mb-2">Kelas</label>
                    <div id="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">-</div>
                </div>

                <!-- Pilih Tema -->
                <div class="mb-6">
                    <label for="theme_id" class="block text-sm font-medium text-gray-900 mb-2">Pilih Tema</label>
                    <select name="theme_id" id="theme_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                        <option value="" disabled selected>Pilih Tema</option>
                        @foreach($themes as $theme)
                        <option value="{{ $theme->id }}"
                            data-project1="{{ $theme->project1 }}"
                            data-project2="{{ $theme->project2 }}"
                            data-dimensions="{{ $theme->dimensions_text }}">
                            {{ $theme->title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dimensi Tema -->
                <div class="mb-6">
                    <table id="dimensions-table" class="w-full border border--200 rounded-lg shadow-sm">
                        <thead class="bg-red-500">
                            <tr>
                                <th class="p-4 text-sm font-medium text-white">Dimensi</th>
                                <th class="p-4 text-sm font-medium text-white">Penilaian</th>
                                <th class="p-4 text-sm font-medium text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dimensions-tbody" class="bg-white divide-y divide-gray-200">
                            <!-- Rows will be added here dynamically -->
                        </tbody>
                    </table>
                    <!-- Keterangan di bawah tabel -->
                    <p class="mt-4 text-sm text-gray-600">Keterangan:</p>
                    <p class="text-sm text-gray-600">BB: Baru Berkembang | MB: Masih Berkembang | BSH: Berkembang Sesuai Harapan | SB: Sangat Berkembang</p>
                </div>

                <!-- Proyek 1 -->
                <div class="mb-6">
                    <label for="project1" class="block mb-2 text-sm font-medium text-gray-900">Projek 1</label>
                    <div id="project1" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-2.5">-</div>
                </div>

                <!-- Proyek 2 -->
                <div class="mb-6">
                    <label for="project2" class="block mb-2 text-sm font-medium text-gray-900">Projek 2</label>
                    <div id="project2" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg w-full p-2.5">-</div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeSelect = document.getElementById('theme_id');
            const project1Div = document.getElementById('project1');
            const project2Div = document.getElementById('project2');
            const schoolNameDiv = document.getElementById('school_name');
            const kelasDiv = document.getElementById('kelas');
            const userSelect = document.getElementById('user_id');
            const dimensionsTbody = document.getElementById('dimensions-tbody');

            // Event listener untuk saat siswa dipilih
            userSelect.addEventListener('change', function() {
                const selectedOption = userSelect.options[userSelect.selectedIndex];
                const schoolName = selectedOption.getAttribute('data-school-name') || '';
                const kelas = selectedOption.getAttribute('data-kelas') || '';

                schoolNameDiv.textContent = schoolName;
                kelasDiv.textContent = kelas;
            });

            // Event listener untuk saat tema dipilih
            themeSelect.addEventListener('change', function() {
                const selectedOption = themeSelect.options[themeSelect.selectedIndex];
                const project1 = selectedOption.getAttribute('data-project1') || '';
                const project2 = selectedOption.getAttribute('data-project2') || '';
                const dimensionsText = selectedOption.getAttribute('data-dimensions') || '';

                project1Div.textContent = project1;
                project2Div.textContent = project2;
                updateDimensionsTable(dimensionsText); // Update table with dimensions
            });

            function updateDimensionsTable(dimensionsText) {
                dimensionsTbody.innerHTML = ''; // Clear existing rows
                const dimensions = dimensionsText.split("<br>").filter(dimension => dimension.trim() !== ''); // Split and filter out empty dimensions

                dimensions.forEach(dimension => {
                    // Assuming dimension is separated by '|' if multiple entries in one line
                    const dimensionEntries = dimension.split(',').map(d => d.trim()).filter(d => d !== ''); // Split and trim dimension entries

                    dimensionEntries.forEach(dimension => {
                        const row = dimensionsTbody.insertRow();
                        const cell1 = row.insertCell(0);
                        const cell2 = row.insertCell(1);
                        const cell3 = row.insertCell(2);

                        cell1.innerHTML = `
                            <div class="bg-transparent border-0 text-gray-900 text-sm rounded-lg w-full p-2.5">
                             ${dimension}
                            </div>
                        `;

                        // Provide default values if necessary
                        const defaultAssessment = ""; // Example default value

                        cell2.innerHTML = `
                        <select name="assessments[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih Asesmen</option>
                            <option value="1">BB</option>
                            <option value="2">MB</option>
                            <option value="3">BSH</option>
                            <option value="4">SB</option>
                        </select>
                        `;

                        cell3.classList.add('text-center');
                        cell3.innerHTML = `
                <button type="button" onclick="removeDimensionRow(this)" class="text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
                    });
                });
            }

            function removeDimensionRow(button) {
                const row = button.closest('tr');
                if (dimensionsTbody.rows.length > 1) {
                    row.remove();
                } else {
                    alert('Setidaknya harus ada satu baris dimensi.');
                }
            }
        });
    </script>
</x-app-layout>