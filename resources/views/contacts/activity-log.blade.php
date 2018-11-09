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
                <actions-component :user-id="{{ $user->id }}" :authenticated-user-id="{{ auth()->user()->id }}" :default-type="'{{ $relationship->type }}'"></actions-component>
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
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card mb-3">
          <activity-log></activity-log>
        </div>
      </div>
    </div>
  </div>
@endsection
