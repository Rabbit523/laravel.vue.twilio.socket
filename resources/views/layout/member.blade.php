<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description')">
    <link rel="icon" href="{{ asset('images/color-logo.svg')}}" width="10px" height="10px"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/countrySelect.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/star-rating-svg.css')}}">
    <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/jquery.dynatable.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.js"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/countrySelect.min.js')}}"></script>
    <script src="{{ asset('js/intlTelInput.min.js')}}"></script>
    <script src="{{ asset('js/jquery.star-rating-svg.min.js')}}"></script>
    <script src="https://js.braintreegateway.com/web/dropin/1.22.1/js/dropin.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dynatable/0.3.1/jquery.dynatable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
  </head>

  <body>
    <?php $lang = app()->getLocale();?>
    @if(Auth::check())
    @include('elements.member_header')
    @else
    @include('elements.header')
    @endif
    @yield('content')
    @include('elements.footer')
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{ asset('js/jquery.crs.min.js')}}"></script>
    <script src="{{ asset('js/timezones.full.min.js')}}"></script>
    <script> var lang = "{{$lang}}"; var user = @json(auth()->user());</script>
    <script src="{{ asset('js/member-gotoconsult.js')}}"></script>
    @yield('scripts')
  </body>
</html>