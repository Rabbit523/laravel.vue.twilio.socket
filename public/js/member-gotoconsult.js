var Controllers = {};
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

Controllers.public = function (user) {
  $(".member-btn-country").click(function (e) {
    e.preventDefault();
    const href = window.location.href;
    const origin = window.location.origin;
    var url = href.replace(origin, '');
    if (lang == 'no') {
      if (url.includes('/no/finn-konsulent-sok')) {
        url = url.replace('/no/finn-konsulent-sok', 'find-consultant-search');
      }
      switch (url) {
        case '/no/oversikt':
          url = 'dashboard';
          break;
        case '/no/finn-konsulent':
          url = 'find-consultant';
          break;
        case '/no/moter':
          url = 'sessions';
          break;
        case '/no/lommebok':
          url = 'wallet';
          break;
        case '/no/transaksjoner':
          url = 'transactions';
          break;
        case '/no/profil':
          url = 'profile';
          break;
        case '/no/kontoinnstillinger':
          url = 'member-settings';
          break;
      }
    } else {
      if (url.includes('/find-consultant-search')) {
        url = url.replace('/find-consultant-search', 'finn-konsulent-sok');
      }
      switch (url) {
        case '/dashboard':
          url = 'oversikt';
          break;
        case '/find-consultant':
          url = 'finn-konsulent';
          break;
        case '/sessions':
          url = 'moter';
          break;
        case '/wallet':
          url = 'lommebok';
          break;
        case '/transactions':
          url = 'transaksjoner';
          break;
        case '/profile':
          url = 'profil';
          break;
        case '/member-settings':
          url = 'kontoinnstillinger';
          break;
      }
    }
    var new_lang = lang == 'en' ? 'no' : 'en';
    $(".member_selected_lang").val(new_lang);
    $(".member_current_address").val(url);
    $(".member-lang-form").trigger('submit');
  });
  $(".navbar-toggler").click(function () {
    $(".navbar-sidebar").addClass('collapsed');
    $(".navigation__nav").addClass('collapsed');
  });
  $(".navigation-toggler").click(function() {
    $(".navbar-sidebar").removeClass('collapsed');
    $(".navigation__nav").removeClass('collapsed');
  });
  var init = function () {
    $(".user-btn img").attr("src", user.profile.avatar);
    if (user.status != 'Offline') {
      $.ajax({
        url: '/api/manage_status',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: { id: user.id, status: 'Offline' },
        dataType: 'JSON',
        success: function (res) {
          console.log("status updated");
        }
      });
    }
  };
  init();
};

