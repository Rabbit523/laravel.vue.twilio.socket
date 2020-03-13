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
    <link rel="icon" href="{{ asset('images/logo-.png')}}" width="10px" height="10px"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/skin-blue.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/countrySelect.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/countrySelect.min.js')}}"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <script>
      $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');

        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
          $('.dropdown-submenu .show').removeClass("show");
        });

        return false;
      });
    </script>
  </head>

  <body>
    @include('elements.header')
    @yield('content')
    @include('elements.footer')
    @yield('scripts')
    <?php $lang = app()->getLocale();?>
    <script>
      var lang = "{{$lang}}";
       //flagStrap
      $("#site_lang").countrySelect({
        preferredCountries: ['gb','no'],
        responsiveDropdown: false
      });
      if (lang == 'en') {
        $("#site_lang").countrySelect("selectCountry", "gb");
      } else {
        $("#site_lang").countrySelect("selectCountry", "no"); 
      }
      $("#site_lang").on('change', function () {
        if (lang == 'en') {
          lang = '';
        } else {
          lang = 'no/';
        }
        if (window.location.port != '') {
          var sub_url = window.location.protocol + "//" + window.location.hostname + ":" + window.location.port + '/' + lang;
        } else {
          var sub_url = window.location.protocol + "//" + window.location.hostname + '/' + lang;
        }
        var url = window.location.href.replace(sub_url, '');
        var sel_lang = $("#site_lang").countrySelect("getSelectedCountryData");
        $("#selected_lang").val(sel_lang.name);
        if (sel_lang.name == 'English') {
          switch (url) {
            case 'bli-konsulent':
              url = 'become-consultant';
              break;
            case 'om-oss':
              url = 'about';
              break;
            case 'personvern':
              url = 'privacy';
              break;
            case 'vilkar-kunde':
              url = 'terms-customer';
              break;
            case 'vilkar-tilbyder':
              url = 'terms-provider';
              break;
            case 'logg-inn':
              url = 'login';
              break;
            case 'registrer':
              url = 'register';
              break;
          }
        } else {
          switch (url) {
            case 'become-consultant':
              url = 'bli-konsulent';
              break;
            case 'about':
              url = 'om-oss';
              break;
            case 'privacy':
              url = 'personvern';
              break;
            case 'terms-customer':
              url = 'vilkar-kunde';
              break;
            case 'terms-provider':
              url = 'vilkar-tilbyder';
              break;
            case 'login':
              url = 'logg-inn';
              break;
            case 'register':
              url = 'registrer';
              break;
          }
        }
        if (url.includes('category')) {
          url = url.replace('category', 'kategori');
        } else if (url.includes('kategori')) {
          url = url.replace('kategori', 'category');
        } else if (url == window.location.href) {
          url = '';
        }
        $("#current_address").val(url);
        $("#lang-form").trigger('submit');
      });
    </script>
  </body>
</html>