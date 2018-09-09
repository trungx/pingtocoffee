<div class="col-12 col-md-3">
  <div class="list-group mb-3" style="box-shadow: rgb(204, 204, 204) 0px 1px 1px;">
    <div class="list-group-item fw6 bn light-gray-text" style="background: #f3f5f8;">
      {{ __('settings.sidebar_title') }}
    </div>
    <a href="/settings" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == 'settings.show') active @endif">
      <i class="fas fa-user-circle mr-2"></i>
      <span>{{ __('settings.sidebar_information') }}</span>
    </a>
    <a href="/settings/contactfield" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == 'settings.contact-field.index' || Route::currentRouteName() == 'settings.contact-field.create' || Route::currentRouteName() == 'settings.contact-field.edit') active @endif">
      <i class="fas fa-address-book mr-2"></i>
      <span>{{ __('settings.sidebar_contact') }}</span>
    </a>
    <a href="/settings/security" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == 'settings.security.show') active @endif">
      <i class="fas fa-user-lock mr-2"></i>
      <span>{{ __('settings.sidebar_security') }}</span>
    </a>
    <a href="/referrals" class="list-group-item list-group-item-action bn @if (Route::currentRouteName() == '.referrals.showReferralsForm') active @endif">
      <i class="fas fa-chart-line mr-2"></i>
      <span>{{ __('settings.sidebar_referrals') }}</span>
    </a>
  </div>
</div>
