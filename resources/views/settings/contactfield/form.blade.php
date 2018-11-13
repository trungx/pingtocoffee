<form method="POST" action="{{ $action }}" id="setting-form">
  @method($method)
  @csrf
  <input type="hidden" name="contact_field_id" value="{{ $contact_field_id }}">
  <div class="form-row">
    <div class="form-group col-md-8 value-box">
      <label for="value">{{ $type }}</label>
      <input type="text" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value" id="value" value="{{ old('value') ?? $field->value }}">
      <span class="invalid-feedback">
        {{ $errors->has('value') ? $errors->first('value') : '' }}
      </span>
    </div>
    <div class="form-group col-md-4 label-box">
      <label for="label_id">{{ __('settings.label') }}</label>
      <select class="form-control{{ $errors->has('label_id') ? ' is-invalid' : '' }}" name="label_id" id="label_id">
        @foreach($labels as $label)
          <option value="{{ $label->id }}" {{ $label->id == $field->label_id ? 'selected' : '' }}>
            {{ $label->name }}
          </option>
        @endforeach
      </select>
      <span class="invalid-feedback">
        {{ $errors->has('label_id') ? $errors->first('label_id') : '' }}
      </span>
    </div>
    <div class="col-12">
      <div class="nice-select-box">
        <div class="light-gray-text mb1">{{ __('settings.privacy_title_lbl') }}</div>
        <select name="privacy_id">
          <option disabled>{{ __('settings.privacy_settings_lbl') }}</option>
          @foreach($privacyCollect as $privacy)
            <option value="{{ $privacy->id }}" {{ $field->privacy_id == $privacy->id ? 'selected' : '' }}>
              {{ __('settings.' . $privacy->name) }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-12">
      <div class="tr">
        <a href="/settings/contactfield" class="btn btn-link gray-text">{{ __('settings.cancel') }}</a>
        <button type="submit" class="btn default-btn fw6">{{ __('settings.save-changes') }}</button>
      </div>
    </div>
  </div>
</form>
