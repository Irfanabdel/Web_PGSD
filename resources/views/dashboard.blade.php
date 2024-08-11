<x-app-layout title="welcome">
  <div class="p-4 sm:ml-64">
    <h1 class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-black md:text-4xl lg:text-5xl text-center">
      Selamat Datang di E-Learning P5
    </h1>

    <!--Link ke styles.css-->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <img class="h-auto custom-size rounded-lg mx-auto" src="{{ asset('/image/lebar.png') }}" alt="image description">

    <h2 class="mb-4 text-2xl font-extrabold tracking-tight leading-tight text-red-500 md:text-3xl lg:text-4xl text-center">
      Projek Penguatan Profil Pelajar Pancasila
    </h2>


    <!--Membagi 2 box-->
    <div class="box-container">
      <div class="box" style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <img src="{{ asset('/image/modul_p5.png') }}" alt="Deskripsi Gambar 1" style="width: 300px; height: auto; display: block; margin: 0 auto;" class="rounded-lg">

        <h2 style="margin-top: 20px; font-size: 24px; font-weight: bold; text-align: center;">VISI PENDIDIKAN INDONESIA</h2>
        <p style="text-align: justify; margin-top: 10px;">
          "Mewujudkan Indonesia maju yang berdaulat, mandiri, dan berkepribadian melalui terciptanya pelajar Pancasila."
        </p>

        <h2 style="margin-top: 20px; font-size: 24px; font-weight: bold; text-align: center;">PROFIL PELAJAR PANCASILA</h2>
        <p style="text-align: justify; margin-top: 10px;">
          “Pelajar Indonesia merupakan pelajar sepanjang hayat yang kompeten, berkarakter, dan berperilaku sesuai nilai-nilai Pancasila.”
        </p>

        <p style="text-align: justify; margin-top: 15px;">
          Proyek penguatan profil pelajar Pancasila adalah inisiatif yang bertujuan untuk mengembangkan karakter dan kompetensi pelajar Indonesia sesuai dengan nilai-nilai Pancasila. Profil pelajar Pancasila merujuk pada gambaran atau deskripsi tentang bagaimana seharusnya peserta didik yang dihasilkan oleh sistem pendidikan Indonesia, yang memiliki kompetensi, karakter, dan perilaku yang sesuai dengan nilai-nilai Pancasila.
        </p>
      </div>

      <div class="box" style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <img src="{{ asset('/image/modul_p5_2.png') }}" alt="Deskripsi Gambar 2" style="width: 100%; height: auto; display: block; margin: 0 auto;" class="rounded-lg">

        <p style="text-align: justify; margin-top: 20px;">
          Proyek penguatan profil pelajar Pancasila adalah inisiatif yang bertujuan untuk mengembangkan karakter dan kompetensi pelajar Indonesia sesuai dengan nilai-nilai Pancasila. Profil pelajar Pancasila merujuk pada gambaran atau deskripsi tentang bagaimana seharusnya peserta didik yang dihasilkan oleh sistem pendidikan Indonesia, yang memiliki kompetensi, karakter, dan perilaku yang sesuai dengan nilai-nilai Pancasila.
        </p>

        <p style="text-align: justify; margin-top: 20px;">
          Profil pelajar Pancasila adalah karakter dan kemampuan yang dibangun dalam keseharian dan dihidupkan dalam diri setiap individu peserta didik melalui:
        </p>

        <ol style="margin-top: 10px; padding-left: 20px;">
          <li style="margin-bottom: 15px;">
            <strong>Budaya satuan pendidikan</strong><br>
            Iklim satuan pendidikan, kebijakan, pola interaksi dan komunikasi, serta norma yang berlaku di satuan pendidikan.
          </li>
          <li style="margin-bottom: 15px;">
            <strong>Pembelajaran intrakurikuler</strong><br>
            a. Muatan pembelajaran<br>
            b. Kegiatan/pengalaman belajar
          </li>
          <li style="margin-bottom: 15px;">
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

</x-app-layout>