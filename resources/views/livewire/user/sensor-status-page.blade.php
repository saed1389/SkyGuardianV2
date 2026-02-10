<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0 text-black">
                            <i class="fas fa-broadcast-tower me-2 text-danger"></i>
                            <span data-key="t-rf-sensor-network">RF Sensor Network</span>
                        </h1>
                        <button wire:click="triggerRemoteScan" wire:loading.attr="disabled" class="btn btn-danger btn-lg shadow-lg">
                            <span wire:loading.remove wire:target="triggerRemoteScan">
                                <i class="fas fa-satellite-dish me-2"></i> <span data-key="t-scan-spectrum" class="text-uppercase">SCAN SPECTRUM</span>
                            </span>
                            <span wire:loading wire:target="triggerRemoteScan">
                                <span class="spinner-border spinner-border-sm me-2"></span> <span data-key="t-scanning">Scanning...</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="row mb-4">
                    @foreach($sensors as $sensor)
                        <div class="col-md-4">
                            <div class="card bg-dark text-white border-secondary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title text-white">{{ $sensor->name }}</h5>
                                        <span class="badge pt-2 {{ $sensor->status == 'ONLINE' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $sensor->status }}
                                    </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span data-key="t-cpu-temp">CPU Temp</span>
                                            <span class="{{ $sensor->temperature > 60 ? 'text-danger' : 'text-success' }}">
                                            {{ $sensor->temperature }}°C
                                        </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span data-key="t-load">Load</span>
                                            <span>{{ $sensor->cpu_load }}%</span>
                                        </div>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $sensor->cpu_load }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-dark border-secondary">
                            <div class="card-header bg-transparent border-secondary d-flex justify-content-between">
                                <h5 class="text-white mb-0" data-key="t-real-time-rf-spectrum-analysis">Real-Time RF Spectrum Analysis</h5>
                                <small class="text-muted" id="last-scan-time">Waiting for data...</small>
                            </div>
                            <div class="card-body">
                                <div id="spectrumChart" style="min-height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success position-fixed bottom-0 end-0 m-3">{!! session('message') !!}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger position-fixed bottom-0 end-0 m-3">{!! session('error') !!}</div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .apexcharts-tooltip {
            background: #000000 !important;
            border: 1px solid #00E396 !important;
            box-shadow: 0 0 15px rgba(0, 227, 150, 0.4) !important;
            border-radius: 4px !important;
            overflow: hidden;
        }

        .apexcharts-tooltip-title {
            background: #121212 !important;
            border-bottom: 1px solid #00E396 !important;
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 13px !important;
            color: #00E396 !important;
            font-weight: bold;
            text-align: center;
        }

        .apexcharts-tooltip-text-y-value,
        .apexcharts-tooltip-text-y-label {
            color: #ffffff !important;
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 14px !important;
        }

        .apexcharts-tooltip-marker {
            background-color: #00E396 !important;
            width: 10px !important;
            height: 10px !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {

            var options = {
                series: [{
                    name: 'Signal Level',
                    data: []
                }],
                chart: {
                    type: 'area',
                    height: 400,
                    background: '#212529',
                    animations: {
                        enabled: true,
                        easing: 'linear',
                        dynamicAnimation: { speed: 1000 }
                    },
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#00E396'],
                stroke: {
                    curve: 'straight',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },

                xaxis: {
                    type: 'numeric',
                    title: {
                        text: 'FREQUENCY (MHz)',
                        style: { color: '#6c757d', fontFamily: 'Courier New' }
                    },
                    labels: { style: { colors: '#adb5bd', fontFamily: 'Courier New' } },
                    tooltip: { enabled: false },
                    tickAmount: 10
                },

                yaxis: {
                    title: {
                        text: 'POWER (dB)',
                        style: { color: '#6c757d', fontFamily: 'Courier New' }
                    },
                    labels: { style: { colors: '#adb5bd', fontFamily: 'Courier New' } },
                    min: -100,
                    max: 0
                },

                grid: {
                    borderColor: '#343a40',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: true } },
                },

                theme: { mode: 'dark' },

                tooltip: {
                    theme: false,
                    followCursor: true,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Courier New, monospace',
                    },
                    onDatasetHover: { highlightDataSeries: true },
                    x: {
                        show: true,
                        formatter: function(val) {
                            return "FREQ: " + val + " MHz";
                        }
                    },
                    y: {
                        formatter: function(val) {
                            return val + " dB";
                        },
                        title: {
                            formatter: (seriesName) => "SIGNAL:"
                        }
                    },
                    marker: { show: true }
                }
            };

            var chart = new ApexCharts(document.querySelector("#spectrumChart"), options);
            chart.render();

            Livewire.on('rf-scan-completed', (event) => {
                var rawData = event[0] || event;

                var data = rawData.series;
                var time = rawData.timestamp;

                console.log("Grafik Güncelleniyor...", data.length + " veri noktası");

                chart.updateSeries([{
                    data: data
                }]);

                var timeLabel = document.getElementById('last-scan-time');
                if(timeLabel) timeLabel.innerText = 'SCAN TIME: ' + time;
            });
        });
    </script>
</div>
