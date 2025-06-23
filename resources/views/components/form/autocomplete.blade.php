<div>
    <div class="position-absolute dropdown-menu dropdown-menu-demo" style="max-height:150px;overflow-y:auto">
        <div class="dropdown-header">
            <span>{{ $header }}</span>
        </div>

        {{ $slot }}
    </div>

    <button wire:click="hideAutocomplete" type="button" class="btn btn-sm position-absolute mt-2 me-2 float-end"
        style="z-index:1000;right:0">
        <i class="las la-times"></i>
    </button>
</div>
