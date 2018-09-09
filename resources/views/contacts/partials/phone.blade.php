<div class="mb2">
  <!-- Title -->
  <div class="light-gray-text">{{ __('user.phone_group_title') }}</div>

  @if (isset($contactInformation['phone']))
    @foreach($contactInformation['phone'] as $phone)
      <div class="pb2">
        <a href="tel:{{ $phone->value }}">{{ $phone->value }}</a> <span class="light-gray-text">({{ $phone->defaultLabel->name }})</span>
      </div>
    @endforeach
  @else
    <!-- Empty state -->
    <div class="pb2">
      <i class="fas fa-phone mr-2 light-gray-text"></i><span class="light-gray-text">{{ __('user.no-phone') }}</span>
    </div>
  @endif
</div>
