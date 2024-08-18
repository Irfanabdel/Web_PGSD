<x-app-layout title="Chart">
    <div class="p-4 sm:ml-64">
        <div class="flex items-center justify-center mb-6">
            <!-- Teks -->
            <p class="font-bold tracking-tight text-lg text-dark lg:text-3xl mr-4">
                Hore kamu belajar dengan giat, ini nilai kamu!
            </p>

            <!-- Gambar -->
            <img src="{{ asset('/image/happy.png') }}" alt="Deskripsi Gambar" class="w-24 h-24 rounded-full">
        </div>

        <!-- Tampilkan informasi pengguna -->
        <div class="w-full bg-white p-4 rounded-lg shadow-md mb-8">
            @if($userData)
            <div class="mb-6 text-lg font-normal text-dark lg:text-xl space-y-2">
                <p class="flex items-center">
                    <span class="font-bold w-40">Nama</span>: {{ $userData['Nama'] }}
                </p>
                <p class="flex items-center">
                    <span class="font-bold w-40">Nama Sekolah</span>: {{ $userData['school_name'] }}
                </p>
                <p class="flex items-center">
                    <span class="font-bold w-40">Kelas</span>: {{ $userData['Kelas'] }}
                </p>
                <p class="flex items-center">
                    <span class="font-bold w-40">Fase</span>: A
                </p>
                <p class="flex items-center">
                    <span class="font-bold w-40">Tahun Ajaran</span>: 2023-2024
                </p>
            </div>
            @endif
        </div>

        <!-- Tampilkan tema, grafik, dan proyek -->
        @if($data)
        @foreach($data as $item)
        <div class="mb-8 p-4 bg-white rounded-lg shadow-md">
            <!-- Keterangan di atas tabel -->
            <p class="text-sm text-gray-600 mb-2">Keterangan:</p>
            <p class="text-sm text-gray-600 mb-4">BB: Baru Berkembang | MB: Masih Berkembang | BSH: Berkembang Sesuai Harapan | SB: Sangat Berkembang</p>
            <!-- Tema -->
            <div class="flex items-center mb-4">
                <p class="text-lg">
                    <span class="font-bold">Tema</span> : <span class="font-normal">{{ $item['themeTitle'] }}</span>
                </p>
            </div>

            <!-- Grafik -->
            <div class="overflow-hidden mb-4">
                <div id="chart-{{ $loop->index }}" class="w-full h-96"></div>
            </div>

            <!-- Proyek -->
            <div class="mb-4 text-lg font-normal text-dark lg:text-xl">
                <p>
                    <span class="font-bold">Projek 1</span> : <span class="font-normal">{{ $item['project1'] }}</span>
                </p>
                <p>
                    <span class="font-bold">Projek 2</span> : <span class="font-normal">{{ $item['project2'] }}</span>
                </p>
            </div>

            <!-- Inisialisasi grafik dengan data -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var categories = @json($item['dimensionLabels']);
                    var seriesData = @json($item['assessmentData']);

                    var categoryMapping = {
                        'BB': 1,
                        'MB': 2,
                        'BSH': 3,
                        'SB': 4,
                        'Unknown': 0
                    };

                    var numericSeriesData = seriesData.map(function(value) {
                        return categoryMapping[value] || 0;
                    });

                    var options = {
                        chart: {
                            type: 'line',
                            height: '100%',
                            zoom: {
                                enabled: true
                            }
                        },
                        series: [{
                            name: 'Asesmen',
                            data: numericSeriesData
                        }],
                        xaxis: {
                            categories: categories,
                            title: {
                                text: 'Dimensi',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#000'
                                }
                            },
                            tickAmount: categories.length > 10 ? 10 : categories.length,
                            labels: {
                                rotate: -45,
                                style: {
                                    whiteSpace: 'normal', /* Allows text to wrap */
                                    wordBreak: 'break-word' /* Ensures long words break and wrap */
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Asesmen',
                                style: {
                                    fontSize: '14px',
                                    fontWeight: 'bold',
                                    color: '#000'
                                }
                            },
                            min: 0,
                            max: 4,
                            tickAmount: 4,
                            labels: {
                                formatter: function(val) {
                                    var labelMapping = {
                                        1: 'BB',
                                        2: 'MB',
                                        3: 'BSH',
                                        4: 'SB',
                                        0: 'Unknown'
                                    };
                                    return labelMapping[val] || 'Unknown';
                                }
                            }
                        },
                        colors: ['#FF1654'],
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    var labelMapping = {
                                        1: 'BB',
                                        2: 'MB',
                                        3: 'BSH',
                                        4: 'SB',
                                        0: 'Unknown'
                                    };
                                    return `${labelMapping[val] || 'Unknown'}`;
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                var labelMapping = {
                                    1: 'BB',
                                    2: 'MB',
                                    3: 'BSH',
                                    4: 'SB',
                                    0: 'Unknown'
                                };
                                return labelMapping[val] || 'Unknown';
                            },
                            style: {
                                fontSize: '12px',
                                colors: ['#000']
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart-{{ $loop->index }}"), options);
                    chart.render();
                });
            </script>
        </div>
        @endforeach
        @else
        <div class="text-lg font-normal text-dark lg:text-xl">
            <p>Tunggu ya, nilai kamu belum ada.</p>
        </div>
        @endif
    </div>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</x-app-layout>
