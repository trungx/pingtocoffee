<div class="mb2">
  <!-- Title -->
  <div class="light-gray-text">{{ __('user.email_group_title') }}</div>

  @if (isset($contactInformation['email']))
    @foreach($contactInformation['email'] as $email)
      <div class="pb2">
        <a href="mailto:{{ $email->value }}">{{ $email->value }}</a> <span class="light-gray-text">({{ $email->defaultLabel->name }})</span>
      </div>
    @endforeach
  @else
    <!-- Empty state -->
    <div class="pb2">
      <i class="fas fa-envelope mr-2 light-gray-text"></i><span class="light-gray-text">{{ __('user.no-email') }}</span>
    </div>
  @endif
</div>
