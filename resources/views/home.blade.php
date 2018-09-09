<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="">
  <meta name="author" content="@henrybui">
  <title>{{ config('app.name', 'Ping to coffee') }}</title>

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicons/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicons/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicons/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicons/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicons/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicons/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicons/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicons/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/favicons/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicons/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('img/favicons/manifest.json') }}">

  <!-- Meta -->
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('img/favicons/ms-icon-144x144.png') }}">
  <meta name="theme-color" content="#ffffff">

  <!-- Styles -->
  <link href="{{ mix('css/marketing/app.css') }}" rel="stylesheet">
</head>
<body class="font-sans text-smooth">
  <header class="bg-blue-lightest border-t-4 border-teal-dark hero-background">
    <div class="container px-4 mx-auto">
      <div class="block sm:flex mt-4">
        <div class="justify-center sm:justify-start sm:w-1/2 flex items-center">
          <a href="/home" class="no-underline font-bold uppercase text-2xl" style="color: #464240;">{{ config('app.name', 'Ping to coffee') }}</a>
        </div>
        <div class="block text-center sm:w-1/2 sm:text-right font-semibold">
          @if (auth()->check())
            <a href="/dashboard" class="inline-block mr-8 py-6 no-underline text-grey-darkest hover:text-black">{{ __('auth.go-to-dashboard') }}</a>
          @else
            <a href="/login" class="inline-block mx-4 py-6 no-underline text-grey-darkest hover:text-black">{{ __('auth.login-cta') }}</a>
            <a href="/register" class="inline-block mx-4 py-6 no-underline text-grey-darkest hover:text-black">{{ __('auth.signup-cta') }}</a>
          @endif
        </div>
      </div>
      <div class="text-center mt-12">
        <h1 class="text-4xl md:text-5xl text-black font-semibold font-headline">Start Here.</h1>
        <p class="text-xl md:text-2xl leading-normal text-grey-darkest max-w-lg mx-auto py-6 md:py-8">Build a good relationship with your relatives, friends, partners,...<br>Never miss good wishes to them.</p>
        @if (auth()->check())
          <a href="/dashboard" class="inline-block bg-teal-dark px-6 py-2 sm:px-8 sm:py-3 rounded-full text-white border-2 border-teal-dark mx-2 font-semibold text-xl no-underline">{{ __('auth.go-to-dashboard') }}</a>
        @else
          <a href="/register" class="inline-block bg-teal-dark px-6 py-2 sm:px-8 sm:py-3 rounded-full text-white border-2 border-teal-dark mx-2 font-semibold text-xl no-underline">{{ __('auth.get-started-cta') }}</a>
        @endif
      </div>
    </div>
  </header>
  <section class="bg-black border-t-4 border-teal-dark py-16">
    <div class="container mx-auto px-4 text-center">
      <h2 class="font-headline text-white uppercase text-xl md:text-2xl font-semibold mb-4 md:mb-8">Superhero Phonebook.</h2>
      <div class="bg-teal-dark w-12 h-1 mx-auto mb-4 md:mb-8"></div>
      <div class="text-lg md:text-xl max-w-md mx-auto leading-normal text-grey-lightest">
        <p class="mb-4">Ping to coffee is an application that provides the way for keep in touch with other people in the busy life. Your friends phone number? We got that. Birthday? No problem.</p>
        <p>We even take care of how long have you been out of contact with someone? We will make your relationships more better, take more best friends for you.</p>
      </div>
    </div>
  </section>
  <section class="bg-teal-dark py-8">
    <div class="container mx-auto px-4 text-center">
      <p class="text-xl md:text-2xl max-w-md mx-auto leading-normal text-white mb-8">It's free now. No credit card required.</p>
      @if (auth()->check())
        <a href="/contacts" class="bg-white px-8 py-2 rounded-full text-teal border-2 border-teal-dark mx-2 font-semibold text-xl no-underline">{{ __('auth.go-to-contact') }}</a>
      @else
        <a href="/register" class="bg-white px-8 py-2 rounded-full text-teal border-2 border-teal-dark mx-2 font-semibold text-xl no-underline">{{ __('auth.signup-cta') }}</a>
      @endif
    </div>
  </section>
  <section class="bg-blue-lightest">
    <div class="container px-4 mx-auto px-4 pt-16 pb-12">
      <div class="text-center mb-16">
        <div class="font-headline text-teal uppercase text-xl md:text-2xl font-semibold mb-4">Your personal notebook</div>
        <div class="text-lg md:text-xl max-w-md mx-auto leading-normal text-grey-darkest">All you need for relationships were here.</div>
      </div>
      <div class="flex flex-wrap -mx-4">
        <div class="w-full md:w-1/3 sm:w-1/2 px-4 mb-12">
          <h3 class="text-2xl font-bold text-black mb-2">Easy Connect</h3>
          <p class="text-base leading-normal text-grey-darkest">Easy make friends with anyone you want. Just search, make request, and be accepted! No longer worry about how to get someone's phone number through another person without accepted!</p>
        </div>
        <div class="w-full md:w-1/3 sm:w-1/2 px-4 mb-12">
          <h3 class="text-2xl font-bold text-black mb-2">Keep In Touch</h3>
          <p class="text-base leading-normal text-grey-darkest">Have you ever been crazy because want to call someone without knowing their phone number? Or you want to notify new phone number but couldn't public it on Facebook? Don't worry, Ping can easily synchronize phone, email, address,...anytime you want.</p>
        </div>
        <div class="w-full md:w-1/3 sm:w-1/2 px-4 mb-12">
          <h3 class="text-2xl font-bold text-black mb-2">Auto Reminder</h3>
          <p class="text-base leading-normal text-grey-darkest">Why don't we call our best friends more often? Sometimes we forget it because we are in a fast life. The reminder feature will help you know when should you call them and hang out together.</p>
        </div>
      </div>
    </div>
  </section>
  <section class="bg-teal-dark py-12">
    <div class="container px-4 text-center max-w-lg mx-auto">
      <p class="text-xl md:text-2xl italic text-white leading-normal mb-4">I built "Ping to coffee" because I had trouble keeping in touch with my friends and relatives in this busy life. I hope to help those who have the same trouble with me.</p>
      <img class="mb-4" src="img\henry.jpg" width="60" height="60" style="border-radius: 50%;">
      <div class="text-lg font-semibold text-white mb-2">Henry Bui</div>
      <div class="text-lg font-semibold text-teal-lighter mb-2">Founder</div>
    </div>
  </section>
  <section class="bg-black py-8">
    <div class="container px-4 text-center max-w-lg mx-auto">
      <ul class="list-reset flex justify-center flex-wrap">
        <li class="m-3">
          <a class="text-teal-lighter hover:text-green-lightest font-semibold no-underline" href="#">{{ __('auth.feedback') }}</a>
        </li>
        <li class="m-3">
          <a class="text-teal-lighter hover:text-green-lightest font-semibold no-underline" href="#">{{ __('auth.news') }}</a>
        </li>
        <li class="m-3">
          <a class="text-teal-lighter hover:text-green-lightest font-semibold no-underline" href="#">{{ __('auth.terms-of-use') }}</a>
        </li>
        <li class="m-3">
          <a class="text-teal-lighter hover:text-green-lightest font-semibold no-underline" href="#">{{ __('auth.privacy-policy') }}</a>
        </li>
      </ul>
      <div class="text-white leading-normal no-underline">© Ping to coffee {{ date('Y') }}. All right reserved</div>
    </div>
  </section>
</body>
</html>
