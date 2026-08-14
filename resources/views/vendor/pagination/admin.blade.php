@if ($paginator->hasPages())
  <nav class="pager" role="navigation" aria-label="Pagination Navigation">
    <div class="pager__info">
      {!! __('Showing') !!}
      <strong>{{ $paginator->firstItem() }}</strong>
      {!! __('to') !!}
      <strong>{{ $paginator->lastItem() }}</strong>
      {!! __('of') !!}
      <strong>{{ $paginator->total() }}</strong>
      {!! __('results') !!}
    </div>

    <div class="pager__links">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <span class="pager__btn pager__btn--disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 0 1 0 1.06L9.06 10l3.73 3.71a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" class="pager__btn" rel="prev" aria-label="@lang('pagination.previous')">
          <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 0 1 0 1.06L9.06 10l3.73 3.71a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        </a>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <span class="pager__btn pager__btn--disabled">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <span class="pager__btn pager__btn--active" aria-current="page">{{ $page }}</span>
            @else
              <a href="{{ $url }}" class="pager__btn">{{ $page }}</a>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="pager__btn" rel="next" aria-label="@lang('pagination.next')">
          <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 0-1.06L10.94 10 7.21 6.29a.75.75 0 1 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd"/></svg>
        </a>
      @else
        <span class="pager__btn pager__btn--disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
          <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 0-1.06L10.94 10 7.21 6.29a.75.75 0 1 1 1.06-1.06l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0Z" clip-rule="evenodd"/></svg>
        </span>
      @endif
    </div>
  </nav>
@endif
