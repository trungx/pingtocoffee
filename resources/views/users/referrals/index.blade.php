@extends('layouts.skeleton')
@section('content')
  <div class="settings">
    <div class="container">
      <div class="row">
        @include('settings.sidebar')
        <div class="col-12 col-md-9">
          <div class="row">
            <div class="col-lg-8 order-lg-0">
              <div class="affiliates mb-3">
                @include('components.errors')
                @if (session('status'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <h4>{{ __('user.referrals_title') }}</h4>
                <p>{{ __('user.referrals_send_mail_desc') }}</p>
                <form action="/referrals" method="POST">
                  @csrf
                  <div class="form-group mr-3 mb-2">
                    <label for="email" class="sr-only">Friend's email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Friend's email">
                  </div>
                  <button type="submit" class="btn default-btn b mb-2">{{ __('settings.send_invite') }}</button>
                </form>
                <p>{{ __('user.referrals_share_link_desc') }}</p>
                <form onsubmit="return false">
                  <div class="form-group mr-3 mb-2">
                    <label for="email" class="sr-only">Invite link</label>
                    <input type="text" class="form-control" id="affiliate-link" value="{{ env('APP_URL') }}/register?ref={{ $referralCode }}" style="min-width: 290px;" readonly>
                  </div>
                  <button type="submit" class="btn default-btn b mb-2" id="copy-to-clipboard-btn" data-clipboard-target="#affiliate-link">{{ __('settings.copy') }}</button>
                </form>
                <small class="form-text light-gray-text">{{ __('user.referrals_small_explain') }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
  <script type="text/javascript">
    var btn = document.getElementById('copy-to-clipboard-btn');
    var clipboard = new ClipboardJS(btn);

    clipboard.on('success', function(e) {
      changeState(e.trigger, 'Copied!');
    });

    function changeState(elem, msg) {
      elem.innerHTML = msg;
    }
  </script>

  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\SendInviteMailRequest'); !!}
@endpush