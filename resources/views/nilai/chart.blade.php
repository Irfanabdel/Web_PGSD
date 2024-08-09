<x-app-layout title="Chart">
    <div class="p-4 sm:ml-64">
        <div class="flex items-center justify-beetween mb-6">
            <!-- Teks -->
            <p class="font-bold tracking-tight text-lg text-dark lg:text-3xl dark:text-gray-400">
                Hore kamu belajar dengan giat, ini nilai kamu !
            </p>

            <!-- Gambar -->
            <img src="{{ asset('happy.png') }}" alt="Deskripsi Gambar" class="w-24 h-24 mr-4 rounded-full">
        </div>

        <!-- Tampilkan informasi pengguna -->
        <div class="w-full bg-white p-4 rounded-lg shadow-md">
            <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
                <p><span class="font-bold">Nama Sekolah:</span> {{ $schoolData['nama_sekolah'] }}</p>
                <p><span class="font-bold">Alamat Sekolah:</span> {{ $schoolData['alamat_sekolah'] }}</p>
            </div>

            @if($userData)
            <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
                <p><span class="font-bold">Nama:</span> {{ $userData['Nama'] }}</p>
                <p><span class="font-bold">Kelas:</span> {{ $userData['Kelas'] }}</p>
                <p><span class="font-bold">Fase:</span> A</p>
                <p><span class="font-bold">Tahun Ajaran:</span> 2023-2024</p>
            </div>
            @endif

            <!-- Tampilkan data nilai dan grafik -->
            <div class="overflow-hidden mt-6 mb-6">
                <div id="chart" class="w-full h-96"></div>
            </div>

            <div class="mb-6 text-lg font-normal text-dark lg:text-xl dark:text-gray-400">
                <ul>
                    <li><span class="font-bold">Projek 1:</span>
                        <p class="mb-3 text-gray-500 dark:text-gray-400">
                            {{ $schoolData['projek_1'] }}
                        </p>
                    </li>
                </ul>
                <ul>
                    <li><span class="font-bold">Projek 2:</span>
                        <p class="mb-3 text-gray-500 dark:text-gray-400">
                            {{ $schoolData['projek_2'] }}
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
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
    @endpush
</x-app-layout>