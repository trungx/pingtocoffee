<div class="component-header">
  <div class="mb-3">
    <ul class="relative list ma0 pa0 overflow-hidden">
      <li class="fl">
        <a href="/{{ $user->username }}?tab=notes" class="db tc pa3 {{ $activeTab == 'notes' ? 'fw6' : '' }}" style="{{ $activeTab == 'notes' ? 'border-bottom: 2px solid #29a8ab; color: #29a8ab;' : 'color: #8c9396;' }} text-decoration: none;">{{ __('user.notes_tab') }}</a>
      </li>
      <li class="fl">
        <a href="/{{ $user->username }}?tab=reminders" class="db tc pa3 {{ $activeTab == 'reminders' ? 'fw6' : '' }}" style="{{ $activeTab == 'reminders' ? 'border-bottom: 2px solid #29a8ab; color: #29a8ab;' : 'color: #8c9396;' }} text-decoration: none;">{{ __('user.reminders_tab') }}</a>
      </li>
      <li class="fl">
        <a href="/{{ $user->username }}?tab=contact-logs" class="db tc pa3 {{ $activeTab == 'contact-logs' ? 'fw6' : '' }}" style="{{ $activeTab == 'contact-logs' ? 'border-bottom: 2px solid #29a8ab; color: #29a8ab;' : 'color: #8c9396;' }} text-decoration: none;">{{ __('user.contact_logs_tab') }}</a>
      </li>
    </ul>
  </div>
</div>

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
