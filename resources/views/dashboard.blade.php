<x-app-layout title="welcome">
  <div class="p-6 sm:ml-64 pt-4">
    <h1 class="mb-4 text-3xl font-extrabold tracking-tight leading-none md:text-4xl lg:text-5xl text-center fancy-text">
      SELAMAT DATANG DI E-LEARNING P5
    </h1>

    <!--Link ke styles.css-->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <img class="h-auto custom-size rounded-lg mx-auto shadow-lg" src="{{ asset('/image/lebar.png') }}" alt="image description">

    <!-- Menampilkan jumlah guru, siswa, dan learnings -->
    <div class="mb-6 flex justify-center space-x-4">
      <a href="{{ route('learnings.index') }}" class="w-1/6 max-w-xs p-2 bg-blue-200 border border-blue-300 rounded-lg shadow-lg text-center hover-effect">
        <i class="fas fa-lightbulb text-2xl mb-1 text-blue-600"></i>
        <h3 class="text-lg font-bold mb-1">{{ $jumlahLearnings }}</h3>
        <p class="text-sm font-semibold">Pembelajaran</p>
      </a>

      <div class="w-1/6 max-w-xs p-2 bg-blue-200 border border-blue-300 rounded-lg shadow-lg text-center">
        <i class="fas fa-chalkboard-teacher text-2xl mb-1 text-blue-600"></i>
        <h3 class="text-lg font-bold mb-1">{{ $jumlahGuru }}</h3>
        <p class="text-sm font-semibold">Guru</p>
      </div>

      <div class="w-1/6 max-w-xs p-2 bg-blue-200 border border-blue-300 rounded-lg shadow-lg text-center">
        <i class="fas fa-user-graduate text-2xl mb-1 text-blue-600"></i>
        <h3 class="text-lg font-bold mb-1">{{ $jumlahSiswa }}</h3>
        <p class="text-sm font-semibold">Siswa</p>
      </div>
    </div>

  </div>

  <div class="p-6 sm:ml-64 pt-8">
    <h2 class="mb-4 text-2xl font-extrabold tracking-tight leading-tight text-center text md:text-3xl lg:text-4xl">
      Projek Penguatan Profil Pelajar Pancasila
    </h2>

    <!-- Membagi 2 box -->
    <div class="flex flex-col md:flex-row md:space-x-4">
      <div class="flex-1 p-4 bg-white border border-gray-300 rounded-lg shadow-lg mb-4 md:mb-0">
        <img src="{{ asset('/image/modul_p5.png') }}" alt="Deskripsi Gambar 1" class="w-3/4 h-auto mx-auto rounded-lg mb-4">

        <h2 class="text-xl font-bold mb-2 text-center">VISI PENDIDIKAN INDONESIA</h2>
        <p class="text-justify mb-4">
          "Mewujudkan Indonesia maju yang berdaulat, mandiri, dan berkepribadian melalui terciptanya pelajar Pancasila."
        </p>

        <h2 class="text-xl font-bold mb-2 text-center">PROFIL PELAJAR PANCASILA</h2>
        <p class="text-justify mb-4">
          “Pelajar Indonesia merupakan pelajar sepanjang hayat yang kompeten, berkarakter, dan berperilaku sesuai nilai-nilai Pancasila.”
        </p>

        <p class="text-justify mb-4">
          Proyek penguatan profil pelajar Pancasila adalah inisiatif yang bertujuan untuk mengembangkan karakter dan kompetensi pelajar Indonesia sesuai dengan nilai-nilai Pancasila. Profil pelajar Pancasila merujuk pada gambaran atau deskripsi tentang bagaimana seharusnya peserta didik yang dihasilkan oleh sistem pendidikan Indonesia, yang memiliki kompetensi, karakter, dan perilaku yang sesuai dengan nilai-nilai Pancasila.
        </p>
        <p class="text-justify mb-4">
          Profil Pelajar Pancasila memiliki 6 dimensi utama meliputi:
        </p>
        <ul class="list-disc list-inside mb-4">
          <li>Beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia.</li>
          <li>Berkebinekaan global.</li>
          <li>Bergotong-royong.</li>
          <li>Mandiri.</li>
          <li>Bernalar kritis.</li>
          <li>Kreatif.</li>
        </ul>
        <p class="text-justify mb-4">
          Salah satu langkah untuk mewujudkan Profil Pelajar Pancasila tersebut dilakukan melalui Projek Penguatan Profil Pelajar Pancasila (P5), yaitu pembelajaran lintas disiplin ilmu dalam mengamati dan memikirkan solusi terhadap permasalahan di lingkungan sekitar untuk menguatkan berbagai kompetensi dalam Profil Pelajar Pancasila.
        </p>
      </div>

      <div class="flex-1 p-4 bg-white border border-gray-300 rounded-lg shadow-lg">
        <img src="{{ asset('/image/modul_p5_2.png') }}" alt="Deskripsi Gambar 2" class="w-full h-auto rounded-lg mb-4">

        <p class="text-justify mb-4">
          Proyek penguatan profil pelajar Pancasila adalah inisiatif yang bertujuan untuk mengembangkan karakter dan kompetensi pelajar Indonesia sesuai dengan nilai-nilai Pancasila. Profil pelajar Pancasila merujuk pada gambaran atau deskripsi tentang bagaimana seharusnya peserta didik yang dihasilkan oleh sistem pendidikan Indonesia, yang memiliki kompetensi, karakter, dan perilaku yang sesuai dengan nilai-nilai Pancasila.
        </p>

        <p class="text-justify mb-4">
          Profil pelajar Pancasila adalah karakter dan kemampuan yang dibangun dalam keseharian dan dihidupkan dalam diri setiap individu peserta didik melalui:
        </p>

        <ol class="list-decimal pl-4 mb-4">
          <li class="mb-2">
            <strong>Budaya satuan pendidikan</strong><br>
            Iklim satuan pendidikan, kebijakan, pola interaksi dan komunikasi, serta norma yang berlaku di satuan pendidikan.
          </li>
          <li class="mb-2">
            <strong>Pembelajaran intrakurikuler</strong><br>
            a. Muatan pembelajaran<br>
            b. Kegiatan/pengalaman belajar
          </li>
          <li class="mb-2">
            <strong>Projek penguatan profil pelajar Pancasila</strong><br>
            Projek Lintas Disiplin Ilmu yang kontekstual dan berbasis pada kebutuhan masyarakat atau permasalahan di lingkungan satuan pendidikan. (Pada pendidikan kesetaraan berupa projek pemberdayaan dan keterampilan berbasis profil Pelajar Pancasila).
          </li>
          <li>
            <strong>Ekstrakurikuler</strong><br>
            Kegiatan untuk mengembangkan minat dan bakat.
          </li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Copyright -->
  <footer class="p-4 bg-gray-200 text-center mt-8">
    <p class="text-sm font-semibold text-gray-600">
      &copy; {{ date('Y') }} E-Learning P5 Ileena Ramadhanti. Semua Hak Dilindungi.
    </p>
  </footer>
<<<<<<< HEAD
</x-app-layout>
=======
</x-app-layout>
>>>>>>> d35f0ed52beb3759733dcea8c823283b821ac99f
