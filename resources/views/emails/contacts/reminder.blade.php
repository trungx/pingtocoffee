@component('mail::message')
  # Hello {{ $fromUser->first_name }}!

  You have a new reminder. Please take note!

  @component('mail::panel')
  **For Contact**: {{ $toUser->getCompleteName() }}

  **Title**: {{ $reminder->title }}

  **Description**: {{ $reminder->description ? $reminder->description : '*No description*' }}
  @endcomponent
  
  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
