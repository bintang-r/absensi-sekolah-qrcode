<div class="card">
    <div class="card-header">{{ $header }}</div>

    <div class="card-body" style="max-height:350px;overflow-y:auto">
        {{ $slot }}
    </div>

    <div class="card-footer">
        <button class="btn btn-sm" wire:click="$set('showDetail', false)">Tutup</button>
    </div>
</div>