Controllers.findConsult = function (search, countries) {
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
      var category = query.category ? query.category : search.category != 'null' ? search.category : 'null';
      var status = query.status ? query.status :  search.status != 'null' ? search.status : 'null';
      var price = query.price ? query.price : search.price != 'null' ? search.price : 'null';
      var country = query.country ? query.country : search.country != 'All' ? e.target.value : 'null';
      if (lang == 'en') {
        var url = "/find-consultant-search?name=";
      } else {
        var url = "/no/finn-konsulent-sok?name=";
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
    var category = search.category != 'null' ? search.category : 'null';
    var price = search.price != 'null' ? search.price : 'null';
    var status = search.status != 'null' ? search.status : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    if (lang == 'en') {
      var url = "/find-consultant-search?name=";
    } else {
      var url = "/no/finn-konsulent-sok?name=";
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
      query.name  = e.target.value;
    }
  });
  $(".category-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var price = search.price != 'null' ? search.price : 'null';
    var status = search.status != 'null' ? search.status : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    var category = e.target.value != 'All' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/find-consultant-search?name=";
    } else {
      var url = "/no/finn-konsulent-sok?name=";
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
      query.category  = e.target.value != 'All' ? e.target.value : 'null';
    }
  });
  $(".price-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var category = search.category != 'null' ? search.category : 'null';
    var status = search.status != 'null' ? search.status : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    var price = e.target.value != 'Default' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/find-consultant-search?name=";
    } else {
      var url = "/no/finn-konsulent-sok?name=";
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
      query.price  = e.target.value != 'Default' ? e.target.value : 'null';
    }
  });
  $(".status-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var category = search.category != 'null' ? search.category : 'null';
    var price = search.price != 'null' ? search.price : 'null';
    var country = search.country != 'null' ? search.country : 'null';
    var status = e.target.value != 'All' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/find-consultant-search?name=";
    } else {
      var url = "/no/finn-konsulent-sok?name=";
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
      query.status  = e.target.value != 'All' ? e.target.value : 'null';
    }
  });
  $(".country-sel").on('change', function (e) {
    var name = search.name != 'null' ? search.name : 'null';
    var category = search.category != 'null' ? search.category : 'null';
    var status = search.status != 'null' ? search.status : 'null';
    var price = search.price != 'null' ? search.price : 'null';
    var country = e.target.value != 'All' ? e.target.value : 'null';
    if (lang == 'en') {
      var url = "/find-consultant-search?name=";
    } else {
      var url = "/no/finn-konsulent-sok?name=";
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
      query.country  = e.target.value != 'All' ? e.target.value : 'null';
    }
  });
  var init = function () {
    Object.values(countries).forEach((item) => {
      if (item != null) {
        $('.country-sel').append(`<option value="${item.toLowerCase()}">${item}</option>`);
      }
    });
    if (search.category != 'null') {
      $(".category-sel").val(search.category);
    }
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

Controllers.profile = function (user_info, review_info, chart_info) {
  var cover_image = user_info.profile ? user_info.profile.cover_img : '';
  var avatar_image = user_info.profile ? user_info.profile.avatar : '';

  init();
  function init() {
    if (cover_image) {
      $(".edit-cover-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${cover_image}')`);
      $(".cover-file").attr('style', 'display: none;');
    }
    if (avatar_image) {
      $(".preview-profile-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${avatar_image}')`);
      $(".preview-profile-photo img").attr('style', 'display: none;');
    }
    $(".profile-card.about").attr("style", "display: block;");
    $('.basic-form').validate({
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
    $.ajax({
      url: '/api/get-universities',
      type: 'GET',
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        data.array.forEach((item) => {
          $('.university-list').append(`<option value="${item.name}">${item.name}</option>`);
        });
        if (user_info.profile && user_info.profile.college) {
          $('.university-list').val(user_info.profile.college);
        }
      }
    });
    $("#timezone").timezones();
    $("#phone").intlTelInput({
      allowDropdown: true,
      autoHideDialCode: false,
      autoPlaceholder: "polite",
      dropdownContainer: "body",
      preferredCountries: ['no', 'se', 'gb', 'de', 'us'],
      utilsScript: "/js/utils.js"
    });
    if (user_info.profile && user_info.profile.from) {
      $("#from").attr('data-default-value', user_info.profile.from);
    }
    if (user_info.profile && user_info.profile.country) {
      $("#country").attr('data-default-value', user_info.profile.country);
    }
    if (user_info.profile && user_info.profile.region) {
      $("#region").attr('data-default-value', user_info.profile.region);
    }
    if (user_info.profile && user_info.profile.timezone) {
      $("#timezone").val(user_info.profile.timezone);
    }
    // completed session chart
    var columns = [];
    columns.push(['x', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
    var column_data = ['y'];
    var y_values = [];
    Object.keys(chart_info.completed_sessions).forEach((key, item) => {
      y_values.push(chart_info.completed_sessions[key]);
      column_data.push(chart_info.completed_sessions[key]);
    });
    columns.push(column_data);
    var maxValueInArray = Math.max.apply(Math, y_values);

    var chart = c3.generate({
      bindto: '#completed-session-chart',
      data: {
        x: 'x',
        columns: columns,
        type: 'bar',
        labels: true,
      },
      color: {
        linearGradient: {
          x1: 0,
          x2: 0,
          y1: 0,
          y2: 1
        },
        stops: [
          [0, '#8773ff'],
          [1, '#67a5ff']
        ]
      },
      bar: {
        width: { ratio: 0.8 }
      },
      axis: {
        x: {
          type: 'categories',
          tick: {
            format: "%b",
            fit: true
          }
        },
        y: {
          min: 0,
          max: maxValueInArray
        }
      },
      tooltip: {
        show: false
      },
      zoom: {
        enabled: false
      },
      onrendered: function () {
        let $graphic = $(".completed-session-chart svg g");
        $($graphic[0]).attr("style", "transform: translate(0, 0);");
        let $y_axis = $(".completed-session-chart .c3-axis-y");
        $($y_axis).attr("style", "display: none;");
        let $y2_axis = $(".completed-session-chart .c3-axis-y2");
        $($y2_axis).attr("style", "display: none;");
        let $legend_item_y = $(".completed-session-chart .c3-legend-item-y");
        $($legend_item_y).attr("style", "display: none;");
        let $path = $(".completed-session-chart path.domain");
        $($path).attr("style", "display: none;");
        let $x_axis = $(".completed-session-chart .c3-axis-x");
        $($x_axis).attr("style", "transform: translate(0, 230px);");
        let $x_axis_span = $(".completed-session-chart .c3-axis-x g text tspan");
        $($x_axis_span).attr("style", "font-family: 'Poppins Regular';");
        let $c3_shapes = $(".completed-session-chart .c3-shape");
        $($c3_shapes).attr("style", "fill: #e2e2e2; stroke: #e2e2e2; stroke-width: 5px;");
        var d = new Date(), n = d.getMonth();
        let $current_month_shape = $(`.completed-session-chart .c3-shape-${n}`);
        $($current_month_shape).attr('style', 'fill: url(#MyGradient); stroke: url(#MyGradient); stroke-width: 5px;');
      }
    });

    // resposne rate chart for consultant
    if (user.role == 'consultant') {
      var response_columns = [];
      response_columns.push(['x', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
      var response_column_data = ['y'];
      var response_y_values = [];
      Object.keys(chart_info.response_rates).forEach((key, item) => {
        response_y_values.push(chart_info.response_rates[key]);
        response_column_data.push(chart_info.response_rates[key]);
      });
      response_columns.push(response_column_data);
      var response_maxValueInArray = Math.max.apply(Math, response_y_values);
      var chart = c3.generate({
        bindto: '#response-rate-chart',
        data: {
          x: 'x',
          columns: response_columns,
          type: 'bar',
          labels: true,
        },
        color: {
          linearGradient: {
            x1: 0,
            x2: 0,
            y1: 0,
            y2: 1
          },
          stops: [
            [0, '#8773ff'],
            [1, '#67a5ff']
          ]
        },
        bar: {
          width: { ratio: 0.8 }
        },
        axis: {
          x: {
            type: 'categories',
            tick: {
              format: "%b",
              fit: true
            }
          },
          y: {
            min: 0,
            max: response_maxValueInArray
          }
        },
        tooltip: {
          show: false
        },
        zoom: {
          enabled: false
        },
        onrendered: function () {
          let $graphic = $(".response-rate-chart svg g");
          $($graphic[0]).attr("style", "transform: translate(0, 0);");
          let $y_axis = $(".response-rate-chart .c3-axis-y");
          $($y_axis).attr("style", "display: none;");
          let $y2_axis = $(".response-rate-chart .c3-axis-y2");
          $($y2_axis).attr("style", "display: none;");
          let $legend_item_y = $(".response-rate-chart .c3-legend-item-y");
          $($legend_item_y).attr("style", "display: none;");
          let $path = $(".response-rate-chart path.domain");
          $($path).attr("style", "display: none;");
          let $x_axis = $(".response-rate-chart .c3-axis-x");
          $($x_axis).attr("style", "transform: translate(0, 230px);");
          let $x_axis_span = $(".completed-session-chart .c3-axis-x g text tspan");
          $($x_axis_span).attr("style", "font-family: 'Poppins Regular';");
          let $c3_shapes = $(".response-rate-chart .c3-shape");
          $($c3_shapes).attr("style", "fill: #e2e2e2; stroke: #e2e2e2; stroke-width: 5px;");
          var d = new Date(), n = d.getMonth();
          let $current_month_shape = $(`.response-rate-chart .c3-shape-${n}`);
          $($current_month_shape).attr('style', 'fill: url(#MyGradient); stroke: url(#MyGradient); stroke-width: 5px;');
          let $text_elements = $(".response-rate-chart text.c3-text");
          $.each($text_elements, (i, el) => {
            $(el).text($(el).html() + '%');
          });
        }
      });
    }
    if (review_info) {
      $(".review").slice(0, 5).show();
      if ($(".blogBox:hidden").length != 0) {
        $("#loadMore").show();
      }
    }
  }
  $("#loadMore").on('click', function (e) {
    e.preventDefault();
    $(".review:hidden").slice(0, review_info.length).slideDown();
    if ($(".review:hidden").length == 0) {
      $("#loadMore").fadeOut('slow');
    }
  });
  $(".btn-edit-profile").click(function () {
    $("#edit-profile-modal").modal("show");
  });
  $('#edit-profile-modal').on("show.bs.modal", function () {
    $("#description").summernote({
      height: 200,
      dialogsInBody: true,
      codemirror: {
        htmlMode: true,
        mode: 'text/html'
      }
    });
    if (user_info.profile && user_info.profile.description) {
      $("#description").summernote('code', user_info.profile.description);
    }
  });
  // upload profile image
  $("#upload_cover").on('change', function () {
    var formdata = new FormData();
    if (cover_image) {
      formdata.append('file', this.files[0]);
      formdata.append('remove_url', cover_image);
    } else {
      formdata.append('file', this.files[0]);
    }
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        cover_image = e.url;
        $(".edit-cover-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${e.url}')`);
        $(".cover-file").attr('style', 'display: none;');
      }
    });
  });
  // check if cover photo div has background image or not
  $('.edit-cover-photo').mouseover(function () {
    if ($(this).css('background-image') != 'none') {
      $(".cover-file").attr('style', 'display: block;');
    }
  });
  $('.edit-cover-photo').mouseleave(function () {
    if ($(this).css('background-image') != 'none') {
      $(".cover-file").attr('style', 'display: none;');
    }
  });
  // upload profile photos
  $(".upload-profile-photo").click(function () {
    $("#upload_profile").trigger("click");
  });
  $("#upload_profile").on('change', function () {
    var formdata = new FormData();
    if (avatar_image) {
      formdata.append('file', this.files[0]);
      formdata.append('remove_url', avatar_image);
    } else {
      formdata.append('file', this.files[0]);
    }
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        avatar_image = e.url;
        $(".preview-profile-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${e.url}')`);
        $(".preview-profile-photo img").attr('style', 'display: none;');
      }
    });
  });
  // personal info updating
  $("#profile_save").click(function (e) {
    e.preventDefault();
    if ($('.basic-form').valid()) {
      var info = {
        user_id: user_info.user.id,
        cover_image: cover_image,
        avatar: avatar_image,
        first_name: $("#first_name").val(),
        last_name: $("#last_name").val(),
        phone: $("#phone").intlTelInput("getNumber"),
        email: $("#email").val(),
        profession: $(".profession").val(),
        from: $("#from").val(),
        country: $("#country").val(),
        region: $("#region").val(),
        college: $(".university-list").val(),
        timezone: $("#timezone").val(),
        description: $("#description").summernote('code')
      };
      $.ajax({
        url: '/api/update_member_profile',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: info,
        dataType: 'JSON',
        success: function (data) {
          $("#edit-profile-modal").modal("hide");
          location.reload();
        }
      });
    }
  });
  $(".tab.about").click(function(e) {
    e.preventDefault();
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".tab.about img").attr("src", "images/profile-icon-w.svg");
      $(".profile-card.about").attr("style", "display: block;");
    }
    $(".tab.sessions").removeClass("active");
    $(".tab.sessions img").attr("src", "images/comment.svg");
    $(".profile-card.sessions").attr("style", "display: none;");
    $(".tab.reviews").removeClass("active");
    $(".tab.reviews img").attr("src", "images/star.svg");
    $(".profile-card.reviews").attr("style", "display: none;");
  });
  $(".tab.sessions").click(function(e) {
    e.preventDefault();
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".tab.sessions img").attr("src", "images/comment-w.svg");
      $(".profile-card.sessions").attr("style", "display: block;");
    }
    $(".tab.about").removeClass("active");
    $(".tab.about img").attr("src", "images/profile-icon.svg");
    $(".profile-card.about").attr("style", "display: none;");
    $(".tab.reviews").removeClass("active");
    $(".tab.reviews img").attr("src", "images/star.svg");
    $(".profile-card.reviews").attr("style", "display: none;");
  });
  $(".tab.reviews").click(function(e) {
    e.preventDefault();
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $(".tab.reviews img").attr("src", "images/star-w.svg");
      $(".profile-card.reviews").attr("style", "display: block;");
    }
    $(".tab.about").removeClass("active");
    $(".tab.about img").attr("src", "images/profile-icon.svg");
    $(".profile-card.about").attr("style", "display: none;");
    $(".tab.sessions").removeClass("active");
    $(".tab.sessions img").attr("src", "images/comment.svg");
    $(".profile-card.sessions").attr("style", "display: none;");
  });
};

