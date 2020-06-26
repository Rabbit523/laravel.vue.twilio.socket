var Controllers = {};
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
/*  */
Controllers.public = function () {
  $(".public-btn-country").click(function (e) {
    e.preventDefault();
    const href = window.location.href;
    const origin = window.location.origin;
    var url = href.replace(origin, '');
    if (lang == 'no') {
      switch (url) {
        case '/no/bli-konsulent':
          url = 'become-consultant';
          break;
        case '/no/funksjoner':
          url = 'features';
          break;
        case '/no/om-oss':
          url = 'about';
          break;
        case '/no/personvern':
          url = 'privacy';
          break;
        case '/no/vilkar-kunde':
          url = 'terms-customer';
          break;
        case '/no/vilkar-tilbyder':
          url = 'terms-provider';
          break;
        case '/no/logg-inn':
          url = 'login';
          break;
        case '/no/registrer':
          url = 'register';
          break;
        case '/no':
          url = '';
          break;
      }
    } else {
      switch (url) {
        case '/become-consultant':
          url = 'bli-konsulent';
          break;
        case '/features':
          url = 'funksjoner';
          break;
        case '/about':
          url = 'om-oss';
          break;
        case '/privacy':
          url = 'personvern';
          break;
        case '/terms-customer':
          url = 'vilkar-kunde';
          break;
        case '/terms-provider':
          url = 'vilkar-tilbyder';
          break;
        case '/login':
          url = 'logg-inn';
          break;
        case '/register':
          url = 'registrer';
          break;
        case '/':
          url = '';
          break;
      }
    }
    var new_lang = lang == 'en' ? 'no' : 'en';
    $(".selected_lang").val(new_lang);
    $(".current_address").val(url);
    $(".lang-form").trigger('submit');
  });
  $(".navbar-toggler").click(function () {
    $(".navbar-sidebar").addClass('collapsed');
    $(".navigation__nav").addClass('collapsed');
  });
  $(".navigation-toggler").click(function() {
    $(".navbar-sidebar").removeClass('collapsed');
    $(".navigation__nav").removeClass('collapsed');
  });
};

Controllers.floaLabel = function (element) {
  $(element).focusout(function () {
    var text_val = $(this).val();
    if ($(this)[0].tagName !== 'SELECT' && $(this).hasClass('yearpicker') !== true) {
      $("label[for='" + this.id + "']").toggleClass('labelfocus', text_val !== "");
    }
  }).focusout();

  $(element).focus(function () {
    $("label[for='" + this.id + "']").addClass("labelfocus");
  }).blur(function () {
    if (!$(this).val()) {
      if ($(this)[0].tagName !== 'SELECT' && $(this).hasClass('yearpicker') !== true) {
        $("label[for='" + this.id + "']").removeClass("labelfocus");
      }
    } else {
      $("label[for='" + this.id + "']").addClass("labelfocus");
    }
  });
};

Controllers.sticky = function () {
  $('body').scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".user-btn img").attr("src", "images/user.svg");
      if(window.matchMedia("(max-width: 767px)").matches) {
        $(".navbar-brand img").attr("src", "/images/color-logo.svg");
      } else {
        $(".navbar-brand img").attr("src", "/images/color-full-logo.svg");
      }
      $(".navbar-toggler span").attr("style", "background: #000;");
      $('.navbar').removeClass('transparent');
    } else {
      $(".user-btn img").attr("src", "images/user-w.svg");
      if(window.matchMedia("(max-width: 767px)").matches) {
        $(".navbar-brand img").attr("src", "/images/color-logo.svg");
      } else {
        $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      }
      $(".navbar-toggler span").attr("style", "background: #fff;");
      $('.navbar').addClass('transparent');
    }
  });
};

Controllers.authenticator = function () {
  var init = function () {
    new gotoconsult.Controllers.floaLabel('#login-form .form-control');
    new gotoconsult.Controllers.floaLabel('#register-form .form-control');
    new gotoconsult.Controllers.floaLabel('#consultant-form .form-control');
    new gotoconsult.Controllers.floaLabel('#education-form .form-control');
    new gotoconsult.Controllers.floaLabel('#experience-form .form-control');
    new gotoconsult.Controllers.floaLabel('#certificate-form .form-control');
  };
  init();
};

