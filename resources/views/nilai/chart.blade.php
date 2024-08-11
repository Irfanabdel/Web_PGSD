<x-app-layout title="Chart">
    <div class="p-4 sm:ml-64">
        <div class="flex items-center justify-between mb-6">
            <!-- Teks -->
            <p class="font-bold tracking-tight text-lg text-dark lg:text-3xl">
                Hore kamu belajar dengan giat, ini nilai kamu!
            </p>

            <!-- Gambar -->
            <img src="{{ asset('/image/happy.png') }}" alt="Deskripsi Gambar" class="w-24 h-24 mr-4 rounded-full">
        </div>

        <!-- Tampilkan informasi pengguna -->
        <div class="w-full bg-white p-4 rounded-lg shadow-md">
            @if($userData)
            <div class="mb-6 text-lg font-normal text-dark lg:text-xl">
                <p><span class="font-bold">Nama:</span> {{ $userData['Nama'] }}</p>
                <p><span class="font-bold">Kelas:</span> {{ $userData['Kelas'] }}</p>
                <p><span class="font-bold">Fase:</span> A</p>
                <p><span class="font-bold">Tahun Ajaran:</span> 2023-2024</p>
            </div>
            @endif

            <!-- Tampilkan data nilai dan grafik -->
            @if(!empty($nilaiSeries) && !empty($mapelLabels))
            <div class="overflow-hidden mt-6 mb-6">
                <div id="chart" class="w-full h-96"></div>
            </div>
            @else
            <div class="text-lg font-normal text-dark lg:text-xl">
                <p>Tunggu ya, nilai kamu belum ada.</p>
            </div>
            @endif

            <div class="mb-6 text-lg font-normal text-dark lg:text-xl">
                <ul>
                    <li><span class="font-bold">Projek 1:</span>
                        <p class="mb-3 text-gray-500">
                            {{ $schoolData['projek_1'] }}
                        </p>
                    </li>
                </ul>
                <ul>
                    <li><span class="font-bold">Projek 2:</span>
                        <p class="mb-3 text-gray-500">
                            {{ $schoolData['projek_2'] }}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    @push('scripts')
    @if(!empty($nilaiSeries) && !empty($mapelLabels))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                chart: {
                    type: 'line',
                    height: '100%',
                    zoom: {
                        enabled: true
                    }
                },
                series: [{
                    name: 'Nilai',
                    data: @json($nilaiSeries)
                }],
                xaxis: {
                    categories: @json($mapelLabels),
                    title: {
                        text: 'Mata Pelajaran',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#000'
                        }
                    },
                    tickAmount: 10, // Jumlah ticks pada x-axis
                    labels: {
                        rotate: -45 // Memutar label x-axis jika perlu
                    }
                },
                yaxis: {
                    title: {
                        text: 'Nilai',
                        style: {
                            fontSize: '14px',
                            fontWeight: 'bold',
                            color: '#000'
                        }
                    },
                    min: 0,
                    max: 10,
                    tickAmount: 5 // Jumlah ticks pada y-axis
                },
                colors: ['#FF1654'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return `Nilai: ${val}`;
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        colors: ['#000']
                    }
                },
                stroke: {
                    curve: 'smooth', // Mengatur kurva garis untuk membuatnya halus
                    width: 2 // Menentukan ketebalan garis
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
    @endif
    @endpush
</x-app-layout>
