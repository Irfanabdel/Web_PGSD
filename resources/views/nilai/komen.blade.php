<x-app-layout title="komentar">
    <div class="p-4 sm:ml-64">
    <h1 class="text-xl font-extrabold tracking-tight leading-none text-black md:text-3xl lg:text-3xl">Forum Diskusi Bersama</h1>

        <!-- Formulir untuk mengunggah komentar dan gambar -->
        <form action="{{ route('komen.store') }}" method="POST" enctype="multipart/form-data" class="mb-8">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul:</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            </div>
            <div class="mb-4">
                <label for="Desc" class="block text-sm font-medium text-gray-700">Deskripsi:</label>
                <textarea id="Desc" name="Desc" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar:</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full" />
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Submit</button>
        </form>
        
        <!-- Menampilkan daftar komentar -->
        @foreach ($komen as $item)
            <div class="mb-4 p-4 border border-gray-200 rounded-md">
                <h1 class="text-xl font-extrabold tracking-tight leading-none text-black md:text-3xl lg:text-3xl">{{ $item->title }}</h1>
                <p class="mb-2">{{ $item->Desc }}</p>
                @if ($item->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="Image" class="w-32 h-auto rounded-md shadow-md">
                    </div>
                @endif

                <!-- Menampilkan komentar terkait item Komen -->
                <livewire:comments :model="$item"/>
            </div>
        @endforeach
    </div>
</x-app-layout>
