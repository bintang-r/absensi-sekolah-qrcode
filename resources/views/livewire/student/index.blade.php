<div>
    <x-slot name="title">Siswa</x-slot>

    <x-slot name="pageTitle">Siswa</x-slot>

    <x-slot name="pagePretitle">Kelola Data Siswa</x-slot>

    <x-slot name="button">
        <x-datatable.button.add name="Tambah Siswa" :route="route('student.create')" />
    </x-slot>

    <x-alert />

    <x-modal.delete-confirmation />

    <div class="row mb-3 align-items-center justify-content-between">
        <div class="col-12 col-lg-8 d-flex align-self-center">
            <div>
                <x-datatable.search placeholder="Cari nama siswa..." />
            </div>
        </div>
        <div class="col-auto ms-auto d-flex mt-lg-0 mt-3">
            <x-datatable.items-per-page />

            <x-datatable.bulk.dropdown>
                <div class="dropdown-menu dropdown-menu-end datatable-dropdown">
                    <button data-bs-toggle="modal" data-bs-target="#delete-confirmation" class="dropdown-item"
                        type="button">
                        <i class="las la-trash me-3"></i>

                        <span>Hapus</span>
                    </button>
                </div>
            </x-datatable.bulk.dropdown>

            <button wire:click="muatUlang" class="btn py-1 ms-2"><span class="las la-redo-alt fs-1"></span></button>
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

                        <th>
                            <x-datatable.column-sort name="Siswa" wire:click="sortBy('full_name')"
                                :direction="$sorts['full_name'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="NIS" wire:click="sortBy('nis')" :direction="$sorts['nis'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Jenis Kelamin" wire:click="sortBy('sex')"
                                :direction="$sorts['sex'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Nomor Ponsel" wire:click="sortBy('phone')"
                                :direction="$sorts['phone'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Agama" wire:click="sortBy('religion')" :direction="$sorts['religion'] ?? null" />
                        </th>

                        <th>
                            <x-datatable.column-sort name="Alamat" wire:click="sortBy('address')" :direction="$sorts['address'] ?? null" />
                        </th>

                        <th>Kelas</th>

                        <th style="width: 10px"></th>
                    </tr>
                </thead>

                <tbody>
                    @if ($selectPage)
                        <tr>
                            <td colspan="10" class="bg-orange-lt rounded-0">
                                @if (!$selectAll)
                                    <div class="text-orange">
                                        <span>Anda telah memilih <strong>{{ $this->rows->total() }}</strong> siswa,
                                            apakah
                                            Anda mau memilih semua <strong>{{ $this->rows->total() }}</strong>
                                            siswa?</span>

                                        <button wire:click="selectedAll" class="btn btn-sm ms-2">
                                            Pilih Semua Data Siswa
                                        </button>
                                    </div>
                                @else
                                    <span class="text-pink">Anda sekarang memilih semua
                                        <strong>{{ count($this->selected) }}</strong> siswa.
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endif

                    @forelse ($this->rows as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            <td>
                                <x-datatable.bulk.check wire:model.lazy="selected" value="{{ $row->id }}" />
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm px-3 me-3"
                                        style="background-image: url({{ $row->photoUrl() ?? $row->user->avatarUrl() }})"></span>

                                    @if (is_online($row->id))
                                        <span class="badge bg-success me-1"></span>
                                    @else
                                        <span class="badge bg-secondary me-1" title="{{ $row->last_seen_time }}"></span>
                                    @endif

                                    <span>{{ $row->full_name }}</span>
                                </div>
                            </td>

                            <td><b>{{ $row->nis ?? '-' }}</b></td>

                            <td>{{ $row->sex ?? '-' }}</td>

                            <td>{{ $row->phone ?? '-' }}</td>

                            <td>{{ $row->religion ?? '-' }}</td>

                            <td>{{ $row->address ?? '-' }}, {{ $row->postal_code ?? '' }}</td>

                            <td class="text-center"><b>{{ $row->class_room->name_class ?? '-' }}</b></td>

                            <td>
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <a class="btn btn-sm" href="{{ route('student.edit', $row->id) }}">
                                            Sunting
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-datatable.empty colspan="10" />
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $this->rows->links() }}
    </div>
</div>
