@if ($customInformation->count() == 0)
  <!-- Empty state -->
  <div class="pb2">
    <i class="fas fa-globe mr-2 light-gray-text"></i><span class="light-gray-text">{{ __('user.no-social') }}</span>
  </div>
@else
  @foreach($customInformation as $key => $items)
    <div>
      <div class="light-gray-text">{{ $key }}:</div>
      @foreach($items as $item)
        <div class="pb2"><a href="{{ $item->value }}">{{ $item->value }}</a></div>
      @endforeach
    </div>
  @endforeach
@endif
