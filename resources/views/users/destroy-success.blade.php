@extends('layouts.skeleton')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('auth.login-title') }}</div>
          <div class="card-body">
            <p>{!! __('auth.destroy_date_desc', ['day_will_be_deleted' => $dayWillBeDeleted]) !!}</p>
            <p>{!! __('auth.reactive_suggestion') !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