Controllers.home = function () {
  $(".customer").click(function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").attr('style', 'display: block;');
    $(".consultant-review").attr('style', 'display: none;');
  });
  $(".consultant").click(function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").attr('style', 'display: block;');
    $(".customer-review").attr('style', 'display: none;');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".consultant-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
  });
  var init = function () {
    $("nav").addClass('transparent');
    $(".user-btn img").attr("src", "/images/user-w.svg");
    $(".navbar-toggler span").attr("style", "background: #fff;");
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".navbar-brand img").attr("src", "images/color-logo.svg");
      $(".banner").attr('style', "background-image: url(/images/home/home-banner-mobile.png);");
      $(".inner-footer").attr('style', "background-image: url(/images/home/footer-mobile-bg.png)");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".navbar-brand img").attr("src", "images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(/images/home/home-banner-desktop.png);");
      $(".inner-footer").attr('style', "background-image: url(/images/home/footer-background.png)");
      $(".customer-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
  };
  init();
};

Controllers.about = function () {
  $(".customer").click(function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").attr('style', 'display: block;');
    $(".consultant-review").attr('style', 'display: none;');
  });
  $(".consultant").click(function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").attr('style', 'display: block;');
    $(".customer-review").attr('style', 'display: none;');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".consultant-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
  });
  $(".btn-bio").click(function () {
    var x = $(this).data('key');
    if (lang == 'en') {
      if ($("#show_hide_bio" + x).text() == "Show Bio") {
        $("#show_hide_bio" + x).html("Hide Bio");
      }
      else {
        $("#show_hide_bio" + x).html("Show Bio");
      }
    } else {
      if ($("#show_hide_bio" + x).text() == "Vis Bio") {
        $("#show_hide_bio" + x).html("Skjul Bio");
      }
      else {
        $("#show_hide_bio" + x).html("Vis Bio");
      }
    }
    $("#bio_content" + x).slideToggle();
  });
  var init = function () {
    $("nav").addClass('transparent');
    $(".user-btn img").attr("src", "/images/user-w.svg");
    $(".navbar-toggler span").attr("style", "background: #fff;");
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".navbar-brand img").attr("src", "/images/color-logo.svg");
      $(".banner").attr('style', "background-image: url(/images/about/about-banner-mobile.png);");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(/images/about/about-banner-desktop.png);");
      $(".customer-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
  };
  init();
};

Controllers.features = function () {
  $(".customer").click(function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").attr('style', 'display: block;');
    $(".consultant-review").attr('style', 'display: none;');
  });
  $(".consultant").click(function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").attr('style', 'display: block;');
    $(".customer-review").attr('style', 'display: none;');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".consultant-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
  });
  var init = function () {
    $("nav").addClass('transparent');
    $(".user-btn img").attr("src", "/images/user-w.svg");
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".navbar-brand img").attr("src", "/images/color-logo.svg");
      $(".banner").attr('style', "background-image: url(/images/features/features-banner-mobile.png);");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(/images/features/features-banner-desktop.png);");
      $(".customer-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
    $(".navbar-toggler span").attr("style", "background: #fff;");
  };
  init();
};

