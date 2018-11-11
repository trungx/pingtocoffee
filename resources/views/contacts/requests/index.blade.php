@extends('layouts.skeleton')
@section('content')
  <div class="user-list">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          @if ($outgoingRequests)
            <all-requests-sent></all-requests-sent>
          @else
            <all-received-requests></all-received-requests>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
