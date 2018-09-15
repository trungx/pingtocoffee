@extends('layouts.skeleton')
@section('content')
  <div class="user-list">
    <div class="mt-3">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-8">
            @if ($contacts->count() == 0)
              <!-- Empty state -->
              <div class="card body-empty-state mb-3">
                <div class="card-body">
                  <div class="mv2 f4">{{ __('user.contact_empty') }}</div>
                  <div class="f6 light-gray-text">{{ __('user.contact_empty_suggestion') }}</div>
                </div>
              </div>
            @else
              <ul class="relative list pa0 ma0 bg-white mb-3 br2" style="border:1px solid #d1d5da;">
                <li class="user-list-header pa2 relative">
                  <i class="fa fa-users light-gray-text"></i>
                  {!! __('user.contact_list_total', ['total' => $contacts->count()]) !!}
                </li>
                @foreach($contacts as $contact)
                  <li class="user-list-item">
                    <a class="_item" href="/{{ $contact->username }}">
                      @if ($contact->has_avatar)
                        <img src="{{ $contact->getAvatarUrl(\App\Helpers\ImageHelper::SMALL_SIZE) }}" class="mr-2" alt="Avatar" width="43">
                      @else
                        <div class="default-avatar mr-2" style="background-color: {{ $contact->default_avatar_color }}; width:43px; height:43px; font-size:14px; padding-top:10px;">
                          {{ $contact->getInitials() }}
                        </div>
                      @endif
                      <span class="f5">{{ $contact->getCompleteName() }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
          <div class="col-12 col-md-4">
            <!-- Received Requests -->
            <received-requests></received-requests>
            
            <!-- Requests Sent -->
            <requests-sent></requests-sent>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
