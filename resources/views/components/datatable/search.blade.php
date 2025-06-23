<div class="input-icon">
    <span class="input-icon-addon">
        <i class="las la-search"></i>
    </span>

    <input wire:model.live="filters.search" type="search" class="form-control"
        placeholder="{{ $placeholder ?? 'Cari...' }}" autofocus>
</div>
