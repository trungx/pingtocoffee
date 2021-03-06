@extends('layouts.skeleton')
@section('content')
  <div class="user-list">
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
              @if (request()->tag)
                <li class="bb b--black-10 pa2 relative">
                  <i class="fa fa-users light-gray-text mr2"></i>{!! __('user.contacts_under_tag', ['total' => $contacts->count()]) !!}<a href="javascript:void(0)" class="tag ma0 ml2 f7">{{ request()->tag }}</a>
                </li>
              @else
                <li class="bb b--black-10 pa2 relative">
                  <i class="fa fa-users light-gray-text mr2"></i>{!! __('user.contacts_under_nothing', ['total' => $contacts->count()]) !!}
                </li>
              @endif

              @foreach($contacts as $contact)
                <li class="user-list-item relative">
                  <a class="_item" href="/{{ $contact->username }}">
                    @if ($contact->has_avatar)
                      <img src="{{ $contact->getAvatarUrl(\App\Helpers\ImageHelper::SMALL_SIZE) }}" class="mr-2 br-100" style="width: 42px;">
                    @else
                      <div class="default-avatar mr-2 br-100" style="background-color: {{ $contact->default_avatar_color }}; width: 42px; height: 42px; line-height: 42px;">
                        {{ $contact->getInitials() }}
                      </div>
                    @endif
                    <span class="f5">{{ $contact->getCompleteName() }}</span>
                    @if ($contact->isBirthdayToday())
                      <span class="mh2 gray-text" title="{{ __('user.contact_birthday_notify', ['firstName' => $contact->first_name]) }}">
                        <i class="fas fa-birthday-cake"></i>
                      </span>
                    @endif

                    <div class="absolute lightest-gray-text i f7" style="top: 50%; right: 10px; margin-top: -9px;">{{ __('dashboard.joined_on', ['date' => $contact->joined_on]) }}</div>
                  </a>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="col-12 col-md-4">
          <!-- Tags -->
          @if ($tags->count() > 0)
            <div class="sidebar relative bg-white mb-3 br2">
              <div class="db mb2 ph3 pv2" style="border-bottom: 1px solid #e4e6e8;">
                <div class="light-gray-text dib"><i class="fas fa-tags mr2"></i>{{ __('user.tags') }}</div>
              </div>
              <div class="pa3">
                <ul class="tags f7">
                  @foreach($tags as $tag)
                    <li><a href="/contacts?tag={{ $tag->name }}" class="tag">{{ $tag->name }}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif

          <!-- Received Requests -->
          @if (!request()->tag)
            <received-requests></received-requests>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
