<x-app-layout title="Empty Nilai">
    <div class="p-4 sm:ml-64">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-black md:text-4xl lg:text-5xl text-center">
                Sabar ya, hasil belajar belum tersedia saat ini.
            </p>
            <!--Link ke styles.css-->
            <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
            <div class="h-auto custom-size rounded-lg mx-auto">
                <img src="{{ asset('/image/guru.png') }}" alt="Tidak Ada Data" class="w-full h-auto rounded-lg">
            </div>
        </div>
    </div>
</x-app-layout>