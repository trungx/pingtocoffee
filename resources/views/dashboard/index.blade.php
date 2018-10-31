@extends('layouts.skeleton')
@section('content')
  <div class="dashboard">
    <div class="container">
      <div class="row">
        <div class="col-md-3 mb-3">
          <div class="mb3">
            <div class="sidebar-profile">
              <div class="avatar-container mb-2">
                @if ($user->has_avatar)
                  <img src="{{ $user->getAvatarUrl(\App\Helpers\ImageHelper::LARGE_SIZE) }}" class="br-100" style="width:150px;">
                @else
                  <div class="default-avatar br-100" style="background-color: {{ $user->default_avatar_color }}; width:150px;height:150px;font-size:50px;padding-top:35px;">
                    {{ $user->getInitials() }}
                  </div>
                @endif
              </div>
              <div class="f4 b">{{ $user->getCompleteName() }}</div>
              <div class="f6 mb3 light-gray-text">
                @<a href="/{{ $user->username }}" class="gray-text">{{ $user->username }}</a>
              </div>
              <div class="mb3">{{ $user->description }}</div>
              <div class="mb3">
                <div class="light-gray-text mb2">
                  <i class="fas fa-calendar-alt mr2"></i>{{ __('dashboard.joined_on', ['date' => $user->joined_on]) }}
                </div>
                @if ($user->born_on)
                  <div class="light-gray-text mb2">
                    <i class="fas fa-child mr2"></i>{{ __('dashboard.born_on', ['date' => $user->born_on]) }}
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9 mb-3">
          <summary-component :default-active-tab="'logs'"></summary-component>
        </div>
      </div>
    </div>
  </div>
@endsection
