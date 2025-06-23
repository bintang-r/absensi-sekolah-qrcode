@props([
    'name' => null,
    'sortable' => null,
    'direction' => null,
    'multiColumn' => null,
])

<div class="cursor-pointer d-flex justify-content-between" {{ $attributes }} style="user-select:none">
    <div>{{ $name }}</div>

    <div id="sort-icon">
        @if ($multiColumn)
            @if ($direction === 'asc')
                <i class="las la-arrow-up"></i>
            @elseif ($direction === 'desc')
                <i class="las la-arrow-down"></i>
            @else
                <i class="las la-arrows-alt-v"></i>
            @endif
        @else
            @if ($direction === 'asc')
                <i class="las la-arrow-up"></i>
            @elseif ($direction === 'desc')
                <i class="las la-arrow-down"></i>
            @else
                <i class="las la-arrows-alt-v"></i>
            @endif
        @endif
    </div>
</div>
