<div>
    <x-slot name="title">Wali Kelas</x-slot>

    <x-slot name="pageTitle">Wali Kelas</x-slot>

    <x-slot name="pagePretitle">Kelola Data Wali Kelas</x-slot>

    <x-alert />

    <x-modal.delete-confirmation />

    <div class="row mb-3 align-items-center justify-content-between">
        <div class="col-12 col-lg-8 d-flex align-self-center">
            <div>
                <x-datatable.search placeholder="Cari nama kelas..." />
            </div>
        </div>
        <div class="col-auto ms-auto d-flex mt-lg-0 mt-3">
            <x-datatable.items-per-page />

            <button wire:click="muatUlang" class="btn py-1 ms-2"><span class="las la-redo-alt fs-1"></span></button>
        </div>
    </div>

    <div class="card" wire:loading.class.delay="card-loading" wire:offline.class="card-loading">
        <div class="table-responsive mb-0">
            <table class="table card-table table-bordered datatable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 200px">Kelas</th>

                        <th>Status</th>

                        <th>Wali Kelas</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($this->rows as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            <td class="text-center"><b>{{ $row->name_class ?? '' }}</b></td>

                            <td>
                                <span class="badge bg-{{ $row->class_advisor->teacher->name ? 'lime' : 'red' }}-lt">
                                    {{ $row->class_advisor->teacher->name ? 'sudah ada wali kelas' : 'belum ada wali kelas' }}
                                </span>
                            </td>

                            <td>
                                <x-form.select wire:model="teacherAdvisor.{{ $row->id }}"
                                    name="teacherAdvisor.{{ $row->id }}"
                                    wire:change="saveAdvisor({{ $row->id }})">
                                    <option value="">BELUM ADA</option>
                                    @foreach ($this->teachers as $teacher)
                                        <option value="{{ $teacher->id }}" wire:key="{{ $teacher->id }}">
                                            {{ ucwords(strtolower($teacher->name)) }}
                                        </option>
                                    @endforeach
                                </x-form.select>
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
