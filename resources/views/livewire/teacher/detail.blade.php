@push('styles')
    <style>
        .teacher-info-label {
            font-weight: 500;
            color: #667085;
        }

        .teacher-info-value {
            color: #22223b;
        }

        .teacher-avatar {
            border: 2px solid #f0f0f0;
            background: #fff;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
        }
    </style>
@endpush

<div>
    <x-slot name="title">Detail Guru</x-slot>

    <x-slot name="pagePretitle">Melihat Detail Guru</x-slot>

    <x-slot name="pageTitle">Detail Guru</x-slot>

    <x-slot name="button">
        <x-datatable.button.back name="Kembali" :route="route('teacher.index')" />
    </x-slot>

    <x-alert />

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-body text-center">
                <div class="d-flex justify-content-center">
                    <img src="{{ $teacher->photoUrl() }}" alt="Foto Guru"
                        class="avatar avatar-xl mb-3 rounded-circle teacher-avatar"
                        style="object-fit:cover; width:120px; height:120px;">
                </div>
                <h3 class="mb-1">{{ $teacher->name }}</h3>
                <div class="text-muted mb-1">
                    <i class="las la-id-card"></i> NIP: <span
                        class="teacher-info-value">{{ $teacher->nip ?? '-' }}</span>
                </div>
                <div class="text-muted mb-1">
                    <i class="las la-user"></i> <span
                        class="teacher-info-value">{{ $teacher->sex == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="text-muted mb-1">
                    <i class="las la-phone"></i> <span class="teacher-info-value">{{ $teacher->phone ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-body">
                <h4 class="mb-3"><i class="las la-info-circle"></i> Informasi Lengkap</h4>
                <div class="row mb-2">
                    <div class="col-4 teacher-info-label"><i class="las la-user-tag"></i> NUPTK</div>
                    <div class="col-8 teacher-info-value">{{ $teacher->nuptk ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 teacher-info-label"><i class="las la-praying-hands"></i> Agama</div>
                    <div class="col-8 teacher-info-value">{{ $teacher->religion ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 teacher-info-label"><i class="las la-birthday-cake"></i> Tempat, Tanggal Lahir
                    </div>
                    <div class="col-8 teacher-info-value">
                        {{ $teacher->place_of_birth ?? '-' }}, {{ $teacher->birth_date }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 teacher-info-label"><i class="las la-map-marker"></i> Alamat</div>
                    <div class="col-8 teacher-info-value">{{ $teacher->address ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 teacher-info-label"><i class="las la-mail-bulk"></i> Kode Pos</div>
                    <div class="col-8 teacher-info-value">{{ $teacher->postal_code ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4 teacher-info-label"><i class="las la-calendar-check"></i> Tahun Masuk</div>
                    <div class="col-8 teacher-info-value">{{ $teacher->date_joined ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
