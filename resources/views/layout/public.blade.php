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
    <meta name="description" content="@yield('description')">
    <link rel="icon" href="{{ asset('images/color-logo.svg')}}" width="10px" height="10px"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/countrySelect.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{ asset('css/yearpicker.css')}}">
    <link rel="stylesheet" href="{{ asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/countrySelect.min.js')}}"></script>
    <script src="{{ asset('js/yearpicker.js')}}"></script>
    <script src="{{ asset('js/slick.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  </head>

  <body>
    <?php $lang = app()->getLocale();?>
    @include('elements.header')
    @yield('content')
    @include('elements.footer')
    <script> var lang = "{{$lang}}"; </script>
    <script src="{{ asset('js/intlTelInput.min.js')}}"></script>
    <script src="{{ asset('js/jquery.crs.min.js')}}"></script>
    <script src="{{ asset('js/timezones.full.min.js')}}"></script>
    <script src="{{ asset('js/public-gotoconsult.js')}}"></script>
    <script>
      jQuery(function(){
        new gotoconsult.Controllers.public();
      });
    </script>
    @yield('scripts')
  </body>
</html>