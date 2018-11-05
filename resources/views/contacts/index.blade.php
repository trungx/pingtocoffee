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
                      @if ($contact->isBirthdayToday())
                        <span class="mh2 gray-text" title="{{ __('user.contact_birthday_notify', ['firstName' => $contact->first_name]) }}">
                          <i class="fas fa-birthday-cake"></i>
                        </span>
                      @endif
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
          <div class="col-12 col-md-4">
            <!-- Tags -->
            <div class="sidebar relative bg-white mb-3 br2">
              <div class="db mb2 ph3 pv2" style="border-bottom: 1px solid #e4e6e8;">
                <div class="light-gray-text dib"><i class="fas fa-tags mr2"></i>{{ __('user.tags') }}</div>
                <a href="#" class="dib fr light-gray-text">{{ __('user.tags_edit_lc') }}</a>
              </div>
              <div class="pa3">
                <ul class="tags f7">
                  @foreach($tags as $tag)
                    <li><a href="/contacts?tag={{ $tag->name }}" class="tag">{{ $tag->name }}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>

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
