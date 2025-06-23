<div class="d-print-none">
    <div style="left:0;right:0" class="fixed-top top-0 d-flex justify-content-center mt-4">
        @if (session('queue_alert_warning'))
            <span class="px-3 py-2 border rounded-2 bg-orange-lt shadow" id="loading-indicator">
                <i class="las la-volume-up me-2"></i> Pemanggilan antrian sedang digunakan.
            </span>
        @elseif (session('queue_alert_success'))
            <span class="px-3 py-2 border rounded-2 bg-blue-lt shadow" id="loading-indicator">
                <i class="las la-podcast me-2"></i> Pemanggilan Antrian.
            </span>
        @else
            <span class="px-3 py-2 border rounded-2 bg-orange-lt shadow" id="loading-indicator" wire:loading.delay>
                Memuat<span class="animated-dots"></span>
            </span>

            <span class="px-3 py-2 border rounded-2 bg-red-lt shadow" id="loading-indicator" wire:offline>
                <i class="las la-plane me-2"></i> Anda sedang offline.
            </span>
        @endif
    </div>


    @if (session('alert'))
        <div class="alert alert-{{ $type }} alert-dismissible bg-white" role="alert">
            <div class="d-flex">
                <div class="me-3">
                    <h1 class="text-{{ $type }} las la-{{ $icon }}"></h1>
                </div>

                <div>
                    <h4 class="alert-title">{{ $message }}</h4>
                    <div class="text-muted">{{ $detail }}</div>
                </div>
            </div>

            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif
</div>