Controllers.setting = function (user_info) {
  init();
  // contact setting
  $("#contact_save").click(function () {
    var contact = {
      phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      currency: $("#selected-currency").val(),
      rate: $("#rate").val(),
      role: user_info.user.role,
      user_id: user_info.user.id,
      type: "contact"
    };
    $.ajax({
      url: '/api/update_member_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: contact,
      dataType: 'JSON',
      success: function (data) {
        alert("Updated successfully");
      }
    });
  });
  // company settings
  $("#company_save").click(function (e) {
    e.preventDefault();
    var company_info = {
      company_name: $("#company_name").val(),
      organization_number: $("#organization_number").val(),
      bank_account: $("#bank_account").val(),
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      address: $("#address").val(),
      zip_code: $("#zip_code").val(),
      zip_place: $("#zip_place").val(),
      country: $("#country").val(),
      role: user_info.user.role,
      user_id: user_info.user.id,
      type: "company"
    };
    $.ajax({
      url: '/api/update_member_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: company_info,
      dataType: 'JSON',
      success: function (data) {
        alert("Updated successfully");
      }
    });
  });
  //password updating
  $("#password_save").click(function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      user_id: user_info.user.id,
      type: 'password'
    };

    $.ajax({
      url: '/api/update_member_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: password_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (status == 1) {
          $("#old_password_error").attr('style', 'display: block;');
          $("#old_password_error").text('Enter the previous password correctly');
        } else {
          alert("Updated successfully");
        }
      }
    });
  });
  function init() {
    if (user_info.currency) {
      $("#selected-currency").val(user_info.currency);
    }
  }
};

