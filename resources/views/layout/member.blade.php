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
    <link rel="icon" href="{{ asset('images/logo-.png')}}" width="10px" height="10px"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/skin-blue.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/countrySelect.min.css')}}">
    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/countrySelect.min.js')}}"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
    <script>
      var user = @json(auth()->user());
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
    <?php $lang = app()->getLocale();?>
  </head>

  <body>
    @include('elements.member_header')
    @yield('content')
    @include('elements.footer')
    @yield('scripts')
    <script src="{{ asset('js/app.js')}}"></script>
    <script>
      var lang = "{{$lang}}";
       //flagStrap
       $("#member_site_lang").countrySelect({
        preferredCountries: ['gb','no'],
        responsiveDropdown: false
      });
      if (lang == 'en') {
        $("#member_site_lang").countrySelect("selectCountry", "gb");
      } else {
        $("#member_site_lang").countrySelect("selectCountry", "no"); 
      }
      $("#member_site_lang").on('change', function () {
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
        var sel_lang = $("#member_site_lang").countrySelect("getSelectedCountryData");
        $("#member_selected_lang").val(sel_lang.name);
        if (sel_lang.name == 'English') {
          switch (url) {
            case 'finn-konsulent':
              url = 'find-consultant';
              break;
            case 'finn-kunde':
              url = 'find-customer';
              break;
            case 'kontantkort':
              url = 'prepaid-card';
              break;
            case 'fakturaer':
              url = 'invoice';
              break;
            case 'kontoinnstillinger':
              url = 'member-settings';
              break;
          }
        } else {
          switch (url) {
            case 'find-consultant':
              url = 'finn-konsulent';
              break;
            case 'find-customer':
              url = 'finn-kunde';
              break;
            case 'prepaid-card':
              url = 'kontantkort';
              break;
            case 'invoice':
              url = 'fakturaer';
              break;
            case 'member-settings':
              url = 'kontoinnstillinger';
              break;
          }
        }
        $("#member_current_address").val(url);
        $("#member-lang-form").trigger('submit');
      });
    </script>
  </body>
</html>