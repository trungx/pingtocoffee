@component('mail::message')
  # Hello!

  You are received this email because your friend is using Ping to coffee to save and find contact information.
  From anywhere, you can connect with your friends and their contact information.
  You won't need to worry about lost phone number, email, or social networks of your friends.

  Interested? **Sign up** for free at below button. We hope you will get more better relationships.

  @component('mail::button', ['url' => config('app.url') . '/register?ref=' . $user->referral_code, 'color' => 'primary'])
    Sign Up
  @endcomponent

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
