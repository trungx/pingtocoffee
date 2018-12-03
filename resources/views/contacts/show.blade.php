@extends('layouts.skeleton')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="p-4">
            <div class="sidebar-profile" style="border-bottom: 1px dashed #d9d9d9;">
              <div class="header mv3">
                <div class="avatar-container tc mb-2">
                  @if ($user->has_avatar)
                    <img class="br-100" src="{{ $user->getAvatarUrl(\App\Helpers\ImageHelper::MEDIUM_SIZE) }}" style="width: 87px;">
                  @else
                    <div class="default-avatar br-100" style="background-color: {{ $user->default_avatar_color }}; width: 87px; height: 87px; font-size: 25px; line-height: 87px;">
                      {{ $user->getInitials() }}
                    </div>
                  @endif
                </div>
                <div class="people-name tc f4 fw6">{{ $user->getCompleteName() }}</div>
                <div class="f6 tc mb-2 gray-text">
                  @<a href="/{{ $user->username }}" class="gray-text">{{ $user->username }}</a>
                </div>
                <div class="light-gray-text tc mb-3">{{ $user->description }}</div>
                @if ($user->isBirthdayToday())
                  <div class="mb3">
                    <i class="fas fa-birthday-cake mr2"></i>{{ __('user.contact_birthday_notify', ['firstName' => $user->first_name]) }}
                  </div>
                @endif

                @if (! $isProfileOwner)
                  <actions-component :user-id="{{ $user->id }}" :authenticated-user-id="{{ auth()->user()->id }}" :default-type="'{{ $relationship->type }}'"></actions-component>
                @endif
              </div>
            </div>
            <div>
              <!-- Contact information -->
              <div class="section pt4">
                <div class="f5 mb3">{{ __('user.contact_information_heading') }}</div>
                @include('contacts.partials.phone')
                @include('contacts.partials.email')
                @include('contacts.partials.address')
              </div>

              <!-- Custom information -->
              <div class="section pt4">
                <div class="f5 mb3">{{ __('user.custom_information_heading') }}</div>
                @include('contacts.partials.custom')
              </div>

              @if (! $isProfileOwner)
                <!-- Tags -->
                <tags-component :user-id="{{ $user->id }}"></tags-component>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card mb-3">
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
                  <a href="/{{ $user->username }}?tab=debts" class="db tc pa3 {{ $activeTab == 'debts' ? 'fw6' : '' }}" style="{{ $activeTab == 'debts' ? 'border-bottom: 2px solid #29a8ab; color: #29a8ab;' : 'color: #8c9396;' }} text-decoration: none;">{{ __('user.debts_tab') }}</a>
                </li>
                <li class="fl">
                  <a href="/{{ $user->username }}?tab=contact-logs" class="db tc pa3 {{ $activeTab == 'contact-logs' ? 'fw6' : '' }}" style="{{ $activeTab == 'contact-logs' ? 'border-bottom: 2px solid #29a8ab; color: #29a8ab;' : 'color: #8c9396;' }} text-decoration: none;">{{ __('user.contact_logs_tab') }}</a>
                </li>

                @if($isProfileOwner)
                  <li class="fr">
                    <a href="/{{ $user->username }}/activity-log" class="db tc pa3" style="color: #8c9396;"><i class="fas fa-list-ul mr2"></i><span class="dn di-ns">Activity Log</span></a>
                  </li>
                @endif
              </ul>
            </div>
          </div>
          
          @if($activeTab == 'notes')
            @include('contacts.notes.index')
          @endif

          @if($activeTab == 'reminders')
            @include('contacts.reminder.index')
          @endif

          @if($activeTab == 'debts')
            @include('contacts.debts.index')
          @endif

          @if($activeTab == 'contact-logs')
            @include('contacts.log.index')
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
