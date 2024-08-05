<x-app-layout title="welcome">
    <div class="p-4 sm:ml-64">
        <p class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">Selamat telah mengerjakan tugas yang telah diberikan, lihat nilai mu sekarang!</p>
        
        @foreach($showData as $data)
        <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
            <p>Nama Sekolah : {{ $user->nama_sekolah }}</p>
            <p>Nama Siswa : {{ $user->nama_siswa }}</p>
            <p>Kelas : {{ $user->kelas }}</p>
            <p>Fase : 1</p>
            <p>Tahun Ajaran : 2023-2024</p>
        </div>
        
    @endforeach
     
      
       
        <div class="w-full">
            <div id="chart"></div>
            <div>
                <h3>Feedback:</h3>
                <ul>
                    @foreach($chartData as $data)
                        <li>{{ $data['label'] }}: {{ $data['feedback1'] }} - {{ $data['feedback2'] }} - {{ $data['feedback3'] }}</li>
                    @endforeach
                </ul>
            </div>

            <p>Projek 1 :</p>
            <p>Projek 2 :</p>
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
