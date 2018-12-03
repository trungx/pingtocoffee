@extends('layouts.skeleton')
@section('content')
  <div class="bg-white">
    <div class="pv5">
      <div class="col-md-4 offset-md-4">
        <div class="text-center f3 mb3">{{ __('user.add_debt_lbl') }}</div>

        @include('components.errors')
        @include('contacts.debts.form', [
        'method' => 'POST',
        'action' => route('contact.debt.store', $user),
        'add_or_edit' => 'add'
        ])
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <!-- Laravel Javascript Validation -->
  <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
  {!! JsValidator::formRequest('App\Http\Requests\DebtRequest'); !!}
@endpush

