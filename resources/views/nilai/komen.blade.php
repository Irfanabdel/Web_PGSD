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
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit</button>
        </form>
        
        <!-- Menampilkan daftar komentar -->
        @foreach ($komen as $item)
            <div class="mb-4 p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <h1 class="text-xl font-extrabold tracking-tight leading-none text-black md:text-2xl lg:text-3xl mb-2">{{ $item->title }}</h1>
                <p class="mb-4 text-gray-700">{{ $item->Desc }}</p>
                @if ($item->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Image" class="w-full max-w-xs rounded-md shadow-md">
                    </div>
                @endif

                <!-- Menampilkan komentar terkait item Komen -->
                <livewire:comments :model="$item"/>
            </div>
        @endforeach
    </div>
</x-app-layout>
