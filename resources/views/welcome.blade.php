<x-app-layout title="welcome">

<section class="flex items-center justify-center rounded bg-white dark:bg-gray-800">
  <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
      <div class="flex flex-col justify-center">
          <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Projek Penguatan Profil Pelajar Pancasila</h1>
          <p class="mb-6 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Proyek penguatan profil pelajar Pancasila adalah inisiatif yang bertujuan untuk mengembangkan karakter dan kompetensi pelajar Indonesia sesuai dengan nilai-nilai Pancasila. Profil pelajar Pancasila merujuk pada gambaran atau deskripsi tentang bagaimana seharusnya peserta didik yang dihasilkan oleh sistem pendidikan Indonesia, yang memiliki kompetensi, karakter, dan perilaku yang sesuai dengan nilai-nilai Pancasila</p>
          
          </a>
          <div class=" space-y-4 sm:flex-row sm:space-y-0">
            <a href="{{route ('login') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
              Masuk
              <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
             </svg>
            </a>
           
            <a href="{{route ('register') }}" class="inline-flex justify-center hover:text-red-900 items-center py-3 px-5  text-base font-medium text-center text-gray-900 rounded-lg border border-red hover:bg-red-100 focus:ring-4 focus:ring-red-300"> Buat Akun
              <svg xmlns="http://www.w3.org/2000/svg"  fill="currentColor"  aria-hidden="true"  class="w-4 h-4 ms-2 rtl:rotate-180" viewBox="0 0 16 16">
                <path d="M10.175 1.991c.81 1.312 1.583 3.43 1.778 6.819l1.5 1.83A2.5 2.5 0 0 1 14 12.202V15.5a.5.5 0 0 1-.9.3l-1.125-1.5c-.166-.222-.42-.4-.752-.57-.214-.108-.414-.192-.627-.282l-.196-.083C9.7 13.793 8.85 14 8 14s-1.7-.207-2.4-.635q-.101.044-.198.084c-.211.089-.411.173-.625.281-.332.17-.586.348-.752.57L2.9 15.8a.5.5 0 0 1-.9-.3v-3.298a2.5 2.5 0 0 1 .548-1.562l.004-.005L4.049 8.81c.197-3.323.969-5.434 1.774-6.756.466-.767.94-1.262 1.31-1.57a3.7 3.7 0 0 1 .601-.41A.55.55 0 0 1 8 0c.101 0 .17.027.25.064q.056.025.145.075c.118.066.277.167.463.315.373.297.85.779 1.317 1.537M9.5 6c0-1.105-.672-2-1.5-2s-1.5.895-1.5 2S7.172 8 8 8s1.5-.895 1.5-2"/>
                <path d="M8 14.5c.5 0 .999-.046 1.479-.139L8.4 15.8a.5.5 0 0 1-.8 0l-1.079-1.439c.48.093.98.139 1.479.139"/>
              </svg>
            </a>
        </div>
      </div>
          <img srcset="{{asset('garuda.png')}}" class="w-full h-auto max-w-sm rounded-lg mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16" alt="image description">
      </div>
  </div>
</section>
  </x-app-layout>
  
  