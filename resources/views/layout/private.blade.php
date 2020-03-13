<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" />

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/countrySelect.min.js')}}"></script>
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
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
    @include('elements.admin_header')
    @yield('content')
    @include('elements.admin_footer')
    @yield('scripts')
    <?php $lang = app()->getLocale();?>
    <script>
      var lang = "{{$lang}}";
       //flagStrap
       $("#admin_site_lang").countrySelect({
        preferredCountries: ['gb','no'],
        responsiveDropdown: false
      });
      if (lang == 'en') {
        $("#admin_site_lang").countrySelect("selectCountry", "gb");
      } else {
        $("#admin_site_lang").countrySelect("selectCountry", "no"); 
      }
      $("#admin_site_lang").on('change', function () {
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
        var sel_lang = $("#admin_site_lang").countrySelect("getSelectedCountryData");
        $("#admin_selected_lang").val(sel_lang.name);
        if (sel_lang.name == 'English') {
          switch (url) {
            case 'sider':
              url = 'pages';
              break;
            case 'opprett-side':
              url = 'create-page';
              break;
            case 'kunder':
              url = 'customers';
              break;
            case 'opprett-kunde':
              url = 'create-customer';
              break;
            case 'konsulenter':
              url = 'consultants';
              break;
            case 'opprett-konsulent':
              url = 'create-consultant';
              break;
            case 'kategorier':
              url = 'categories';
              break;
            case 'opprett-kategori':
              url = 'create-category';
              break;
            case 'innstillinger':
              url = 'settings';
              break;
          }
        } else {
          switch (url) {
            case 'pages':
              url = 'sider';
              break;
            case 'create-page':
              url = 'opprett-side';
              break;
            case 'customers':
              url = 'kunder';
              break;
            case 'create-customer':
              url = 'opprett-kunde';
              break;
            case 'consultants':
              url = 'konsulenter';
              break;
            case 'create-consultant':
              url = 'opprett-konsulent';
              break;
            case 'categories':
              url = 'kategorier';
              break;
            case 'create-category':
              url = 'opprett-kategori';
              break;
            case 'settings':
              url = 'innstillinger';
              break;
          }
          if (url.includes('edit-page')) {
            url = url.replace('edit-page', 'rediger-side');
          } else if (url.includes('rediger-side')) {
            url = url.replace('rediger-side', 'edit-page');
          } else if (url.includes('edit-customer')) {
            url = url.replace('edit-customer', 'rediger-kunde');
          } else if (url.includes('rediger-kunde')) {
            url = url.replace('rediger-kunde', 'edit-customer');
          } else if (url.includes('edit-consultant')) {
            url = url.replace('edit-consultant', 'rediger-konsulent');
          } else if (url.includes('rediger-konsulent')) {
            url = url.replace('rediger-konsulent', 'edit-consultant');
          } else if (url.includes('edit-category')) {
            url = url.replace('edit-category', 'rediger-kategori');
          } else if (url.includes('rediger-kategori')) {
            url = url.replace('rediger-kategori', 'edit-category');
          }
        }
        $("#admin_current_address").val(url);
        $("#admin-lang-form").trigger('submit');
      });
    </script>
  </body>
</html>