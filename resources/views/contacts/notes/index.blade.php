<div class="p-3 mb3">
  <div class="relative">
    <div class="db mb1">
      <div class="dib light-gray-text">
        <div class="fl f5">{{ __('user.notes') }}</div>
      </div>
      <!-- Add cta -->
      <a href="javascript:void(0);" data-toggle="modal" data-target="#noteModal" class="default-btn fw6 pv1 ph3 absolute top-0 right-0">{{ __('user.notes_add_cta') }}</a>
    </div>

    @if ($notes->count() == 0)
      <!-- Empty state -->
      <div class="tc">
        <div class="f4 mv2">{{ __('user.notes_empty') }}</div>
        <div class="light-gray-text">{{ __('user.notes_empty_whats') }}</div>
      </div>
    @else
      <ul class="pa0 relative list">
        @foreach($notes as $note)
          <li class="mb3 relative pa2 pl3 data-row">
            <div class="avatar-container fl mr2 mb2" title="{{ $user->getCompleteName() }}">
              @if ($note->owner->has_avatar)
                <img class="br-100" src="{{ $note->owner->getAvatarUrl(\App\Helpers\ImageHelper::MEDIUM_SIZE) }}" style="width: 42px;">
              @else
                <div class="default-avatar br-100" style="background-color: {{ $note->owner->default_avatar_color }}; width: 42px; height: 42px; line-height: 42px;">
                  {{ $note->owner->getInitials() }}
                </div>
              @endif
            </div>

            <div class="ml5">
              <div class="mb-2">
                <div class="mb-1">{!! nl2br($note->note) !!}</div>
              </div>
              <div class="dib light-gray-text f7" title="{{ $note->full_datetime }}">
                <i class="fas fa-calendar-alt mr2"></i><span>{{ $note->datetime }}</span>
              </div>
              <div class="dropdown more-actions f6 fr" style="display: inline-block;">
                <a class="dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-ellipsis-h"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item f7" href="javascript:void(0);" onclick="if(confirm('{{ __('user.notes_delete_confirmation') }}')) { $(this).closest('.data-row').find('.entry-delete-form').submit(); } return false;">
                    <i class="fa fa-trash-alt mr-2"></i>{{ __('user.delete') }}
                  </a>
                </div>
              </div>
            </div>

            <!--Delete form-->
            <form method="POST" action="/contact/{{ $user->id }}/note/{{ $note->id }}" class="entry-delete-form">
              @method('DELETE')
              @csrf
            </form>
          </li>
        @endforeach
      </ul>
    @endif

    <!-- Add note form -->
    @include('contacts.notes.add')
  </div>
</div>
