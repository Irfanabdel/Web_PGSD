<x-app-layout title="Deskripsi Pembelajaran">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Info Step -->
            <div class="flex justify-center items-center">
                <p class="text-2xl font-bold text-gray-900">
                    <span class="text-red-500">Step 1</span>
                </p>
            </div>

            <h1 class="text-2xl flex justify-center font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-8">Deskripsi Pembelajaran</h1>
            <form action="{{ route('learnings.store.step1') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Pilih Tema -->
                <div class="mb-4">
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
                <div class="mb-4">
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
                <div class="mb-4">
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

                <!-- Input Tujuan menggunakan TinyMCE -->
                <div class="mb-4">
                    <label for="goals" class="block mb-2 text-sm font-medium text-gray-900">Capaian Pembelajaran</label>
                    <textarea name="goals" id="goals" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-yellow-400 focus:border-yellow-400 block w-full p-2.5" required>{{ old('goals', $learningData['goals'] ?? '') }}</textarea>
                    @error('goals')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Cover Image -->
                <div class="mb-4">
                    <label for="cover_image" class="block text-sm font-medium text-gray-900 mb-2">Upload Gambar Cover</label>
                    <input type="file" name="cover_image" id="cover_image" class="mt-1 block w-full text-gray-900 border border-white rounded-lg" accept="image/*">
                    <p class="mt-1 text-sm text-gray-500">Ukuran maksimal gambar adalah 5 MB. Format yang diterima: JPEG, PNG, JPG.</p>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/alb42zv55n2f3tyry7ir4vpjl69aaxbwn30db6omng9lmsj5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeSelect = document.getElementById('theme_id');
            const dimensionsList = document.getElementById('dimensions-list');

            // Update dimensi sesuai tema yang dipilih
            themeSelect.addEventListener('change', function() {
                const selectedOption = themeSelect.options[themeSelect.selectedIndex];
                const dimensionsText = selectedOption.getAttribute('data-dimensions') || '';

                updateDimensionsList(dimensionsText); // Update daftar dimensi
            });

            function updateDimensionsList(dimensionsText) {
                dimensionsList.innerHTML = ''; // Kosongkan dimensi yang ada

                if (dimensionsText) {
                    // Ganti "<br>" dengan baris baru lalu pisahkan teksnya
                    const dimensions = dimensionsText.split('<br>').map(d => d.trim()).filter(d => d.length > 0);
                    dimensions.forEach(dimension => {
                        const li = document.createElement('li');
                        li.textContent = dimension;
                        dimensionsList.appendChild(li);
                    });
                }
            }

            // Inisialisasi daftar dimensi saat halaman dimuat
            const initialDimensionsText = themeSelect.querySelector('option:checked')?.getAttribute('data-dimensions') || '';
            updateDimensionsList(initialDimensionsText);

             // Inisialisasi TinyMCE untuk textarea 'goals'
             tinymce.init({
                selector: '#goals',
                plugins: 'lists link image',
                toolbar: 'undo redo | bold italic underline | bullist numlist | link image',
                menubar: false,
                branding: false,
                height: 300,
                content_style: "body { font-family:Arial,Helvetica,sans-serif; font-size:14px }",
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave(); // Sinkronkan konten TinyMCE dengan textarea
                    });
                }
            });
        });
    </script>
</x-app-layout>