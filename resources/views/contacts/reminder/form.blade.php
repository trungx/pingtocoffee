<form method="POST" action="{{ $action }}">
  @method($method)
  @csrf
  <div class="form-group">
    <label for="title">{{ __('user.reminders_title') }}</label>
  <input type="text" class="form-control" name="title" id="title" value="{{ old('title') ?? $reminder->title }}" placeholder="{{ __('user.reminders_title_placeholder') }}">
  </div>
  <div class="form-group">
    <label for="description">{{ __('user.reminders_desc') }}</label>
  <textarea type="text" class="form-control" name="description" id="description" placeholder="{{ __('user.reminders_desc_placeholder') }}">{{ old('description') ?? $reminder->description }}</textarea>
  </div>
  <div class="form-group">
    <label for="next_expected_date">{{ __('user.reminders_on') }}</label>
    <div class="input-group date" id="next_expected_date" data-target-input="nearest">
      <input type="text" class="form-control datetimepicker-input" name="next_expected_date" data-target="#next_expected_date" value="{{ old('next_expected_date') ?? \App\Helpers\DateHelper::convertToTimezone($reminder->next_expected_date, auth()->user()->timezone)->format('Y/m/d h:i A') }}">
      <div class="input-group-append" data-target="#next_expected_date" data-toggle="datetimepicker">
        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input type="checkbox" name="reminders_frequency" class="form-check-input" id="reminders_frequency" {{ ($reminder->frequency_type && $reminder->frequency_type == 'once') ? '' : 'checked' }}>
      <label class="form-check-label" for="reminders_frequency">{{ __('user.reminders_frequency') }}</label>
      <input type="text" name="frequency_number" min="1" max="255" value="{{ $reminder->frequency_number ?? 1 }}" class="ph1 mh1" style="width:52px; height:24px;">
      <select name="frequency_type" id="frequency_type" style="height: 24px;">
        <option value="day" {{ $reminder->frequency_type == 'day' ? 'selected' : '' }}>{{ __('user.frequency_day') }}</option>
        <option value="week" {{ $reminder->frequency_type == 'week' ? 'selected' : '' }}>{{ __('user.frequency_week') }}</option>
        <option value="month" {{ $reminder->frequency_type == 'month' ? 'selected' : '' }}>{{ __('user.frequency_month') }}</option>
        <option value="year" {{ $reminder->frequency_type == 'year' ? 'selected' : '' }}>{{ __('user.frequency_year') }}</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="pt3">
        <button type="submit" class="btn default-btn fw6">
          @if ($add_or_edit == 'add')
            {{ __('user.reminder_add_cta') }}
          @elseif ($add_or_edit == 'edit')
            {{ __('user.reminder_edit_cta') }}
          @endif
        </button>
        <a href="/{{ $user->username }}?tab=reminders" class="btn btn-link gray-text">{{ __('user.cancel_cta') }}</a>
      </div>
    </div>
  </div>
</form>
@push('scripts')
  <script type="text/javascript">
    $('#next_expected_date').datetimepicker({
      format: 'YYYY/MM/DD hh:mm A',
      icons: {
        date: 'fa fa-calendar-alt',
        time: 'fa fa-clock'
      },
    });
  </script>
@endpush
