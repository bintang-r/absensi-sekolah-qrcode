<div>
    <x-slot name="title">Tambah Jadwal kelas</x-slot>

    <x-slot name="pagePretitle">Menambah Jadwal Kelas</x-slot>

    <x-slot name="pageTitle">Tambah Jadwal Kelas</x-slot>

    <x-slot name="button">
        <x-datatable.button.back name="Kembali" :route="route('master.class-schedule.index')" />
    </x-slot>

    <x-alert />

    <form class="card" wire:submit.prevent="save" autocomplete="off">
        <div class="card-header">
            Tambah jadwal kelas
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <x-form.select wire:model="kelas" name="kelas" label="Kelas">
                        <option value="">- pilih kelas -</option>
                        @foreach ($this->class_rooms as $class_room)
                            <option wire:key="{{ $class_room->id }}" value="{{ $class_room->id }}">
                                {{ strtoupper($class_room->name_class) }}</option>
                        @endforeach
                    </x-form.select>

                    <x-form.select wire:model="mataPelajaran" name="mataPelajaran" label="Mata Pelajaran">
                        <option value="">- pilih mata pelajaran -</option>
                        @foreach ($this->subject_studies as $subject_study)
                            <option wire:key="{{ $subject_study->id }}" value="{{ $subject_study->id }}">
                                {{ strtoupper($subject_study->name_subject) }}</option>
                        @endforeach
                    </x-form.select>

                    <x-form.select wire:model="guru" name="guru" label="Guru">
                        <option value="">- pilih guru -</option>
                        @foreach ($this->teachers as $teacher)
                            <option wire:key="{{ $teacher->id }}" value="{{ $teacher->id }}">{{ $teacher->name }} -
                                {{ $teacher->nip }}
                            </option>
                        @endforeach
                    </x-form.select>

                    <x-form.select wire:model="hari" name="hari" label="Nama Hari">
                        <option value="">- pilih hari -</option>
                        @foreach (config('const.name_days') as $name_day)
                            <option wire:key="{{ $name_day }}" value="{{ $name_day }}">
                                {{ strtoupper($name_day) }}</option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <x-form.input wire:model="waktuMasuk" name="waktuMasuk" label="Waktu Masuk / Mulai"
                                type="time" />
                        </div>

                        <div class="col-lg-6 col-12">
                            <x-form.input wire:model="waktuKeluar" name="waktuKeluar" label="Waktu Keluar / Selesai"
                                type="time" />
                        </div>
                    </div>

                    <x-form.textarea wire:model="keterangan" name="keterangan" label="Keterangan" style="height: 210px;"
                        placeholder="Masukkan keterangan seperti informasi / terkait materi dll..." />
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="btn-list justify-content-end">
                <button type="reset" class="btn">Reset</button>

                <x-datatable.button.save target="save" />
            </div>
        </div>
    </form>
</div>
