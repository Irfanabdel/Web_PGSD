<x-app-layout title="Pembelajaran">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
            <div class="w-full mb-4 text-center">
                <p class="text-xl font-extrabold tracking-tight leading-tight text-red-500 md:text-3xl lg:text-3xl">
                    Pembelajaran
                </p>
                <p class="text-lg font-extrabold tracking-tight leading-tight text-gray-600 md:text-2xl lg:text-2xl">
                    Projek Penguatan Profil Pelajar Pancasila
                </p>
            </div>

            <!-- Menambahkan container flex untuk tombol -->
            @if(auth()->user()->role === 'guru')
            <div class="flex justify-end mb-4">
                <a href="{{ route('learnings.create') }}">
                    <button class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
                        Tambah Pembelajaran
                    </button>
                </a>
            </div>
            @endif

            <!-- Garis Pembatas -->
            <hr class="border-gray-300 mb-6">

            <!-- Loop melalui data learnings -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($learnings as $learning)
                <!-- Filter untuk siswa berdasarkan user_kelas -->
                @if(auth()->user()->role === 'siswa' && $learning->user_kelas !== auth()->user()->kelas)
                @continue
                @endif

                <!-- Link ke halaman detail learning -->
                <div class="relative bg-gray-100 border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-200 custom-hover">
                    <!-- Link ke halaman detail learning -->
                    <a href="{{ route('learnings.show', $learning->id) }}" class="block">
                        <!-- Nama Tema dan Kelas di atas gambar -->
                        <div class="absolute top-0 left-0 bg-yellow-500 text-white font-bold p-2 rounded-br-lg z-10">
                            <p>{{ $learning->theme->title }}</p>
                        </div>

                        <!-- Gambar Cover -->
                        @if ($learning->cover_image)
                        <img src="{{ Storage::url($learning->cover_image) }}" alt="Cover Image" class="w-full h-48 object-cover">
                        @else
                        <!-- Placeholder jika tidak ada gambar, gunakan gambar default -->
                        <img src="{{ asset('image/default_cover.jpg') }}" alt="Default Cover Image" class="w-full h-48 object-cover">
                        @endif

                        <!-- Tambahkan informasi tambahan di bawah gambar -->
                        <div class="p-4">
                            <p class="text-lg font-bold">
                                <!-- Ganti <br> dengan koma -->
                                {{ str_replace('<br>', ', ', $learning->theme->dimensions_text ?? 'Dimensi Tidak Tersedia') }}
                            </p>
                            <p>Kelas : {{ $learning->user_kelas }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</x-app-layout>