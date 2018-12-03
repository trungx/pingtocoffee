<form method="POST" action="{{ $action }}">
  @method($method)
  @csrf
  <fieldset class="form-group ph0">
    <label for="theyowe" class="form-check-inline">
      <input type="radio" name="in_debt" id="theyowe" value="0" @if(! $debt->in_debt) checked="checked" @endif class="form-check-input">{{ __('user.in_debt_they_owe', ['name' => $user->getCompleteName()]) }}
    </label>
    <label for="youowe" class="form-check-inline">
      <input type="radio" name="in_debt" id="youowe" value="1" @if($debt->in_debt) checked="checked" @endif class="form-check-input">{{ __('user.in_debt_you_owe', ['name' => $user->getCompleteName()]) }}
    </label>
  </fieldset>
  <div class="form-group">
    <label for="amount">{{ __('user.debt_amount', ['currency' => auth()->user()->currency]) }}</label>
    <input type="text" name="amount" id="amount" value="{{ old('amount') ?? $debt->amount }}" class="form-control">
    <small class="f7">{{ __('user.change_currency_suggestion') }} <a href="/settings">{{ __('user.account_setting_link') }}</a></small>
  </div>
  <div class="form-group">
    <label for="reason">{{ __('user.debt_reason') }}</label>
    <textarea name="reason" id="reason" rows="3" class="form-control">{{ old('reason') ?? $debt->reason }}</textarea>
  </div>
  <div class="form-group actions">
    <button type="submit" class="btn default-btn fw6">
      @if ($add_or_edit == 'add')
        {{ __('user.debt_add_cta') }}
      @elseif ($add_or_edit == 'edit')
        {{ __('user.debt_edit_cta') }}
      @endif
    </button>
    <a href="/{{ $user->username }}?tab=debts" class="btn btn-link gray-text">{{ __('user.cancel_cta') }}</a>
  </div>
</form>
