@extends('layouts.skeleton')
@section('content')
  <div class="settings">
    <div class="container">
      <div class="row">
        @include('settings.sidebar')
        <div class="col-12 col-md-9">
          <!-- Setting Title -->
          <div class="row">
            <div class="col-12">
              <h4 class="with-actions">{{ __('settings.account_field_title') }}</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 order-lg-12">
              <form id="avatar-upload-form" enctype="multipart/form-data" action="javascript:void(0)" onsubmit="return false">
                <div class="avatar-upload-container">
                  <div class="form-group">
                    <label for="account-avatar">{{ __('settings.profile-picture') }}</label>
                    <div id="account-avatar">
                      @if (auth()->user()->has_avatar)
                        <img class="br2" src="{{ auth()->user()->getAvatarUrl(\App\Helpers\ImageHelper::LARGE_SIZE) }}" width="200">
                      @else
                        <div class="default-avatar pt5 f1 br2" style="background-color: {{ auth()->user()->default_avatar_color }}; width:200px; height:200px;">
                          {{ auth()->user()->getInitials() }}
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="relative tc default-btn pv1 ph3 b" style="width: 200px;">
                      <span id="upload-button-label">{{ __('settings.upload_new_picture') }}</span>
                      <input id="avatar" class="absolute top-0 left-0 pa0 w-100 o-0 pointer" name="avatar" type="file">
                    </label>
                  </div>
                  <!-- Print messages -->
                  <div id="print-msg" class="alert dn"></div>
                </div>
              </form>
            </div>
            <div class="col-lg-8 order-lg-0">
              @include('components.errors')
              @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('status') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
              <form action="/settings/store" id="setting-form" method="POST">
                @csrf
                <!-- Username -->
                <div class="form-group">
                  <label for="username">{{ __('settings.username') }}</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="@henryonsoftware" value="{{ old('username') ?? auth()->user()->username }}">
                  <!-- Display profile link with username -->
                  @if (auth()->user()->username)
                    <a href="/{{ auth()->user()->username }}" class="f7">
                      {{ config('app.url') }}/<b>{{ auth()->user()->username }}</b>
                    </a>
                  @endif
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <!-- First name -->
                    <div class="form-group">
                      <label for="first_name">{{ __('settings.firstname') }}</label>
                      <input type="text" class="form-control" name="first_name" id="first_name" required value="{{ old('first_name') ?? auth()->user()->first_name }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <!-- Last name -->
                    <div class="form-group">
                      <label for="last_name">{{ __('settings.lastname') }}</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" required value="{{ old('last_name') ?? auth()->user()->last_name }}">
                    </div>
                  </div>
                </div>
                <!--Short description-->
                <div class="form-group">
                  <label for="description">{{ __('settings.description') }}</label>
                  <textarea class="form-control" name="description" id="description" rows="3" maxlength="300" placeholder="{{ __('settings.description_placeholder') }}">{{ old('description') ?? auth()->user()->description }}</textarea>
                </div>
                <!-- Email -->
                <div class="form-group">
                  <label for="email">{{ __('settings.email') }}</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('settings.email_placeholder') }}" required value="{{ old('email') ?? auth()->user()->email }}">
                </div>
                <!-- Birthday -->
                <div class="form-group">
                  <label for="birthday">{{ __('settings.birthday') }}</label>
                  <div class="birthday-box">
                    <select id="year" name="year" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" style="width: 74px!important; display: inline-block!important;" onchange="changeYear(this)"></select>
                    <select id="month" name="month" class="form-control{{ $errors->has('month') ? ' is-invalid' : '' }}" style="width: 90px!important; display: inline-block!important;" onchange="changeMonth(this)"></select>
                    <select id="day" name="day" class="form-control{{ $errors->has('day') ? ' is-invalid' : '' }}" style="width: 74px!important; display: inline-block!important;"></select>
                    <span class="invalid-feedback">
                    <strong>{{ $errors->has('birthday') ? $errors->first('birthday') : '' }}</strong>
                  </span>
                  </div>
                </div>
                <!-- Gender -->
                <div class="form-group">
                  <label for="birthday">{{ __('settings.gender') }}</label>
                  <select class="form-control" name="gender" id="gender">
                    <option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>{{ __('settings.gender_male') }}</option>
                    <option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>{{ __('settings.gender_female') }}</option>
                    <option value="other" {{ auth()->user()->gender == 'other' ? 'selected' : '' }}>{{ __('settings.gender_other') }}</option>
                  </select>
                </div>
                <!-- Timezone -->
                <div class="form-group">
                  <label for="timezone">{{ __('settings.timezone') }}</label>
                  @include('settings.countries')
                </div>
                <button type="submit" class="btn default-btn b">{{ __('settings.save') }}</button>
              </form>
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
  {!! JsValidator::formRequest('App\Http\Requests\SettingRequest'); !!}
  <script type="text/javascript">
    // index => month [0-11]
    let numberDaysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];

    $(document).ready(function() {
      // Init form select
      initSelectBox();
      
      // Upload profile picture
      $("#avatar").on("change", function () {
        $("#avatar-upload-form").submit();
      });
  
      $('#avatar-upload-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        showLoading();
        $.ajax({
          url: "/settings/upload-avatar",
          type: 'POST',
          dataType: 'json',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function (data) {
            hideLoading();
            if (data.status == 'success') {
              $('#print-msg').html(data.msg).addClass('db').removeClass('dn').addClass('alert-success').removeClass('alert-danger').css('width', 200);
              $('#account-avatar').html(`<img class="br2" src="${data.src}" width="200">`);
            } else {
              let errorsText = "";
              for (let i = 0; i < data.errors.length; i++) {
                errorsText += `<li>${data.errors[i]}</li>`;
              }
              let errorsTexts = `<ul class="pl-2">${errorsText}</ul>`;
              $('#print-msg').html(errorsTexts).addClass('db').removeClass('dn').addClass('alert-danger').removeClass('alert-success').css('width', 200);
            }
          },
          error: function (e) {
            console.log(e);
          }
        });
      });
    });

    function initSelectBox() {
      let oldBirthday = "{{ auth()->user()->birthday }}";
      let selectedDay = "";
      let selectedMonth = "";
      let selectedYear = "";

      if (oldBirthday !== "") {
        selectedDay = parseInt(oldBirthday.substr(8, 2));
        selectedMonth = parseInt(oldBirthday.substr(6, 2));
        selectedYear = parseInt(oldBirthday.substr(0, 4));
      }

      let dayOption = `<option value="">{{ __('settings.day_lc') }}</option>`;
      for (let i = 1; i <= numberDaysInMonth[0]; i++) { //add option days
        if (i === selectedDay) {
          dayOption += `<option value="${i}" selected>${i}</option>`;
        } else {
          dayOption += `<option value="${i}">${i}</option>`;
        }
      }
      $('#day').append(dayOption);

      let monthOption = `<option value="">{{ __('settings.month_lc') }}</option>`;
      for (let j = 1; j <= 12; j++) {
        if (j === selectedMonth) {
          monthOption += `<option value="${j}" selected>${j}</option>`;
        } else {
          monthOption += `<option value="${j}">${j}</option>`;
        }
      }
      $('#month').append(monthOption);

      let d = new Date();
      let yearOption = `<option value="">{{ __('settings.year_lc') }}</option>`;
      for (let k = d.getFullYear(); k >= 1918; k--) {// years start k
        if (k === selectedYear) {
          yearOption += `<option value="${k}" selected>${k}</option>`;
        } else {
          yearOption += `<option value="${k}">${k}</option>`;
        }
      }
      $('#year').append(yearOption);
    }

    function isLeapYear(year) {
      year = parseInt(year);
      if (year % 4 != 0) {
        return false;
      }
      if (year % 400 == 0) {
        return true;
      }
      if (year % 100 == 0) {
        return false;
      }
      return true;
    }

    function changeYear(select) {
      if (isLeapYear($(select).val())) {
        // Update day in month of leap year.
        numberDaysInMonth[1] = 29;
      } else {
        numberDaysInMonth[1] = 28;
      }

      // Update day of leap year.
      let monthSelectedValue = parseInt($("#month").val());
      if (monthSelectedValue === 2) {
        let day = $('#day');
        let daySelectedValue = parseInt($(day).val());
        if (daySelectedValue > numberDaysInMonth[1]) {
          daySelectedValue = null;
        }

        $(day).empty();

        let option = `<option value="">{{ __('settings.day_lc') }}</option>`;
        for (let i = 1; i <= numberDaysInMonth[1]; i++) { //add option days
          if (i === daySelectedValue) {
            option += `<option value="${i}" selected>${i}</option>`;
          } else {
            option += `<option value="${i}">${i}</option>`;
          }
        }

        $(day).append(option);
      }
    }

    function changeMonth(select) {
      let day = $('#day');
      let daySelectedValue = parseInt($(day).val());
      let month = 0;

      if ($(select).val() !== '') {
        month = parseInt($(select).val()) - 1;
      }

      if (daySelectedValue > numberDaysInMonth[month]) {
        daySelectedValue = null;
      }

      $(day).empty();

      let option = `<option value="">{{ __('settings.day_lc') }}</option>`;

      for (let i = 1; i <= numberDaysInMonth[month]; i++) { //add option days
        if (i === daySelectedValue) {
          option += `<option value="${i}" selected>${i}</option>`;
        } else {
          option += `<option value="${i}">${i}</option>`;
        }
      }

      $(day).append(option);
    }

    function showLoading() {
      $('#upload-button-label').html("{{ __('settings.uploading') }}");
      $('input#avatar').prop('disabled', true).focusout();
    }
    
    function hideLoading() {
      $('#upload-button-label').html("{{ __('settings.upload_new_picture') }}");
      $('input#avatar').prop('disabled', false);
    }
  </script>
@endpush
