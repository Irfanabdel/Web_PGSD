<x-app-layout title="Chart">
    <div class="p-6 sm:ml-64 pt-8">
        <div class="flex items-center justify-center mb-6">
            <!-- Teks -->
            <p class="font-bold tracking-tight text-xl lg:text-4xl text-dark mr-4">
                Hore kamu belajar dengan giat, ini asesmen kamu!
            </p>
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
        @foreach($data as $themeTitle => $items)
        <div class="mb-8 p-4 bg-white rounded-lg shadow-md">
            <!-- Tema -->
            <div class="flex items-center mb-4">
                <p class="text-lg">
                    <span class="font-bold">Tema</span> : <span class="font-normal">{{ $themeTitle }}</span>
                </p>
            </div>
            <!-- Keterangan di atas tabel -->
            <p class="text-sm text-gray-600 mb-2">Keterangan:</p>
            <p class="text-sm text-gray-600 mb-4">BB: Baru Berkembang | MB: Masih Berkembang | BSH: Berkembang Sesuai Harapan | SB: Sangat Berkembang</p>

            <!-- Grafik -->
            @foreach($items as $index => $item)
            <div class="overflow-hidden mb-4">
                <div id="chart-{{ Str::slug($themeTitle, '-') }}-{{ $index }}" class="w-full h-96"></div>
            </div>

            <!-- Inisialisasi grafik dengan data -->
            @once
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            @endonce
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var categories = @json($item['dimensionLabels'] ?? []);
                    var seriesData = @json($item['assessmentData'] ?? []);

                    // Cek jika data tidak kosong
                    if (categories && seriesData) {
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
                                        whiteSpace: 'normal',
                                        wordBreak: 'break-word'
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

                        var chart = new ApexCharts(document.querySelector("#chart-{{ Str::slug($themeTitle, '-') }}-{{ $index }}"), options);
                        chart.render();
                    }
                });
            </script>
            @endforeach
        </div>
        @endforeach
        @else
        <div class="text-lg font-normal text-dark lg:text-xl">
            <p>Tunggu ya, nilai kamu belum ada.</p>
        </div>
        @endif
    </div>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</x-app-layout>