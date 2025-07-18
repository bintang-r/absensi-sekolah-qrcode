@php
    if (!isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet =
        $scrollTo !== false
            ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()"
            : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav class="d-flex justify-items-center justify-content-between mt-3 px-3">
            <div class="d-flex justify-content-between flex-fill d-sm-none">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">@lang('pagination.previous')</span>
                        </li>
                    @else
                        <li class="page-item">
                            <button type="button"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                @if ($scrollIntoViewJsSnippet) x-on:click="{{ $scrollIntoViewJsSnippet }}" @endif
                                wire:loading.attr="disabled">
                                @lang('pagination.previous')
                            </button>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <button type="button"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                @if ($scrollIntoViewJsSnippet) x-on:click="{{ $scrollIntoViewJsSnippet }}" @endif
                                wire:loading.attr="disabled">
                                @lang('pagination.next')
                            </button>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link ms-4" aria-hidden="true">@lang('pagination.next')</span>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    <p class="small text-muted">
                        {!! __('Showing') !!}
                        <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                        {!! __('of') !!}
                        <span class="fw-semibold">{{ $paginator->total() }}</span>
                        {!! __('results') !!}
                    </p>
                </div>

                <div>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                <span class="page-link" aria-hidden="true">&lsaquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button type="button"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                    class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    @if ($scrollIntoViewJsSnippet) x-on:click="{{ $scrollIntoViewJsSnippet }}" @endif
                                    wire:loading.attr="disabled" aria-label="@lang('pagination.previous')">
                                    &lsaquo;
                                </button>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span
                                        class="page-link">{{ $element }}</span></li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item active"
                                            wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}"
                                            aria-current="page"><span style="background-color: #135581; color: #fff;"
                                                class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"
                                            wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">
                                            <button type="button" class="page-link"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                @if ($scrollIntoViewJsSnippet) x-on:click="{{ $scrollIntoViewJsSnippet }}" @endif>
                                                {{ $page }}
                                            </button>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <button type="button"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                    class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    @if ($scrollIntoViewJsSnippet) x-on:click="{{ $scrollIntoViewJsSnippet }}" @endif
                                    wire:loading.attr="disabled" aria-label="@lang('pagination.next')">
                                    &rsaquo;
                                </button>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                <span class="page-link" aria-hidden="true">&rsaquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    @endif
</div>
