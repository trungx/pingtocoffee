<form method="POST" action="{{ $action }}">
  @method($method)
  @csrf
  <div class="form-group">
    <label for="contact_type">{{ __('user.contact_logs_title') }}</label>
    <select class="form-control" id="contact_type" name="contact_type">
      @foreach($contactTypes as $contactType)
        <option value="{{ $contactType->id }}" {{ $contactType->id == $contactLog->contact_type ? 'selected' : '' }}>{{ __('user.contact_type_' . $contactType->name) }}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="contact_time">{{ __('user.contact_logs_contact_time_lbl') }}</label>
    <div class="input-group date" id="contact_time" data-target-input="nearest">
      <input type="text" class="form-control datetimepicker-input" name="contact_time" data-target="#contact_time" value="{{ old('contact_time') ?? \App\Helpers\DateHelper::convertToTimezone($contactLog->contact_time, auth()->user()->timezone)->format('Y/m/d h:i A') }}">
      <div class="input-group-append" data-target="#contact_time" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="notes">{{ __('user.contact_logs_notes_lbl') }}</label>
    <textarea type="text" class="form-control" name="notes" id="notes" placeholder="{{ __('user.notes_placeholder') }}">{{ old('notes') ?? $contactLog->notes }}</textarea>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="pt3">
        <button type="submit" class="btn default-btn b">
          @if ($add_or_edit == 'add')
            {{ __('user.contact_logs_add_cta') }}
          @elseif ($add_or_edit == 'edit')
            {{ __('user.contact_logs_save') }}
          @endif
        </button>
        <a href="/contact/{{ $user->id }}?tab=contact-logs" class="btn btn-link gray-text">{{ __('user.contact_logs_cancel_cta') }}</a>
      </div>
    </div>
  </div>
</form>
@push('scripts')
  <script type="text/javascript">
    $('#contact_time').datetimepicker({
      format: 'YYYY/MM/DD hh:mm A',
      icons: {
        date: 'fa fa-calendar-alt',
        time: 'fa fa-clock'
      },
    });
  </script>
@endpush
