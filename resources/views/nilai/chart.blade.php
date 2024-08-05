<x-app-layout title="welcome">
    <div class="p-4 sm:ml-64">
        <p class="mb-6 font-bold tracking-tigh text-lg  text-dark lg:text-3xl dark:text-gray-400">Selamat telah mengerjakan tugas yang telah diberikan, lihat nilai mu sekarang!</p>
        
        <!-- Tampilkan informasi pengguna -->
        <div class="w-full">

            @foreach($chartData as $data)
            <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
                <p>Nama Sekolah : {{ $data['nama_sekolah'] }}</p>
                <p>Alamat Sekolah : {{ $data['alamat_sekolah'] }}</p>
            </div>
            

        @endforeach

        
           @auth
               
           @endauth
            @if($userData)
            <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
                <p>Nama : {{ $userData['Nama'] }}</p>
                <p>Kelas : {{ $userData['Kelas'] }}</p>
                <p>Fase : A</p>
                <p>Tahun Ajaran : 2023-2024</p>
            </div>
            @endif
            
            <!-- Tampilkan data nilai -->
            @foreach($chartData as $data)
                <div id="chart"></div>
                <div class="text-center ">
                </div>
                @endforeach

                

                @foreach($chartData as $data)
                <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
                   <ul>
                    Projek 1 :
                    <li class="mb-3 text-gray-500 dark:text-gray-400">
                        {{ $data['projek_1'] }} 
                    </li>
                   </ul>
                   <ul>
                    Projek 2 :
                    <li class="mb-3 text-gray-500 dark:text-gray-400">
                        {{ $data['projek_2'] }}
                    </li>
                   </ul>
                </div>
             
            @endforeach

            
        </div>
    </div>

    <!-- Skrip JavaScript untuk membuat grafik dengan ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            chart: {
                type: 'line'
            },
            series: [
                @foreach($chartData as $data)
                    {
                        name: '{{ $data['label'] }}',
                        data: [{{ $data['value1'] }}, {{ $data['value2'] }}, {{ $data['value3'] }}]
                    },
                @endforeach
            ],
            xaxis: {
                categories: {!! json_encode(array_values($labels)) !!}
            }
         

        };

        var chart = new ApexCharts(document.querySelector('#chart'), options);
        chart.render();
    </script>
</x-app-layout>
