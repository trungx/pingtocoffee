@component('mail::message')
  # Welcome!

  Thanks for signed up and try to use Ping to coffee.

  If you've been trying to control your busy life, we bet you don't want to lost friendships.
  Joining with us is a correct decision of you and we believe you will have more good friends.

  @component('mail::button', ['url' => env('APP_URL'), 'color' => 'green'])
    Open the app
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
