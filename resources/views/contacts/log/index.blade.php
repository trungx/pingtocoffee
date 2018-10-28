<div class="p-3 mb3">
  <div class="relative">
    <div class="db mb1">
      <div class="dib light-gray-text">
        <div class="fl f5">{{ __('user.contact_logs_heading') }}</div>
      </div>
      <!-- Add cta -->
      <a href="/contact/{{ $user->id }}/contact-log" class="default-btn b pv1 ph3 absolute top-0 right-0">{{ __('user.contact_logs_add_cta') }}</a>
    </div>
    @if ($contactLogs->count() == 0)
      <!-- Empty state -->
      <div class="tc">
        <div class="f4 mv2">{{ __('user.contact_logs_empty') }}</div>
        <div class="light-gray-text">{{ __('user.contact_logs_whats') }}</div>
      </div>
    @else
      <!-- List contact log -->
      <ul class="pa0 list relative">
        @foreach($contactLogs as $contactLog)
          <li class="mb3 relative pa2 pl3 br1 data-row" style="border: 1px solid #dee2e6;">
            @if($contactLog->notes)
              <div class="mb2 mr4">{{ $contactLog->notes }}</div>
            @else
              <div class="mb2 mr4 gray-text"><i>{{ __('user.no_notes') }}</i></div>
            @endif

            <div class="f7 light-gray-text">
              <span><i class="{{ config('icons.' . $contactLog->contactType->icon) }}"></i></span>
              <span class="middotDivider"></span>
              <span>{{ $contactLog->contact_time->format('F d, Y, h:i A') }}</span>
            </div>

            <div class="more-actions absolute" style="top: 0.5rem; right: 0.5rem;">
              <a class="dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item f7" href="/contact/{{ $user->id }}/contact-log/{{ $contactLog->id }}"><i class="fa fa-edit mr2"></i>{{ __('user.contact_logs_edit_cta') }}</a>
                <a class="dropdown-item f7" href="#" onclick="if(confirm('{{ __('user.contact_logs_delete_confirmation') }}')) { $(this).closest('.data-row').find('.entry-delete-form').submit(); } return false;"><i class="fa fa-trash mr2"></i>{{ __('user.contact_logs_delete_cta') }}</a>
              </div>
            </div>

            <!-- Delete form -->
            <form method="POST" action="/contact/{{ $user->id }}/contact-log/{{ $contactLog->id }}" class="entry-delete-form">
              @method('DELETE')
              @csrf
            </form>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</div>
