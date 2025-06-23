<div style="z-index: 99999" class="{{ $show ? 'd-show' : 'd-none' }}">
    <div class="modal-backdrop fade show"></div>

    <div class="modal show" style="display: block;">
        <div class="modal-dialog modal-{{ isset($size) ? $size : 'sm' }} modal-dialog-centered" role="document">
            <div class="modal-content">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
