<div class="card card-count-data mb-3 flex border border-{{ $color ?? 'orange' }}-lt">
    <div class="card-body">
        <div class="d-flex gap-3">
            <div class="align-self-center">
                <div style="font-size: 45px"
                    class="las la-{{ $icon ?? 'user' }} text-white bg-{{ $color ?? 'orange' }} p-2 rounded-3">
                </div>
            </div>

            <div class="d-flex flex-column">
                <p class="mb-0 text-{{ $color ?? 'orange' }}">{{ $title }}</p>
                <h2 class="my-1 text-{{ $color ?? 'orange' }}">{{ $total }}</h2>

                <div>
                    <span style="padding: 3px"
                        class="bg-{{ $color ?? 'orange' }}-lt fs-5 text-white text-center rounded-2">
                        @if (isset($period))
                            @switch($period)
                                @case('daily')
                                    10 Hari
                                @break

                                @case('weekly')
                                    10 Minggu
                                @break

                                @case('monthly')
                                    10 Bulan
                                @break

                                @case('yearly')
                                    10 Tahun
                                @break

                                @default
                                    Semua
                                @break
                            @endswitch
                        @else
                            Semua
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
