<div>
    <x-alert />

    <div class="row">
        <div class="col-12 col-md-4 col-lg-3">
            <x-card.count-data title="Jadwal Pertemuan" :total="$this->totalSchedule" icon="clock" color="blue" />

            <x-card.count-data title="Hadir" :period="$this->period" :total="$this->totalHadir" icon="address-card" color="green" />

            <x-card.count-data title="Alpa" :period="$this->period" :total="$this->totalAlpa" icon="address-card" color="red" />

            <x-card.count-data title="Izin" :period="$this->period" :total="$this->totalIzin" icon="address-card" color="yellow" />

            <x-card.count-data title="Sakit" :period="$this->period" :total="$this->totalSakit" icon="address-card" color="cyan" />
        </div>

        <div class="col-12 col-md-8 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h3>Filter <span class="las la-filter fs-2 ms-2"></span></h3>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <x-form.select wire:model.lazy="period" name="period" form-group-class>
                                <option value="">SEMUA PERIODE</option>
                                @foreach (config('const.periods') as $period)
                                    <option wire:key="{{ $period }}" value="{{ $period }}">
                                        {{ match ($period) {
                                            'daily' => '10 HARI TERAKHIR',
                                            'weekly' => '10 MINGGU TERAKHIR',
                                            'monthly' => '10 BULAN TERAKHIR',
                                            'yearly' => '10 TAHUN TERAKHIR',
                                            default => '',
                                        } }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>

                        <div class="col-lg-6 col-12">
                            <x-form.select wire:model.lazy="teacherSchedule" name="teacherSchedule" form-group-class>
                                <option value="">SEMUA JADWAL</option>
                                @foreach ($this->class_schedules as $schedule)
                                    <option wire:key="{{ $schedule->id }}" value="{{ $schedule->id }}">
                                        <b>{{ $schedule->class_room->name_class }}</b> {{ $schedule->start_time }} -
                                        {{ $schedule->end_time }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body py-1">
                    <div wire:ignore>
                        <div hadir="{{ json_encode($this->attendanceHadir['data']) }}"
                            alpa="{{ json_encode($this->attendanceAlpa['data']) }}"
                            izin="{{ json_encode($this->attendanceIzin['data']) }}"
                            sakit="{{ json_encode($this->attendanceSakit['data']) }}"
                            date="{{ json_encode($this->attendanceHadir['date']) }}" id="chart-mentions"
                            class="chart-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let chart;
            const item = document.getElementById('chart-mentions');

            function renderChart(hadir, alpa, izin, sakit, date) {
                if (!item) {
                    console.error("ELEMENT ID #chart-mentions TIDAK DITEMUKAN!");
                    return;
                }

                if (chart) {
                    chart.destroy();
                }

                chart = new ApexCharts(item, {
                    chart: {
                        type: "bar",
                        stacked: true,
                        height: 480,
                        parentHeightOffset: 0,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true
                        }
                    },
                    stroke: {
                        show: true,
                        width: 1,
                        colors: ['#fff']
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            dataLabels: {
                                total: {
                                    enabled: true,
                                    style: {
                                        fontSize: '13px',
                                        fontWeight: 900
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    series: [{
                            name: "Hadir",
                            data: hadir
                        },
                        {
                            name: "Alpa",
                            data: alpa
                        },
                        {
                            name: "Izin",
                            data: izin
                        },
                        {
                            name: "Sakit",
                            data: sakit
                        },
                    ],
                    xaxis: {
                        categories: date,
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    colors: ["#4ade80", "#fc9f13", "#3b82f6", "#f43f5e"],
                    legend: {
                        show: true
                    }
                });

                chart.render();
            }

            Livewire.on('updateChartTeacher', (data) => {
                let hadir = data[0].hadir;
                let alpa = data[0].alpa;
                let izin = data[0].izin;
                let sakit = data[0].sakit;
                let date = data[0].date;

                renderChart(hadir, alpa, izin, sakit, date);
            });

            renderChart(
                JSON.parse(item.getAttribute('hadir')),
                JSON.parse(item.getAttribute('alpa')),
                JSON.parse(item.getAttribute('izin')),
                JSON.parse(item.getAttribute('sakit')),
                JSON.parse(item.getAttribute('date'))
            );
        });
    </script>
@endpush
