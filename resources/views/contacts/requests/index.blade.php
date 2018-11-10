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
                  <a href="/contacts/requests" class="fr f7 fw4">View Received Requests</a>
                @else
                  {{ __('user.received_requests_title') }}
                  <a href="/contacts/requests?outgoing=1" class="fr f7 fw4">View Requests Sent</a>
                @endif
              </li>

              <!-- List contact request -->
              @if ($contacts->count() == 0)
                @include('contacts.requests.empty')
              @else
                @foreach($contacts as $contact)
                  <li class="user-list-item">
                    <a class="_item" href="/{{ $contact->username }}">
                      @if ($contact->has_avatar)
                        <img src="{{ $contact->getAvatarUrl(\App\Helpers\ImageHelper::SMALL_SIZE) }}" class="mr-2 br-100" style="width: 42px;">
                      @else
                        <div class="default-avatar mr-2 br-100" style="background-color: {{ $contact->default_avatar_color }}; width: 42px; height: 42px; line-height: 42px;">
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
