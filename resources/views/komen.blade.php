<x-app-layout title="komentar">
    <div class="p-6 sm:ml-64">
        <h1 class="text-2xl font-extrabold tracking-tight leading-tight text-gray-900 md:text-4xl lg:text-4xl mb-6">Forum Diskusi Bersama</h1>

        <!-- Formulir untuk mengunggah komentar dan gambar -->
        <form action="{{ route('komen.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 mb-8 border border-gray-200">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul:</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div class="mb-4">
                <label for="Desc" class="block text-sm font-medium text-gray-700">Deskripsi:</label>
                <textarea id="Desc" name="Desc" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar:</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full" />
            </div>
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Submit</button>
        </form>

        <!-- Menampilkan daftar komentar -->
        @foreach ($komen as $item)
        <div class="relative mb-4 p-6 bg-white border border-gray-200 rounded-lg shadow-md">
            <h1 class="text-xl font-extrabold tracking-tight leading-none text-black md:text-2xl lg:text-3xl mb-2">{{ $item->title }}</h1>
            <p class="mb-4 text-gray-700">{{ $item->Desc }}</p>
            @if ($item->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $item->image) }}" alt="Image" class="w-full max-w-xs rounded-md shadow-md">
            </div>
            @endif

            <!-- Tambahkan link ke file CSS -->
            <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

            @if (auth()->user()->role === 'guru')
            <form action="{{ route('komen.destroy', $item->id) }}" method="POST" class="absolute top-4 right-4" onsubmit="return confirmDelete(event)">
                @csrf
                @method('DELETE')
                <button type="submit" class="tooltip text-red-600 hover:text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M9 6v12m6-12v12m-3-12v12m-7 4h14a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v16a1 1 0 001 1z" />
                    </svg>
                    <span class="tooltiptext">Hapus</span>
                </button>
            </form>
            @endif

            <!-- Tambahkan JavaScript untuk konfirmasi -->
            <script>
                function confirmDelete(event) {
                    event.preventDefault(); // Mencegah form submit secara default

                    const confirmed = confirm("Apakah Anda yakin ingin menghapus diskusi ini?");

                    if (confirmed) {
                        event.target.submit(); // Melanjutkan dengan submit jika pengguna mengonfirmasi
                    }
                }
            </script>

            <!-- Menampilkan komentar terkait item Komen -->
            <livewire:comments :model="$item" />
        </div>
        @endforeach
    </div>
</x-app-layout>