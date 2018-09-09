@extends('layouts.skeleton')
@section('content')
  <div class="settings">
    <div class="container">
      <div class="row">
        @include('settings.sidebar')
        <div class="col-12 col-md-9">
          <!-- Title -->
          <div class="row">
            <div class="col-12">
              <h5>{{ __('settings.contact_field_action_title', ['type' => $type]) }}</h5>
            </div>
          </div>

          <!-- Content -->
          <div class="row">
            <div class="col-lg-8">

              @include('components.errors')

              @include('settings.contactfield.form', [
              'method' => 'POST',
              'action' => route('settings.contact-field.store', ['field' => $field]),
              ])
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
  {!! JsValidator::formRequest('App\Http\Requests\ContactFieldRequest'); !!}
@endpush
