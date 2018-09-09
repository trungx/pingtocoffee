@extends('layouts.skeleton')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h3 class="text-center">{{ __('user.add_reminders_lbl') }}</h3>
            @include('components.errors')
            @include('contacts.reminder.form', [
            'method' => 'POST',
            'action' => route('contact.reminder.store', $user),
            'add_or_edit' => 'add'
            ])
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\ReminderRequest'); !!}
@endpush