Controllers.transaction = function (search) {
  var query = {};
  $(".search").on('change', function (e) {
    query.number  = e.target.value;
  });
  $("#consultant").on('change', function (e) {
    query.consultant  = $(this).val();
  });
  $("#date").on('change', function (e) {
    query.date  = e.target.value;
  });
  $("#filter").click(function () {
    var number = query.number ? query.number : search.number != 'null' ? search.number : 'null';
    var date = query.date ? query.date : search.date != 'null' ? search.date : 'null';
    var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
    if (lang == 'en') {
      var url = "/transaction-search?name=";
    } else {
      var url = "/no/transaksjon-sok?start=";
    }
    setTimeout(function () {
      window.location = url + number + "&consultant=" + consultant + "&date=" + date;
    }, 50);
  });
  var init = function() {
    $('#transactions').dynatable().bind('dynatable:afterProcess', processingComplete);
    $(".transaction.desktop table tbody tr").each(function() {
      $(this).find('td').addClass('table-item');
      $(this).find('td').eq(0).addClass('table-item avatar');
    });
    $("#date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18'
    });
  };
  var processingComplete = function(){
    $(".transaction.desktop table tbody tr").each(function() {
      $(this).find('td').addClass('table-item');
      $(this).find('td').eq(0).addClass('table-item avatar');
    });
  };
  init();
};

