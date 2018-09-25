@extends('layouts.skeleton')
@section('content')
  <div class="settings">
    <div class="container">
      <div class="row">
        @include('settings.sidebar')
        <div class="col-12 col-md-9">
          <div class="mb-4">
            <!-- Title -->
            <div class="row">
              <div class="col-12">
                <h4 class="with-actions">{{ __('settings.security_title') }}</h4>
              </div>
            </div>

            <!-- Content -->
            <div class="row">
              <div class="col-lg-8">
                @include('components.errors')
                @if (session('status'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <form method="POST" action="/settings/security" class="settings-reset">
                  @method('PUT')
                  @csrf
                  <div class="form-group">
                    <label for="password_current">{{ __('settings.password_current') }}</label>
                    <input type="password" class="form-control" name="password_current" id="password_current">
                  </div>
                  <div class="form-group">
                    <label for="password">{{ __('settings.password_new') }}</label>
                    <input type="password" class="form-control" name="password" id="password">
                  </div>
                  <div class="form-group">
                    <label for="password_confirmation">{{ __('settings.password_new_confirmation') }}</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                  </div>
                  <button type="submit" class="btn default-btn b">{{ __('settings.password_update_btn') }}</button>
                </form>
              </div>
            </div>
          </div>

          <div class="mb-4 pa3 ba br2 b--dark-red">
            <!-- Title -->
            <div class="row">
              <div class="col-12">
                <h4 class="dark-red">{{ __('settings.delete_account_title') }}</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                @if(empty(auth()->user()->destroy_date))
                  <div class="mb-2">{{ __('settings.delete_account_desc') }}</div>
                  <form method="POST" action="/users/destroy">
                    @csrf
                    <button type="button" class="btn default-btn b dark-red" onclick="if (confirm('{{ __('settings.delete_account_confirmation') }}')) { $(this).closest('form').submit(); } return false;">
                      {{ __('settings.delete_account_btn') }}
                    </button>
                  </form>
                @else
                  <div class="mb-2">{!! __('settings.deleted_account_desc', ['destroy_date' => auth()->user()->destroy_date]) !!}</div>
                  <form method="POST" action="/users/reverse">
                    @csrf
                    <button type="submit" class="btn default-btn b">
                      {{ __('settings.cancel_delete_account_btn') }}
                    </button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\ChangePasswordRequest'); !!}
@endpush