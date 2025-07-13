<div>
    <x-slot name="title">Detail Presensi Kelas</x-slot>

    <x-slot name="pageTitle">Detail Presensi Kelas</x-slot>

    <x-slot name="pagePretitle">Kelola Detail Presensi Kelas</x-slot>

    <x-slot name="button">
        <x-datatable.button.back name="Kembali" :route="route('class-attendance.index')" />
    </x-slot>

    <x-alert />

    <x-modal.delete-confirmation />

    <div class="row mb-3 align-items-center justify-content-between">
        <div class="col-12 col-lg-6 d-flex align-self-center">
            <div>
                <x-datatable.search placeholder="Cari nama materi..." />
            </div>
        </div>
        <div class="col-auto ms-auto d-flex mt-lg-0 mt-3">
            <x-datatable.bulk.dropdown>
                <div class="dropdown-menu dropdown-menu-end datatable-dropdown">
                    <button data-bs-toggle="modal" data-bs-target="#delete-confirmation" class="dropdown-item"
                        type="button">
                        <i class="las la-trash me-3"></i>

                        <span>Hapus</span>
                    </button>
                </div>
            </x-datatable.bulk.dropdown>

            <a href="{{ route('class-attendance.create', $this->classScheduleId) }}" class="btn btn-blue ms-1"><span
                    class="las la-plus me-1"></span> Tambah Presensi
                Pertemuan</a>
        </div>
    </div>

    <div class="card" wire:loading.class.delay="card-loading" wire:offline.class="card-loading">
        <div class="table-responsive mb-0">
            <table class="table card-table table-bordered datatable">
                <thead>
                    <tr>
                        <th class="w-1">
                            <x-datatable.bulk.check wire:model.lazy="selectPage" />
                        </th>

                        <th>Materi</th>

                        <th>Penjelasan Materi</th>

                        <th>Hadir</th>

                        <th>Alpa</th>

                        <th>Izin</th>

                        <th>Sakit</th>

                        <th>Bukti Presensi</th>

                        <th style="width: 10px"></th>
                    </tr>
                </thead>

                <tbody>
                    @if ($selectPage)
                        <tr>
                            <td colspan="10" class="bg-orange-lt rounded-0">
                                @if (!$selectAll)
                                    <div class="text-orange">
                                        <span>Anda telah memilih <strong>{{ $this->rows->total() }}</strong> presensi
                                            kelas,
                                            apakah
                                            Anda mau memilih semua <strong>{{ $this->rows->total() }}</strong>
                                            presensi kelas?</span>

                                        <button wire:click="selectedAll" class="btn btn-sm ms-2">
                                            Pilih Semua Data Presensi Kelas
                                        </button>
                                    </div>
                                @else
                                    <span class="text-pink">Anda sekarang memilih semua
                                        <strong>{{ count($this->selected) }}</strong> presensi kelas.
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endif

                    @forelse ($this->class_attendances as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            <td>
                                <x-datatable.bulk.check wire:model.lazy="selected" value="{{ $row->id }}" />
                            </td>

                            <td>{{ $row->name_material ?? '-' }}</td>

                            <td>{{ $row->explanation_material ?? '-' }}</td>

                            <td>{{ $row->student_attendances->where('status_attendance', 'hadir')->count() ?? 0 }}</td>

                            <td>{{ $row->student_attendances->where('status_attendance', 'alpa')->count() ?? 0 }}</td>

                            <td>{{ $row->student_attendances->where('status_attendance', 'izin')->count() ?? 0 }}</td>

                            <td>{{ $row->student_attendances->where('status_attendance', 'sakit')->count() ?? 0 }}</td>

                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-black"><span
                                        class="las la-camera fs-1"></span></button>
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('class-attendance.edit', [$this->classScheduleId, $row->id]) }}"
                                        class="btn btn-success">
                                        Sunting Presensi <span class="las la-redo-alt ms-1 fs-2"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-datatable.empty colspan="10" />
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $this->class_attendances->links() }}
    </div>

    <div class="row g-2 align-items-center mt-5 mb-3">
        <div class="col">
            <div class="page-pretitle">
                Lihat daftar presensi kehadiran siswa
            </div>
            <h2 class="page-title">
                Detail Kehadiran Siswa
            </h2>
        </div>
    </div>

    <div class="card" wire:loading.class.delay="card-loading" wire:offline.class="card-loading">
        <div class="table-responsive mb-0">
            <table class="table card-table table-bordered datatable">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle">Siswa</th>

                        <th rowspan="2" class="align-middle">NIM</th>

                        <th class="text-center" colspan="{{ $totalPresence }}">
                            Jumlah Pertemuan</th>
                    </tr>

                    <tr>
                        @for ($i = 1; $i <= $totalPresence; $i++)
                            <th class="text-center w-1">Ke-{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @if ($selectPage)
                        <tr>
                            <td colspan="10" class="bg-orange-lt rounded-0">
                                @if (!$selectAll)
                                    <div class="text-orange">
                                        <span>Anda telah memilih <strong>{{ $this->rows->total() }}</strong> presensi
                                            kelas,
                                            apakah
                                            Anda mau memilih semua <strong>{{ $this->rows->total() }}</strong>
                                            presensi kelas?</span>

                                        <button wire:click="selectedAll" class="btn btn-sm ms-2">
                                            Pilih Semua Data Presensi Kelas
                                        </button>
                                    </div>
                                @else
                                    <span class="text-pink">Anda sekarang memilih semua
                                        <strong>{{ count($this->selected) }}</strong> presensi kelas.
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endif

                    @forelse ($this->students as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            <td>{{ $row->full_name ?? '-' }}</td>

                            <td>{{ $row->nis ?? '-' }}</td>

                            @foreach ($row->student_attendances as $attendance)
                                @if ($attendance->class_attendance->class_schedule_id == $this->classScheduleId)
                                    <td class="text-center">
                                        <span style="width: 30px; height: 30px" @class([
                                            'badge fs-5 d-flex justify-content-center align-items-center rounded-md text-white',
                                            'bg-green' => $attendance->status_attendance === 'hadir',
                                            'bg-red' => $attendance->status_attendance === 'alpa',
                                            'bg-yellow' => $attendance->status_attendance === 'izin',
                                            'bg-cyan' => $attendance->status_attendance === 'sakit',
                                        ])>
                                            {{ match ($attendance->status_attendance) {
                                                'hadir' => 'H',
                                                'alpa' => 'A',
                                                'izin' => 'I',
                                                'sakit' => 'S',
                                                default => '',
                                            } }}
                                        </span>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <x-datatable.empty colspan="10" />
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $this->class_attendances->links() }}
    </div>
</div>