Controllers.wallet = function (amount, is_popup, currency, search) {
  var selected_cost = currency == 'NOK' ? 100 : 10;
  var symbol = currency == 'NOK' ? 'kr' : currency == 'USD' ? '$' : '€';
  var payment_type = 'credit';
  var button = document.querySelector('.sumbit-total');
  var mobile_pay_button = document.querySelector('.next-btn');
  var brain_cus_id = user.brain_cus_id || '';
  var is_filter = false;
  var query = {};
  // choose card
  $("#card1").click(function () {
    selected_cost = $('#card1 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card1").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card1') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $("#card2").click(function () {
    selected_cost = $('#card2 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card2").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card2') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $("#card3").click(function () {
    selected_cost = $('#card3 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card3").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card3') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $("#card4").click(function () {
    selected_cost = $('#card4 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card4").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card4') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $("#card5").click(function () {
    selected_cost = $('#card5 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card5").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card5') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $("#card6").click(function () {
    selected_cost = $('#card6 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card6").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card6') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $("#card7").click(function () {
    selected_cost = $('#card7 .cost').html();
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    if (!$("#card7").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card7') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  $(".choose-item.custom").click(function () {
    $(".choose-item.custom .custom").addClass("display-none");
    $(".choose-item.custom .credit").removeClass("display-none");

    if (!$("#card8").hasClass("active")) {
      $('.choose-group .choose-item .credit').filter(function () {
        return $(this).has('.cost').length > 0
      }).each(function () {
        if ($(this).attr('id') == 'card8') {
          $(this).addClass('active');
        } else {
          $(this).removeClass('active');
        }
      });
    }
  });
  $("#custom_card").on('change', function () {
    selected_cost = parseInt($(this).val());
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);

    $.ajax({
      url: '/api/klarna_checkout',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: { "price": selected_cost, "name": 'CUSTOMCARD' },
      dataType: 'JSON',
      success: function (res) {
        $(".klarna-checkout").html(res.html_snippet);
      }
    });
  });
  // get klarna html html_snippet
  $.ajax({
    url: '/api/klarna_checkout',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'POST',
    data: { "price": currency == 'NOK' ? 100 : 10, "name": currency == 'NOK' ? '100NOKCARD' : '10' + currency + 'CARD', 'currency': currency },
    dataType: 'JSON',
    success: function (res) {
      $(".klarna-checkout").html(res.html_snippet);
    }
  });
  // get braintree client token from backend
  $.ajax({
    url: '/api/brain_token',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'POST',
    dataType: 'JSON',
    data: { 'id': brain_cus_id },
    success: function (res) {
      braintree.dropin.create({
        authorization: res.token,
        container: '#dropin-container',
        locale: lang == 'en' ? 'en_US' : 'no_NO',
        vaultManager: true,
      }, function (createErr, instance) {
        if (createErr) {
          console.log('create Error', createErr);
          return;
        }
        $(".pay-cust-credit").removeClass("display-none");
        $(".credit-box").removeClass("display-none");
        button.addEventListener('click', function (event) {
          instance.requestPaymentMethod(function (err, payload) {
            if (err) {
              console.log('Request Payment Method Error', err);
              return;
            }
            var pay_info = {
              currency: currency,
              payment_method_nonce: payload.nonce,
              amount: selected_cost,
              checked: $("#save-card").not(':checked').length > 0,
              customerId: brain_cus_id,
              cardType: payload.details.cardType
            };
            $.ajax({
              url: '/api/credit_checkout',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              dataType: 'JSON',
              data: pay_info,
              success: function (res) {
                var calculated_charged_amount = 0;
                if (res.status == 'success') {
                  var endpoint = 'live';
                  var access_key = '8c479a455a6d8a2f5cccc8ce01819269';
                  if (res.transaction.currencyIsoCode == 'USD' || res.transaction.currencyIsoCode == 'EUR') {
                    $.ajax({
                      url: 'http://apilayer.net/api/' + endpoint + '?access_key=' + access_key,
                      dataType: 'jsonp',
                      success: function (json) {
                        if (res.transaction.currencyIsoCode == 'USD') {
                          calculated_charged_amount = (Math.round(res.transaction.amount * json.quotes.USDNOK * 100) / 100).toFixed(2);
                        } else if (res.transaction.currencyIsoCode == 'EUR') {
                          calculated_charged_amount = (Math.round(res.transaction.amount / json.quotes.USDNOK * json.quotes.USDNOK * 100) / 100).toFixed(2);
                        }
                        $.ajax({
                          url: '/api/balance_manage',
                          headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          type: 'POST',
                          dataType: 'JSON',
                          data: { balance: calculated_charged_amount },
                          success: function (res) {
                            $("#pay-modal-amount").html("<b>" + calculated_charged_amount + "kr</b>" + " have been added to your balance.");
                            $("#payment-confirmation").modal('show');
                          }
                        });
                      }
                    });
                  } else {
                    calculated_charged_amount = res.transaction.amount;
                    $.ajax({
                      url: '/api/balance_manage',
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      type: 'POST',
                      dataType: 'JSON',
                      data: { balance: calculated_charged_amount },
                      success: function (res) {
                        $("#pay-modal-amount").html("<b>" + calculated_charged_amount + "kr</b>" + " have been added to your balance.");
                        $("#payment-confirmation").modal('show');
                      }
                    });
                  }
                }
              }
            });
          });
        });
        mobile_pay_button.addEventListener('click', function (event) {
          instance.requestPaymentMethod(function (err, payload) {
            if (err) {
              console.log('Request Payment Method Error', err);
              return;
            }
            var pay_info = {
              currency: currency,
              payment_method_nonce: payload.nonce,
              amount: selected_cost,
              checked: $("#save-card").not(':checked').length > 0,
              customerId: brain_cus_id,
              cardType: payload.details.cardType
            };
            $.ajax({
              url: '/api/credit_checkout',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              dataType: 'JSON',
              data: pay_info,
              success: function (res) {
                var calculated_charged_amount = 0;
                if (res.status == 'success') {
                  var endpoint = 'live';
                  var access_key = '8c479a455a6d8a2f5cccc8ce01819269';
                  if (res.transaction.currencyIsoCode == 'USD' || res.transaction.currencyIsoCode == 'EUR') {
                    $.ajax({
                      url: 'http://apilayer.net/api/' + endpoint + '?access_key=' + access_key,
                      dataType: 'jsonp',
                      success: function (json) {
                        if (res.transaction.currencyIsoCode == 'USD') {
                          calculated_charged_amount = (Math.round(res.transaction.amount * json.quotes.USDNOK * 100) / 100).toFixed(2);
                        } else {
                          calculated_charged_amount = (Math.round(res.transaction.amount / json.quotes.USDNOK * json.quotes.USDNOK * 100) / 100).toFixed(2);
                        }
                        $.ajax({
                          url: '/api/balance_manage',
                          headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          type: 'POST',
                          dataType: 'JSON',
                          data: { balance: calculated_charged_amount },
                          success: function (res) {
                            $(".prepaid-card-left").attr('style', 'display: none;');
                            $(".mobile-wallet-payment").attr('style', 'display: none;');
                            $(".content-wrapper.member-content").attr('style', 'min-height:350px;');
                            var val = parseFloat(user.balance) + parseFloat(calculated_charged_amount);
                            $(".updated_balance").html(val + " NOK");
                            $(".mobile-step2").attr('style', 'display: flex;');
                            $(".mobile-wallet-transaction").attr('style', 'display: block;');
                          }
                        });
                      }
                    });                    
                  } else {
                    calculated_charged_amount = res.transaction.amount;
                    $.ajax({
                      url: '/api/balance_manage',
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      type: 'POST',
                      dataType: 'JSON',
                      data: { balance: calculated_charged_amount },
                      success: function (res) {
                        $(".prepaid-card-left").attr('style', 'display: none;');
                        $(".mobile-wallet-payment").attr('style', 'display: none;');
                        $(".content-wrapper.member-content").attr('style', 'min-height:350px;');
                        var val = parseFloat(user.balance) + parseFloat(calculated_charged_amount);
                        $(".updated_balance").html(val + " NOK");
                        $(".mobile-step2").attr('style', 'display: flex;');
                        $(".mobile-wallet-transaction").attr('style', 'display: block;');
                      }
                    });
                  }
                }
              }
            });
          });
        });
      });
    }
  });
  // choose card type
  $("input[name='card_type']").change(function (e) {
    payment_type = $(this).val();
    if ($(this).val() == "credit") {
      $(".pay-cust-credit").removeClass("display-none");
      $(".credit-box").removeClass("display-none");
      $(".pay-cust-klarna").addClass("display-none");
    } else {
      $(".pay-cust-credit").addClass("display-none");
      $(".credit-box").addClass("display-none");
      $(".pay-cust-klarna").removeClass("display-none");
    }
  });
  $(".filter-box.desktop").click(function () {
    is_filter = !is_filter;
    if (is_filter) {
      $('.filter-tag.desktop').attr('style', 'display: flex;');
    } else {
      $(".filter-tag.desktop").attr('style', 'display:none;');
    }
  });
  $(".filter-box.mobile").click(function () {
    is_filter = !is_filter;
    if (is_filter) {
      $('.filter-tag.mobile').attr('style', 'display: flex;');
    } else {
      $(".filter-tag.mobile").attr('style', 'display:none;');
    }
  });
  // search functionality
  $("#start_date").on('change', function(e) {
    query.start = e.target.value;
  });
  $("#end_date").on('change', function(e) {
    query.end = e.target.value;
  });
  $("#transaction_type").on('change', function(e) {
    query.type = e.target.value;
  });
  $("#go-search").click(function () {
    var start = query.start ? query.start : search.start != 'null' ? search.start : 'null';
    var end = query.end ? query.end : search.end != 'null' ? search.end : 'null';
    var type = query.type ? query.type : search.type != 'null' ? search.type : 'null';
    if (lang == 'en') {
      var url = "/wallet-search?start=";
    } else {
      var url = "/no/lommebok-sok?start=";
    }
    setTimeout(function () {
      window.location = url + start + "&type=" + type + "&end=" + end;
    }, 50);
  });
  $("#mobile_start_date").on('change', function(e) {
    query.start = e.target.value;
  });
  $("#mobile_end_date").on('change', function(e) {
    query.end = e.target.value;
  });
  $("#mobile_transaction_type").on('change', function(e) {
    query.type = e.target.value != 'All' ? e.target.value : 'null';
  });
  $("#mobile-go-search").click(function () {
    var start = query.start ? query.start : search.start != 'null' ? search.start : 'null';
    var end = query.end ? query.end : search.end != 'null' ? search.end : 'null';
    var type = query.type ? query.type : search.type != 'null' ? search.type : 'null';
    if (lang == 'en') {
      var url = "/wallet-search?start=";
    } else {
      var url = "/no/lommebok-sok?start=";
    }
    setTimeout(function () {
      window.location = url + start + "&type=" + type + "&end=" + end;
    }, 50);
  });
  $(".add-credit-btn").click(function() {
    $(".prepaid-card-left").attr('style', 'display: block;');
    $(".mobile-wallet-payment").attr('style', 'display: block;');
    $(".content-wrapper.member-content").attr('style', 'min-height:850px;');
    $(".mobile-step2").attr('style', 'display: none;');
    $(".mobile-wallet-transaction").attr('style', 'display: none;');
  });
  //init
  var init = function () {
    // set datatables
    $('#transaction-table').dynatable();
    $(".dynatable-search").attr('style', 'display:none;');
    $(".dynatable-per-page").attr('style', 'display:none;');
    // set selected credit cost default
    $('.selected-credit').html(symbol + selected_cost + ' ' + currency);
    $('.sumbit-total').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $('.next-btn').html('Pay ' + symbol + selected_cost + ' ' + currency);
    $("#start_date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18'
    });
    $("#end_date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18'
    });
    $("#mobile_start_date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18'
    });
    $("#mobile_end_date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18'
    });
    // show purchase complete popup
    if (is_popup == 'true') {
      var modal_amount = 0;
      var endpoint = 'live';
      var access_key = '8c479a455a6d8a2f5cccc8ce01819269';
      $.ajax({
        url: 'http://apilayer.net/api/' + endpoint + '?access_key=' + access_key,
        dataType: 'jsonp',
        success: function (json) {
          if (currency == 'USD') {
            modal_amount = (Math.round(amount * json.quotes.USDNOK * 100) / 100).toFixed(2);
          } else if (currency == 'EUR') {
            modal_amount = (Math.round(amount / json.quotes.USDNOK * json.quotes.USDNOK * 100) / 100).toFixed(2);
          } else {
            modal_amount = amount;
          }
          $("#pay-modal-amount").html("<b>" + modal_amount + "kr</b>" + " have been added to your balance.");
          $("#payment-confirmation").modal('show');
        }
      });
    }
    if (isMobile && (search.start != 'null' || search.end != 'null' || search.type != 'null')) {
      $(".prepaid-card-left").attr('style', 'display: none;');
      $(".mobile-wallet-payment").attr('style', 'display: none;');
      $(".content-wrapper.member-content").attr('style', 'min-height:350px;');
      $(".mobile-step2").attr('style', 'display: flex;');
      $(".mobile-wallet-transaction").attr('style', 'display: block;');
    }
  };
  init();
  $('body').scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".sticky").attr('style', 'top: 5px;');
    } else {
      $(".sticky").attr('style', 'top: 160px;');
    }
  });
};

var gotoconsult = {
  Controllers: Controllers
};