@extends('layouts.skeleton')
@section('content')
  <div class="settings">
    <div class="container">
      <div class="row">
        @include('settings.sidebar')
        <div class="col-12 col-md-9">
          <div class="relative">
            <!-- Setting Title -->
            <div class="row">
              <div class="col-12">
                <h4>{{ __('settings.contact_field_title') }}</h4>
              </div>
            </div>

            <!-- Setting Content -->
            <div class="row">
              <div class="col-lg-8">

                @include('components.errors')

                <div class="mb3 light-gray-text">{{ __('settings.contact_field_desc') }}</div>

                @if (session('status'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif

                @include('settings.contactfield.partials.phone')

                @include('settings.contactfield.partials.email')

                @include('settings.contactfield.partials.address')

                @include('settings.contactfield.partials.social-profile')

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
