<!-- Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bb-0">
        <h5 class="modal-title">{{ __('user.new_note') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/contact/{{ $user->id }}/note" method="POST">
          @csrf
          <div class="form-group">
            <textarea type="text" class="form-control" id="note" name="note" placeholder="{{ __('user.add_note_placeholder') }}"></textarea>
          </div>
          <div class="form-group tr">
            <a href="#" class="btn btn-link gray-text" data-dismiss="modal">{{ __('user.notes_cancel_cta') }}</a>
            <button type="submit" class="btn default-btn b">{{ __('user.notes_add_cta') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
