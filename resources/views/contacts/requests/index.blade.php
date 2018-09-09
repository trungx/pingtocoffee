@extends('layouts.skeleton')
@section('content')
  <div class="user-list">
    <div class="mt-3">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <ul class="relative list pa0 ma0 bg-white mb-3 br2" style="border: 1px solid #d1d5da;">
              <!-- Heading -->
              <li class="user-list-header pa2 relative b">
                @if ($outgoingRequests)
                  {{ __('user.requests_sent_title') }}
                @else
                  {{ __('user.received_requests_title') }}
                @endif
              </li>

              <!-- List contact request -->
              @if ($contacts->count() == 0)
                @include('contacts.requests.empty')
              @else
                @foreach($contacts as $contact)
                  <li class="user-list-item">
                    <a class="_item" href="/contact/{{ $contact->id }}">
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
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