Controllers.login = function () {
  $(".login").click(function (event) {
    event.preventDefault();
    if ($("#login-form").valid()) {
      if ($('#remember').is(':checked')) {
        var email = $('#email').val();
        var password = $('#password').val();
        // set cookies to expire in 14 days
        $.cookie('email', email, { expires: 14 });
        $.cookie('password', password, { expires: 14 });
        $.cookie('remember', true, { expires: 14 });
      }
      $("#login-form").submit();
    }
  });
  var init = function () {
    var remember = $.cookie('remember');
    if (remember == 'true') {
      var email = $.cookie('email');
      var password = $.cookie('password');
      // autofill the fields
      $('#email').val(email);
      $('#password').val(password);
    }
    $('#login-form').validate({
      errorPlacement: function () { },
      errorClass: "label",
      highlight: function (element, errorClass, validClass) {
        $(element).parent().addClass("error");
        $(element).parent().removeClass("success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parent().removeClass("error");
        $(element).parent().addClass("success");
      }
    });
  }
  init();
};

Controllers.register = function () {
  $(".register").click(function (event) {
    event.preventDefault();
    if ($("#register-form").valid()) {
      var form = document.getElementById('register-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'remember');
      form.appendChild(hiddenInput);
      if ($("#remember").prop("checked") == true) {
        hiddenInput.setAttribute('value', true);
      } else {
        hiddenInput.setAttribute('value', false);
      }
      $("#register-form").submit();
    }
  });

  var init = function () {
    $('#register-form').validate({
      errorPlacement: function () { },
      errorClass: "label",
      highlight: function (element, errorClass, validClass) {
        $(element).parent().addClass("error");
        $(element).parent().removeClass("success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parent().removeClass("error");
        $(element).parent().addClass("success");
      }
    });
  }
  init();
};

Controllers.category = function (search, countries, is_login) {
  $(".customer").click(function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").attr('style', 'display: block;');
    $(".consultant-review").attr('style', 'display: none;');
  });
  $(".consultant").click(function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").attr('style', 'display: block;');
    $(".customer-review").attr('style', 'display: none;');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".consultant-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
  });  
  var query = {};
  $("#show-filter").click(function () {
    var btn_name = $(this).html();
    if (btn_name == 'Filter') {
      if (lang == 'en') {
        $(this).html('Show Results');
      } else {
        $(this).html('Vis resultater');
      }
      $(".filter-body").attr("style", "display: flex;");
    } else {
      $(".filter-body").attr("style", "display: none;");
      $(this).html('Filter');
      var name = query.name ? query.name : search.name != 'null' ? search.name : 'null';
      var category = search.category;
      var status = query.status ? query.status :  search.status != 'null' ? search.status : 'null';
      var price = query.price ? query.price : search.price != 'null' ? search.price : 'null';
      var country = query.country ? query.country : search.country != 'null' ? e.target.value : 'null';
      if (lang == 'en') {
        var url = "/category-search?name=";
      } else {
        var url = "/no/kategori-sok?name=";
      }
      setTimeout(function () {
        window.location = url + name
          + "&category=" + category
          + "&price=" + price
          + "&status=" + status
          + "&country=" + country;
      }, 50);
    }
  });
  $(".search-input").on('change', function (e) {
    var category = search.category;
    var price = search.price != 'null' ? search.price : 'null';
    var status = search.status != 'null' ? search.status : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    if (lang == 'en') {
      var url = "/category-search?name=";
    } else {
      var url = "/no/kategori-sok?name=";
    }
    if (!isMobile) {
      setTimeout(function () {
        window.location = url + e.target.value
          + "&category=" + category
          + "&price=" + price
          + "&status=" + status
          + "&country=" + country;
      }, 50);
    } else {
      query.name = e.target.value;
    }
  });
  $(".price-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var category = search.category;
    var status = search.status != 'null' ? search.status : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    var price = e.target.value != 'Default' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/category-search?name=";
    } else {
      var url = "/no/kategori-sok?name=";
    }
    if (!isMobile) {
      setTimeout(function () {
        window.location = url + name
          + "&category=" + category
          + "&price=" + price
          + "&status=" + status
          + "&country=" + country;
      }, 50);
    } else {
      query.price = e.target.value != 'Default' ? e.target.value : 'null';
    }
  });
  $(".status-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var category = search.category;
    var price = search.price != 'null' ? search.price : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    var status = e.target.value != 'All' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/category-search?name=";
    } else {
      var url = "/no/kategori-sok?name=";
    }
    if (!isMobile) {
      setTimeout(function () {
        window.location = url + name
          + "&category=" + category
          + "&price=" + price
          + "&status=" + status
          + "&country=" + country;
      }, 50);
    } else {
      query.status = e.target.value != 'All' ? e.target.value : 'null';
    }
  });
  $(".country-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var category = search.category;
    var status = search.status != 'null' ? search.status : 'null';
    var price = search.price != 'null' ? search.price : 'null';
    var country = e.target.value != 'All' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/category-search?name=";
    } else {
      var url = "/no/kategori-sok?name=";
    }
    if (!isMobile) {
      setTimeout(function () {
        window.location = url + name
          + "&category=" + category
          + "&price=" + price
          + "&status=" + status
          + "&country=" + country;
      }, 50);
    } else {
      query.country = e.target.value != 'All' ? e.target.value : 'null';
    }
  });
  $(".btn").click(function() {
    if (!is_login) {
      window.location = '/login';
    }
  });
  var init = function () {
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".inner-footer").attr('style', "background-image: url(/images/home/footer-mobile-bg.png)");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".inner-footer").attr('style', "background-image: url(/images/home/footer-background.png)");
      $(".customer-review").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        dots:true,
        arrows: false
      });
    }
    Object.values(countries).forEach((item) => {
      if (item != null) {
        $('.country-sel').append(`<option value="${item.toLowerCase()}">${item}</option>`);
      }
    });
    if (search.price != 'null') {
      $(".price-sel").val(search.price);
    }
    if (search.status != 'null') {
      $(".status-sel").val(search.status);
    }
    if (search.country != 'null') {
      $(".country-sel").val(search.country);
    }
  };
  init();
};

var gotoconsult = {
  Controllers: Controllers
};