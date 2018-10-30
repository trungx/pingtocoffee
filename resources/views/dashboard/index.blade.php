@extends('layouts.skeleton')
@section('content')
  <div class="dashboard">
    <div class="container">
      <div class="row">
        <div class="col-md-5 mb-3">
          <summary-component :default-active-tab="'logs'"></summary-component>
        </div>
        <div class="col-md-7 mb-3">
          <activity-log></activity-log>
        </div>
      </div>
    </div>
  </div>
@endsection
