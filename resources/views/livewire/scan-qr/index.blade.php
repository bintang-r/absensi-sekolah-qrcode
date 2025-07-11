@push('styles')
    <style>
        #reader #reader__scan_region {
            transform: scaleX(-1)
        }
    </style>
@endpush

<div>
    <x-slot name="title">Scan Presensi Siswa</x-slot>

    <x-slot name="pageTitle">Scan Presensi Siswa</x-slot>

    <x-slot name="pagePretitle">Kelola Data Presensi Siswa</x-slot>

    <div class="row">
        <div class="col-lg-5 col-12">
            <div class="card">
                <div class="card-header">
                    Scan Presensi Disini
                    <span class="las la-camera ms-2 fs-2"></span>
                </div>

                <div class="card-body">

                    <x-form.select wire:model.lazy="presensiType" name="presensiType" label="Pilih Jenis Presensi"
                        required autofocus>
                        <option value="check-in">PRESENSI DATANG</option>
                        <option value="check-out">PRESENSI PULANG</option>
                    </x-form.select>

                    <div wire:ignore id="reader"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-12">
            @if ($this->presensiType == 'check-in')
                <livewire:scan-qr.check-in-record />
            @elseif($this->presensiType == 'check-out')
                <livewire:scan-qr.check-out-record />
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        document.addEventListener('livewire:init', () => {
            function onScanSuccess(decodedText, decodedResult) {
                Livewire.dispatch('scanned', {
                    code: decodedText
                });
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
@endpush
