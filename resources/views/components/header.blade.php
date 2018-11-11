<nav class="navbar navbar-expand-md navbar-light pv0-ns bg-white bb b--black-10">
  <div class="container">
    <a class="navbar-brand ttu b" href="{{ url('/') }}">
      {{ config('app.name') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    @if (auth()->check())
      <!-- Left Side Of Navbar -->
        <div class="search-container di">
          <div class="navbar-nav mr-auto header-search pa0" style="position:relative;">
            <form class="relative form-inline mt-2 my-lg-0" method="POST" action="/user/search" role="search">
              @csrf
              <span class="absolute" style="top: 50%; left: 10px; margin-top: -11px;">
                <svg width="15" height="15" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg"><path d="M9.383 10.347a5.796 5.796 0 1 1 .965-.964L15 14.036l-.964.964-4.653-4.653zm-3.588-.12a4.432 4.432 0 1 0 0-8.863 4.432 4.432 0 0 0 0 8.863z" fill="#BBB" fill-rule="evenodd"></path></svg>
              </span>
              <input class="header-search-input pl4 pr2 pv2 br2 outline-0 ba b--black-10" id="header-search-input" type="search" placeholder="Find your contact...">
            </form>
            <ul class="header-search-results absolute pa0 ma0 list bg-white"></ul>
          </div>
        </div>
    @endif
    <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ml-auto my-2">
        <!-- Authentication Links -->
        @guest
          <li>
            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db" style="text-decoration: none; line-height: 32px;" href="{{ route('login') }}">
              {{ __('auth.login-cta') }}
            </a>
          </li>
          <li>
            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db" style="text-decoration: none; line-height: 32px;" href="{{ route('register') }}">
              {{ __('auth.signup-cta') }}
            </a>
          </li>
        @else
          <li>
            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2" style="text-decoration: none; line-height: 32px;" href="/{{ auth()->user()->username }}" title="{{ __('app.header_profile_link') }}">
              <span>
                @if (auth()->user()->has_avatar)
                  <img src="{{ auth()->user()->getAvatarUrl(\App\Helpers\ImageHelper::SMALL_SIZE) }}" class="br-100 v-mid" style="width: 30px;">
                @else
                  <div class="default-avatar mr-1 br-100 v-mid f7" style="background-color: {{ auth()->user()->default_avatar_color }}; width: 30px; height: 30px; line-height: 30px;">
                    {{ auth()->user()->getInitials() }}
                  </div>
                @endif
                
                <span>{{ auth()->user()->first_name }}</span>
              </span>
            </a>
          </li>
          <li>
            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2" style="text-decoration: none; line-height: 32px;" href="/contacts">
              <i class="fas fa-users"></i>
              {{ __('app.header_contacts_link') }}
            </a>
          </li>
          <li>
            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2" style="text-decoration: none; line-height: 32px;" href="/settings">
              <i class="fas fa-cogs"></i>
              {{ __('app.header_settings_link') }}
            </a>
          </li>
          <li>
            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db" style="text-decoration: none; line-height: 32px;" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="{{ __('app.header_logout_link') }}">
              <i class="fas fa-sign-out-alt"></i>
              <span class="dn-ns">{{ __('app.header_logout_link') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
