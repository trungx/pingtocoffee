<div class="relative">
  <div class="db mb1">
    <div class="dib light-gray-text">
      <i class="fas fa-bell mr-2 fl f5"></i>
      <div class="fl ttu f5 b">{{ __('user.notes') }}</div>
    </div>
    <!-- Add cta -->
    <a href="#" data-toggle="modal" data-target="#exampleModal" class="default-btn b pv1 ph3 absolute top-0 right-0">{{ __('user.notes_add_cta') }}</a>
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
          <div class="avatar-container fl mr3">
            @if ($note->owner->has_avatar)
              <img class="br-100" src="{{ $note->owner->getAvatarUrl(\App\Helpers\ImageHelper::MEDIUM_SIZE) }}" alt="Avatar" style="width:42px;">
            @else
              <div class="br-100 default-avatar" style="background-color: {{ $note->owner->default_avatar_color }}; width: 42px; height: 42px; font-size:14px; padding-top:10px;">
                {{ $note->owner->getInitials() }}
              </div>
            @endif
          </div>
          <div class="mb-2">
            <div class="mb-1">{!! $note->note !!}</div>
          </div>
          <div class="dib light-gray-text f7" title="{{ $note->full_datetime }}">
            <i class="fas fa-calendar-alt mr2"></i><span>{{ $note->datetime }}</span>
          </div>
          <div class="dropdown more-actions f6 fr" style="display: inline-block;">
            <a class="dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item f7" href="#"><i class="fa fa-edit mr-2"></i>{{ __('user.edit') }}</a>
              <a class="dropdown-item f7" href="#" onclick="if(confirm('{{ __('user.notes_delete_confirmation') }}')) { $(this).closest('.data-row').find('.entry-delete-form').submit(); } return false;">
                <i class="fa fa-trash mr-2"></i>{{ __('user.delete') }}
              </a>
            </div>
          </div>
          {{--Delete form--}}
          <form method="POST" action="/contact/{{ $user->id }}/note/{{ $note->id }}" class="entry-delete-form">
            @method('DELETE')
            @csrf
          </form>
        </li>
      @endforeach
    </ul>
  @endif

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bb-0">
          <h5 class="modal-title" id="exampleModalLabel">New note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" method="POST">
            <div class="form-group row">
              <label for="note" class="col-sm-2 col-form-label">Note</label>
              <div class="col-sm-10">
                <textarea type="text" class="form-control" id="note" name="note" placeholder="Add a note..."></textarea>
              </div>
            </div>
            <div class="form-group tr">
              <a href="#" class="btn btn-link gray-text" data-dismiss="modal">Cancel</a>
              <button type="button" class="btn default-btn b">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
