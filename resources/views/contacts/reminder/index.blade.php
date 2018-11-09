<div class="p-3 mb3">
  <div class="relative">
    <div class="db mb1">
      <div class="dib light-gray-text">
        <div class="fl f5">{{ __('user.reminders') }}</div>
      </div>
      <!-- Add cta -->
      <a href="/contact/{{ $user->id }}/reminder" class="default-btn fw6 pv1 ph3 absolute top-0 right-0">{{ __('user.reminder_add_cta') }}</a>
    </div>

    @if ($reminders->count() == 0)
      <!-- Empty state -->
      <div class="tc">
        <div class="f4 mv2">{{ __('user.reminder_empty') }}</div>
        <div class="light-gray-text">{{ __('user.reminder_whats') }}</div>
      </div>
    @else
      <ul class="pa0 relative list">
        @foreach($reminders as $reminder)
          <li class="mb3 relative pa2 pl3 br1 data-row" style="border: 1px solid #dee2e6;">
            <div class="mb-1 ttu gray-text" title="{{ __('user.next_date_explain') }}">{{ $reminder->next_expected_date->format('M d, Y') }}</div>

            <div class="mb-2">
              <div class="mb-1">{{ $reminder->title }}</div>
              <div class="mb-1 f7 gray-text">{{ $reminder->description }}</div>
            </div>

            <div class="dib f7 light-gray-text">
              <span title="{{ __('user.next_time_explain') }}">{{ $reminder->next_expected_date->format('h:i A') }}</span>
              <span class="middotDivider"></span>
              <span title="{{ __('user.frequency_explain') }}">{{ $reminder->frequency_type }}</span>
            </div>

            <div class="dropdown more-actions fr" style="display: inline;">
              <a class="dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item f7" href="/contact/{{ $user->id }}/reminder/{{ $reminder->id }}">
                  <i class="fa fa-edit mr2"></i>{{ __('user.edit') }}
                </a>
                <a class="dropdown-item f7" href="#" onclick="if(confirm('{{ __('user.reminder_delete_confirmation') }}')) { $(this).closest('.data-row').find('.entry-delete-form').submit(); } return false;">
                  <i class="fa fa-trash mr2"></i>{{ __('user.delete') }}
                </a>
              </div>
            </div>
            {{--Delete form--}}
            <form method="POST" action="/contact/{{ $user->id }}/reminder/{{ $reminder->id }}" class="entry-delete-form">
              @method('DELETE')
              @csrf
            </form>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</div>
