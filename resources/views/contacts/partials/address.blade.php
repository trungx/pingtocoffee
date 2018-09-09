<div class="mb2">
  <!-- Title -->
  <div class="light-gray-text">{{ __('user.address_group_title') }}</div>

  @if (isset($contactInformation['address']))
    <!-- Show data -->
    @foreach($contactInformation['address'] as $address)
      <div class="pb2">
        {{ $address->value }} <span class="light-gray-text">({{ $address->defaultLabel->name }})</span>
      </div>
    @endforeach
  @else
    <!-- Empty state -->
    <div class="pb2">
      <i class="fas fa-map-marker-alt mr-2 light-gray-text"></i><span class="light-gray-text">{{ __('user.no-address') }}</span>
    </div>
  @endif
</div>
