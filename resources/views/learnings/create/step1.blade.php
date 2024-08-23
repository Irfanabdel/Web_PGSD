<x-app-layout title="Deskripsi Pembelajaran">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <!-- Info Step -->
            <div class="mb-6 flex justify-center items-center">
                <p class="text-2xl font-bold text-gray-900">
                    <span class="text-red-500">Step 1</span> dari 2
                </p>
            </div>

            <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-8">Deskripsi Pembelajaran</h1>
            <form action="{{ route('learnings.store.step1') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Pilih Tema -->
                <div class="mb-8">
                    <label for="theme_id" class="block text-sm font-medium text-gray-900 mb-2">Pilih Tema</label>
                    <select name="theme_id" id="theme_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                        <option value="" disabled selected>Pilih Tema</option>
                        @foreach($themes as $theme)
                        <option value="{{ $theme->id }}" data-dimensions="{{ $theme->dimensions_text }}" {{ isset($learningData['theme_id']) && $learningData['theme_id'] == $theme->id ? 'selected' : '' }}>
                            {{ $theme->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('theme_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas Selection -->
                <div class="mb-8">
                    <label for="user_kelas" class="block text-sm font-medium text-gray-900 mb-2">Kelas</label>
                    <select name="user_kelas" id="user_kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        @foreach($kelas as $kelasItem)
                        <option value="{{ $kelasItem }}" {{ isset($learningData['user_kelas']) && $learningData['user_kelas'] == $kelasItem ? 'selected' : '' }}>
                            {{ $kelasItem }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_kelas')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dimensi Tema -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Dimensi</label>
                    <ul id="dimensions-list" class="list-disc pl-5 space-y-1">
                        <!-- Dimensi akan diisi oleh JavaScript -->
                        @if(isset($learningData['theme_id']))
                        @php
                        $theme = $themes->firstWhere('id', $learningData['theme_id']);
                        $dimensionsText = $theme ? $theme->dimensions_text : '';
                        @endphp
                        @if($dimensionsText)
                        @foreach(explode('<br>', $dimensionsText) as $dimension)
                        <li>{{ trim($dimension) }}</li>
                        @endforeach
                        @endif
                        @endif
                    </ul>
                </div>

                <!-- Input Elemen -->
                <div class="mb-8">
                    <label for="element" class="block mb-2 text-sm font-medium text-gray-900">Elemen</label>
                    <input type="text" name="element" id="element" value="{{ old('element', $learningData['element'] ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>
                    @error('element')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Tujuan -->
                <div class="mb-8">
                    <label for="goals" class="block mb-2 text-sm font-medium text-gray-900">Tujuan</label>
                    <textarea name="goals" id="goals" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>{{ old('goals', $learningData['goals'] ?? '') }}</textarea>
                    @error('goals')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Cover Image -->
                <div class="mb-8">
                    <label for="cover_image" class="block text-sm font-medium text-gray-900 mb-2">Upload Gambar Cover</label>
                    <input type="file" name="cover_image" id="cover_image" class="border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Ukuran maksimal gambar adalah 5 MB. Format yang diterima: JPEG, PNG, JPG.</p>
                </div>

                <!-- Tombol Next -->
                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Next</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeSelect = document.getElementById('theme_id');
            const dimensionsList = document.getElementById('dimensions-list');

            // Update dimensi sesuai tema yang dipilih
            themeSelect.addEventListener('change', function() {
                const selectedOption = themeSelect.options[themeSelect.selectedIndex];
                const dimensionsText = selectedOption.getAttribute('data-dimensions') || '';

                updateDimensionsList(dimensionsText); // Update list with dimensions
            });

            function updateDimensionsList(dimensionsText) {
                dimensionsList.innerHTML = ''; // Clear existing dimensions

                if (dimensionsText) {
                    // Ganti "<br>" dengan pemisah baris baru dan kemudian pisahkan teks
                    const dimensions = dimensionsText.split('<br>').map(d => d.trim()).filter(d => d.length > 0);
                    dimensions.forEach(dimension => {
                        const li = document.createElement('li');
                        li.textContent = dimension;
                        dimensionsList.appendChild(li);
                    });
                }
            }

            // Initialize TinyMCE for the goals textarea
            tinymce.init({
                selector: '#goals',
                plugins: 'lists',
                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist',
                menubar: false
            });

            // Initialize dimensions list on page load
            const initialDimensionsText = themeSelect.querySelector('option:checked')?.getAttribute('data-dimensions') || '';
            updateDimensionsList(initialDimensionsText);
        });
    </script>
</x-app-layout>