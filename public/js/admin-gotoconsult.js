var Controllers = {};

Controllers.public = function () {
  $(".admin-btn-country").click(function (e) {
    e.preventDefault();
    const href = window.location.href;
    const origin = window.location.origin;
    var url = href.replace(origin, '');
    if (lang == 'no') {
      switch (url) {
        case '/no/sider':
          url = 'pages';
          break;
        case '/no/opprett-side':
          url = 'create-page';
          break;
        case '/no/kunder':
          url = 'customers';
          break;
        case '/no/opprett-kunde':
          url = 'create-customer';
          break;
        case '/no/konsulenter':
          url = 'consultants';
          break;
        case '/no/opprett-konsulent':
          url = 'create-consultant';
          break;
        case '/no/kategorier':
          url = 'categories';
          break;
        case '/no/opprett-kategori':
          url = 'create-category';
          break;
        case '/no/innstillinger':
          url = 'settings';
          break;
      }
      if (url.includes('rediger-side')) {
        url = url.replace('/no/rediger-side', 'edit-page');
      } else if (url.includes('rediger-kunde')) {
        url = url.replace('/no/rediger-kunde', 'edit-customer');
      } else if (url.includes('rediger-konsulent')) {
        url = url.replace('/no/rediger-konsulent', 'edit-consultant');
      } else if (url.includes('rediger-kategori')) {
        url = url.replace('/no/rediger-kategori', 'edit-category');
      }
    } else {
      switch (url) {
        case '/pages':
          url = 'sider';
          break;
        case '/create-page':
          url = 'opprett-side';
          break;
        case '/customers':
          url = 'kunder';
          break;
        case '/create-customer':
          url = 'opprett-kunde';
          break;
        case '/consultants':
          url = 'konsulenter';
          break;
        case '/create-consultant':
          url = 'opprett-konsulent';
          break;
        case '/categories':
          url = 'kategorier';
          break;
        case '/create-category':
          url = 'opprett-kategori';
          break;
        case '/settings':
          url = 'innstillinger';
          break;
      }
      if (url.includes('edit-page')) {
        url = url.replace('/edit-page', 'rediger-side');
      } else if (url.includes('edit-customer')) {
        url = url.replace('/edit-customer', 'rediger-kunde');
      } else if (url.includes('edit-consultant')) {
        url = url.replace('/edit-consultant', 'rediger-konsulent');
      } else if (url.includes('edit-category')) {
        url = url.replace('/edit-category', 'rediger-kategori');
      }
    }
    var new_lang = lang == 'en' ? 'no' : 'en';
    $(".admin_selected_lang").val(new_lang);
    $(".admin_current_address").val(url);
    $(".admin-lang-form").trigger('submit');
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

Controllers.dashboard = function(search) {
  var query = {};
  $("#start_date").on('change', function(e) {
    query.start = e.target.value;
  });
  $("#end_date").on('change', function(e) {
    query.end = e.target.value;
  });
  $("#filter").click(function () {
    var start = query.start ? query.start : search.start != 'null' ? search.start : 'null';
    var end = query.end ? query.end : search.end != 'null' ? search.end : 'null';
    if (lang == 'en') {
      var url = "/dashboard-search?start=";
    } else {
      var url = "/no/dashboard-sok?start=";
    }
    setTimeout(function () {
      window.location = url + start + "&end=" + end;
    }, 50);
  });
  var init = function() {
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
    if (search.start != null) {
      $("#start_date").val(search.start);
    }
    if (search.end != null) {
      $("#end_date").val(search.end);
    }
  };
  init();
};

Controllers.categories = function () {
  $('#example').DataTable();
};
Controllers.createCategory = function () {
  $("#remove_photo").click(function () {
    $('.imageupload').imageupload();

    $('#imageupload-disable').on('click', function () {
      $('.imageupload').imageupload('disable');
      $(this).blur();
    });
    $('#imageupload-enable').on('click', function () {
      $('.imageupload').imageupload('enable');
      $(this).blur();
    });
    $('#imageupload-reset').on('click', function () {
      $('.imageupload').imageupload('reset');
      $(this).blur();
    });
  });
  $("#image_access").click(function () {
    if ($('#image_access').is(":checked")) {
      $("#checkbox_value").val(1);
    } else {
      $("#checkbox_value").val(0);
    }
  });
  $('#upload_form').on('submit', function (event) {
    event.preventDefault();
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_category',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          $('#message').css('display', 'block');
          $('#message').html(data.message);
          $('#message').addClass(data.class_name);
          $('#uploaded_image').html(data.uploaded_image);
          $('#message').hide(3000);
        }
      });
    } else {
      alert("Please complete profile setting first.");
    }
  });
  $("#profile_save").click(function () {
    var category = {
      category_name: $("#category_name").val(),
      category_url: $("#category_url").val(),
      category_description: $("#category_description").val(),
      type: "profile"
    };
    $.ajax({
      url: '/create_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: category,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#hidden_id").val(id);
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: 'meta'
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_category',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: meta_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (!status) {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            var id = JSON.stringify(data['id']);
            if (id != '') {
              $("#meta_title_error").hide();
              $("#meta_description_error").hide();
              alert("Meta data updated successfully");
            }
          }
        }
      });
    } else {
      alert("please complete profile setting first.");
    }
  });
};
Controllers.editCategory = function () {
  $("#remove_photo").click(function () {
    $(".file-tab").attr('style', "background: '';");
    $('.imageupload').imageupload();

    $('#imageupload-disable').on('click', function () {
      $('.imageupload').imageupload('disable');
      $(this).blur();
    });
    $('#imageupload-enable').on('click', function () {
      $('.imageupload').imageupload('enable');
      $(this).blur();
    });
    $('#imageupload-reset').on('click', function () {
      $('.imageupload').imageupload('reset');
      $(this).blur();
    });
  });

  $("#image_access").click(function () {
    if ($('#image_access').is(":checked")) {
      $("#checkbox_value").val(1);
    } else {
      $("#checkbox_value").val(0);
    }
  });

  $('#upload_form').on('submit', function (event) {
    event.preventDefault();
    $.ajax({
      url: '/update_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: new FormData(this),
      dataType: 'JSON',
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        $('#message').css('display', 'block');
        $('#message').html(data.message);
        $('#message').addClass(data.class_name);
        $('#uploaded_image').html(data.uploaded_image);
        $('#message').hide(3000);
      }
    });
  });

  $("#profile_save").click(function () {
    var category = {
      category_name: $("#category_name").val(),
      category_name_no: $("#category_name_no").val(),
      category_url: $("#category_url").val(),
      category_description: $("#category_description").val(),
      category_description_no: $("#category_description_no").val(),
      hidden_id: $("#hidden_id").val(),
      type: "profile"
    };
    $.ajax({
      url: '/update_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: category,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Category updated successfully");
        }
      }
    });
  });

  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: 'meta'
    };
    $.ajax({
      url: '/update_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (!status) {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta data updated successfully");
        }
      }
    });
  });
};

Controllers.consultants = function () {
  $('#example').DataTable();
};
Controllers.createConsultant = function () {
  $("#image_access").click(function () {
    if ($('#image_access').is(":checked")) {
      $("#checkbox_value").val(1);
    } else {
      $("#checkbox_value").val(0);
    }
  });
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
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
        if (e.status) {
          $("#avatar").attr('src', e.url);
          $("#avatar_file").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#profile_save").click(function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      email: $("#email").val(),
      phone: $("#phone").val(),
      industry_expertise: $("#industry_expertise").val(),
      prof_image: $("#avatar_file").val(),
      image_access: $("#check_box").val(),
      type: 'profile'
    };
    $.ajax({
      url: '/create_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          $("#hidden_id").val(id);
          $("#profile_save").prop("disabled", true);
          alert("A consultant is added successfully");
        }
      }
    });
  });
  $("#contact_save").click(function () {
    var contact = {
      phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      hidden_id: $("#hidden_id").val(),
      type: "contact"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_consultant',
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
    } else {
      alert("Please save page setting first");
    }
  });
  $("#invoice_save").click(function () {
    var invoice = {
      company_name: $("#company_name").val(),
      invoice_mail: $("#invoice_mail").val(),
      invoice_first_name: $("#company_first_name").val(),
      invoice_last_name: $("#company_last_name").val(),
      address: $("#address").val(),
      zip_code: $("#zip_code").val(),
      zip_place: $("#zip_place").val(),
      hidden_id: $("#hidden_id").val(),
      type: "invoice"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_consultant',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: invoice,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            $("#company_name_error").hide();
            $("#invoice_mail_error").hide();
            $("#company_first_name_error").hide();
            $("#company_last_name_error").hide();
            $("#address_error").hide();
            $("#zip_code_error").hide();
            $("#zip_place_error").hide();
            alert("Updated successfully");
          }
        }
      });
    } else {
      alert("Please save page setting first");
    }

  });
  $("#password_save").click(function () {
    var password_info = {
      confirm_password: $("#confirm_password").val(),
      password: $("#password").val(),
      hidden_id: $("#hidden_id").val(),
      type: "password"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_consultant',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: password_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 1) {
            $("#confirm_password_error").show();
            $("#confirm_password_error").text('Enter Correct Password');
          } else {
            $("#confirm_password_error").hide();
            $("#password_error").hide();
            alert("Updated successfully");
          }
        }
      });
    } else {
      alert("Please save page setting first");
    }
  });
};
Controllers.editConsultant = function (consultant) {
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
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
        if (e.status) {
          $("#avatar").attr('src', e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#image_save").click(function () {
    var data = {
      prof_img: $("#avatar").attr('src'),
      image_access: $("#checkbox_value").val(),
      hidden_id: consultant.id,
      type: 'image'
    };
    $.ajax({
      url: '/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: data,
      dataType: 'JSON',
      success: function (data) {
        alert("Pages updated successfully");
      }
    });
  });
  $("#profile_save").click(function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      phone: $("#phone").val(),
      industry_expertise: $("#industry_expertise").val(),
      hidden_id: consultant.unique_id,
      type: 'profile'
    };
    $.ajax({
      url: '/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#first_name_error").hide();
            $("#last_name_error").hide();
            $("#email_error").hide();
            $("#phone_error").hide();
            $("#industry_expertise_error").hide();
            alert("Pages updated successfully");
          }
        }
      }
    });
  });
  $("#contact_save").click(function () {
    var contact = {
      phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      hidden_id: consultant.unique_id,
      type: "contact"
    };
    $.ajax({
      url: '/update_consultant',
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
  $("#invoice_save").click(function () {
    var invoice = {
      company_name: $("#company_name").val(),
      invoice_mail: $("#invoice_mail").val(),
      company_first_name: $("#company_first_name").val(),
      company_last_name: $("#company_last_name").val(),
      address: $("#address").val(),
      zip_code: $("#zip_code").val(),
      zip_place: $("#zip_place").val(),
      hidden_id: consultant.unique_id,
      type: "invoice"
    };
    $.ajax({
      url: '/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: invoice,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          $("#company_name_error").hide();
          $("#invoice_mail_error").hide();
          $("#company_first_name_error").hide();
          $("#company_last_name_error").hide();
          $("#address_error").hide();
          $("#zip_code_error").hide();
          $("#zip_place_error").hide();
        }
      }
    });
  });
  $("#password_save").click(function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      hidden_id: consultant.unique_id,
      type: 'password'
    };

    $.ajax({
      url: '/update_consultant',
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
};

Controllers.customers = function () {
  $('#example').DataTable();
};
Controllers.createCustomer = function () {
  $("#image_access").click(function () {
    if ($('#image_access').is(":checked")) {
      $("#checkbox_value").val(1);
    } else {
      $("#checkbox_value").val(0);
    }
  });
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
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
        if (e.status) {
          $("#avatar").attr('src', e.url);
          $("#avatar_file").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#profile_save").click(function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      email: $("#email").val(),
      phone: $("#phone").val(),
      industry_expertise: $("#industry_expertise").val(),
      prof_image: $("#avatar_file").val(),
      image_access: $("#check_box").val(),
      type: 'profile'
    };
    $.ajax({
      url: '/create_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          $("#hidden_id").val(id);
          $("#profile_save").prop("disabled", true);
          alert("A customer is added successfully");
        }
      }
    });
  });
  $("#contact_save").click(function () {
    var contact = {
      phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      hidden_id: $("#hidden_id").val(),
      type: "contact"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_customer',
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
    } else {
      alert("Please save page setting first");
    }
  });
  $("#invoice_save").click(function () {
    var invoice = {
      company_name: $("#company_name").val(),
      invoice_mail: $("#invoice_mail").val(),
      invoice_first_name: $("#company_first_name").val(),
      invoice_last_name: $("#company_last_name").val(),
      address: $("#address").val(),
      zip_code: $("#zip_code").val(),
      zip_place: $("#zip_place").val(),
      hidden_id: $("#hidden_id").val(),
      type: "invoice"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_customer',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: invoice,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            $("#company_name_error").hide();
            $("#invoice_mail_error").hide();
            $("#company_first_name_error").hide();
            $("#company_last_name_error").hide();
            $("#address_error").hide();
            $("#zip_code_error").hide();
            $("#zip_place_error").hide();
            alert("Updated successfully");
          }
        }
      });
    } else {
      alert("Please save page setting first");
    }

  });
  $("#password_save").click(function () {
    var password_info = {
      confirm_password: $("#confirm_password").val(),
      password: $("#password").val(),
      hidden_id: $("#hidden_id").val(),
      type: "password"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_customer',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: password_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 1) {
            $("#confirm_password_error").show();
            $("#confirm_password_error").text('Enter Correct Password');
          } else {
            $("#confirm_password_error").hide();
            $("#password_error").hide();
            alert("Updated successfully");
          }
        }
      });
    } else {
      alert("Please save page setting first");
    }
  });
};
Controllers.editCustomer = function (customer) {
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
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
        if (e.status) {
          $("#avatar").attr('src', e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#image_save").click(function () {
    var data = {
      prof_img: $("#avatar").attr('src'),
      image_access: $("#checkbox_value").val(),
      hidden_id: customer.id,
      type: 'image'
    };
    $.ajax({
      url: '/update_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: data,
      dataType: 'JSON',
      success: function (data) {
        alert("Pages updated successfully");
      }
    });
  });
  $("#profile_save").click(function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      phone: $("#phone").val(),
      industry_expertise: $("#industry_expertise").val(),
      hidden_id: customer.unique_id,
      type: 'profile'
    };
    $.ajax({
      url: '/update_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#first_name_error").hide();
            $("#last_name_error").hide();
            $("#email_error").hide();
            $("#phone_error").hide();
            $("#industry_expertise_error").hide();
            alert("Pages updated successfully");
          }
        }
      }
    });
  });
  $("#contact_save").click(function () {
    var contact = {
      phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      hidden_id: customer.unique_id,
      type: "contact"
    };
    $.ajax({
      url: '/update_customer',
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
  $("#invoice_save").click(function () {
    var invoice = {
      company_name: $("#company_name").val(),
      invoice_mail: $("#invoice_mail").val(),
      invoice_first_name: $("#company_first_name").val(),
      invoice_last_name: $("#company_last_name").val(),
      address: $("#address").val(),
      zip_code: $("#zip_code").val(),
      zip_place: $("#zip_place").val(),
      hidden_id: customer.unique_id,
      type: "invoice"
    };
    $.ajax({
      url: '/update_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: invoice,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          $("#company_name_error").hide();
          $("#invoice_mail_error").hide();
          $("#company_first_name_error").hide();
          $("#company_last_name_error").hide();
          $("#address_error").hide();
          $("#zip_code_error").hide();
          $("#zip_place_error").hide();
          alert("Updated successfully");
        }
      }
    });
  });
  $("#password_save").click(function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      hidden_id: customer.unique_id,
      type: 'password'
    };

    $.ajax({
      url: '/update_customer',
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
};

Controllers.page = function () {
  $('#example').DataTable();
};
Controllers.createPage = function () {
  $("#page_save").click(function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      type: "page"
    };
    if ($("#hidden_id").val() == '') {
      $.ajax({
        url: '/create_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: page_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            var id = JSON.stringify(data['id']);
            if (id != '') {
              $("#hidden_id").val(id);
              alert("Page is created successfully");
            }
          }
        }
      });
    } else {
      var page_info = {
        page_name: $("#page_name").val(),
        page_url: $("#page_url").val(),
        hidden_id: $("#hidden_id").val(),
        type: "page"
      };
      $.ajax({
        url: '/update_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: page_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            alert("Updated successfully");
          }
        }
      });
    }
  });
  $("#page_body_save").click(function () {
    var body_info = {
      page_body: $("#page_body").summernote('code'),
      hidden_id: $("#hidden_id").val(),
      type: "page_body"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: body_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            $("#hidden_id").val(data['id']);
            alert("Page Body updated successfully");
          }
        }
      });
    } else {
      alert("Complete page setting first!");
    }
  });
  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/create_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: meta_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            alert("Meta Data updated successfully");
            $("#meta_title_error").hide();
            $("#meta_description_error").hide();
          }
        }
      });
    } else {
      alert("Complete page setting first!");
    }
  });
  var init = function () {
    $("#page_body").summernote({ height: 300 });
  };
  init();
};
Controllers.editPage = function () {
  $("#page_save").click(function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  //Home page functions
  $("#en_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "en_header",
      page_body: {
        "title": $("#header_en_title").val(),
        "description": $("#header_en_description").val(),
        "button_title1": $("#header_en_button1").val(),
        "button_link1": $("#header_en_button_link1").val(),
        "button_title2": $("#header_en_button2").val(),
        "button_link2": $("#header_en_button_link2").val()
      }
    };
    if (body_info.hidden_id == 2) {
      body_info.page_body.description = $("#header_en_des").val();
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Header English part is updated successfully");
      }
    });
  });
  $("#no_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "no_header",
      page_body: {
        "title": $("#header_no_title").val(),
        "description": $("#header_no_description").val(),
        "button_title1": $("#header_no_button1").val(),
        "button_link1": $("#header_no_button_link1").val(),
        "button_title2": $("#header_no_button2").val(),
        "button_link2": $("#header_no_button_link2").val()
      }
    };
    if (body_info.hidden_id == 2) {
      body_info.page_body.description = $("#header_no_des").val();
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Header Norwegian part is updated successfully");
      }
    });
  });
  $(".help_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('id');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_home_help_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#help_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#home_help_add").click(function () {
    var key = $(".help-group .panel").length;
    var new_item = "<div class='panel panel-default' id='home_help_panel" + key + "'><a class='remove_help_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#help_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='help_en_title" + key + "'></div></div>";
    new_item += "<div id='help_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='help_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='help_path" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='help_en_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='help_no_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='help_no_des" + key + "'></textarea><br><label>Button Link</label><input type='text' id='help_button_link" + key + "'><br><label>Button Title (English)</label><input type='text' id='help_en_btn_title" + key + "'><br><label>Button Title (Norwegian)</label><input type='text' id='help_no_btn_title" + key + "'></div></div></div>";
    $(".help-group").append(new_item);
  });
  $("#home_help_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "help_list",
      page_body: []
    };
    var count = $(".help-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#help_path" + i).val(),
        en_title: $("#help_en_title" + i).val(),
        no_title: $("#help_no_title" + i).val(),
        en_des: $("#help_en_des" + i).val(),
        no_des: $("#help_no_des" + i).val(),
        button_link: $("#help_button_link" + i).val(),
        en_button_title: $("#help_en_btn_title" + i).val(),
        no_button_title: $("#help_no_btn_title" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.help-group').on('click', '.remove_help_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "help_list",
      page_body: []
    };
    var key = $(this).data('key');
    $('#home_help_panel' + key).remove();
    var count = $(".help-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#help_path" + i).val(),
        en_title: $("#help_en_title" + i).val(),
        no_title: $("#help_no_title" + i).val(),
        en_des: $("#help_en_des" + i).val(),
        no_des: $("#help_no_des" + i).val(),
        button_link: $("#help_button_link" + i).val(),
        en_button_title: $("#help_en_btn_title" + i).val(),
        no_button_title: $("#help_no_btn_title" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".benefit_title_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "benefit_title",
      page_body: {
        en: $("#en_benefit_title").val(),
        no: $("#no_benefit_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Consult Available part is updated successfully");
      }
    });
  });
  $(".icon_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_home_benefit_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#benefit_icon" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#home_benefit_add").click(function () {
    var key = $(".benefit-group .panel").length;
    var new_item = "<div class='panel panel-default' id='home_benefit_panel" + key + "'><a class='remove_benefit_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#benefit_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='benefit_en_title'><br></div></div>";
    new_item += "<div id='benefit_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='icon_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='benefit_icon" + key + "'><label>Title (Norwegian)</label><input type='text' id='benefit_no_title" + key + "'><br><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='benefit_en_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='benefit_no_des" + key + "'></textarea></div></div></div>";
    $(".benefit-group").append(new_item);
  });
  $("#home_benefit_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "benefit_arr",
      page_body: []
    };
    var count = $(".benefit-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#benefit_icon" + i).val(),
        en_title: $("#benefit_en_title" + i).val(),
        no_title: $("#benefit_no_title" + i).val(),
        en_des: $("#benefit_en_des" + i).val(),
        no_des: $("#benefit_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.benefit-group').on('click', '.remove_benefit_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "benefit_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#home_benefit_panel' + key).remove();
    var count = $(".benefit-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#benefit_icon" + i).val(),
        en_title: $("#benefit_en_title" + i).val(),
        no_title: $("#benefit_no_title" + i).val(),
        en_des: $("#benefit_en_des" + i).val(),
        no_des: $("#benefit_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".review_title_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_title",
      page_body: {
        en: $("#en_review_title").val(),
        no: $("#no_review_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Review Title is updated successfully");
      }
    });
  });
  $(".user_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_home_review_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#review_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#home_footer_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "footer",
      page_body: {
        "en_title": $("#home_footer_en_title").val(),
        "no_title": $("#home_footer_no_title").val(),
        "en_des": $("#home_footer_en_des").val(),
        "no_des": $("#home_footer_no_des").val(),
        "en_btn_title1": $("#home_footer_en_btn_title1").val(),
        "en_btn_link1": $("#home_footer_en_btn_link1").val(),
        "no_btn_title1": $("#home_footer_no_btn_title1").val(),
        "no_btn_link1": $("#home_footer_no_btn_link1").val(),
        "en_btn_title2": $("#home_footer_en_btn_title2").val(),
        "en_btn_link2": $("#home_footer_en_btn_link2").val(),
        "no_btn_title2": $("#home_footer_no_btn_title2").val(),
        "no_btn_link2": $("#home_footer_no_btn_link2").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Category single page functions
  $(".category_title_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "category_title",
      page_body: {
        "en": $("#en_category_title").val(),
        "no": $("#no_category_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".cat_review_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_home_review_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#cat_review_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#cat_review_add").click(function () {
    var key = $(".cat-review-group .panel").length;
    var new_item = "<div class='panel panel-default' id='cat_review_panel" + key + "'><a class='remove_review_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#cat_review_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='cat_author" + key + "'></div></div>";
    new_item += "<div id='cat_review_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='cat_review_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='cat_review_path" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='cat_review_en_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='cat_review_no_des" + key + "'></textarea></div></div></div>";
    $(".cat-review-group").append(new_item);
  });
  $("#cat_review_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var count = $(".cat-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#cat_review_path" + i).val(),
        en_des: $("#cat_review_en_des" + i).val(),
        no_des: $("#cat_review_no_des" + i).val(),
        name: $("#cat_author" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.cat-review-group').on('click', '.remove_review_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#cat_review_panel' + key).remove();
    var count = $(".cat-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#cat_review_path" + i).val(),
        en_des: $("#cat_review_en_des" + i).val(),
        no_des: $("#cat_review_no_des" + i).val(),
        name: $("#cat_author" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Become consultant page functions
  $(".main_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#platform_main_image").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".consultant_platform_title_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "platform_title",
      page_body: {
        "en": $("#en_platform_title").val(),
        "no": $("#no_platform_title").val(),
        "plat_img": $("#platform_main_image").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".become_consult_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#become_consult_icon" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#platform_add").click(function () {
    var key = $(".platform-group .panel").length;
    var new_item = "<div class='panel panel-default' id='platform_panel" + key + "'><a class='remove_plat_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#plat_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='en_platform_item_title" + key + "'></div></div>";
    new_item += "<div id='plat_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='become_consult_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='become_consult_icon" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='en_platform_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='no_platform_item_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_platform_des" + key + "'></textarea></div></div></div>";
    $(".platform-group").append(new_item);
  });
  $("#become_plat_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "become_consult_arr",
      page_body: []
    };
    var count = $(".platform-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#become_consult_icon" + i).val(),
        en_des: $("#en_platform_des" + i).val(),
        no_des: $("#no_platform_des" + i).val(),
        en_title: $("#en_platform_item_title" + i).val(),
        no_title: $("#no_platform_item_title" + i).val(),
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.platform-group').on('click', '.remove_plat_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "become_consult_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#platform_panel' + key).remove();
    var count = $(".platform-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#become_consult_icon" + i).val(),
        en_des: $("#en_platform_des" + i).val(),
        no_des: $("#no_platform_des" + i).val(),
        en_title: $("#en_platform_item_title" + i).val(),
        no_title: $("#no_platform_item_title" + i).val(),
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".become_review_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_home_review_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#become_review_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#become_review_add").click(function () {
    var key = $(".become-review-group .panel").length;
    var new_item = "<div class='panel panel-default' id='become_review_panel" + key + "'><a class='remove_review_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#become_review_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='become_author" + key + "'></div></div>";
    new_item += "<div id='become_review_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='become_review_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='become_review_path" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='become_review_en_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='become_review_no_des" + key + "'></textarea></div></div></div>";
    $(".become-review-group").append(new_item);
  });
  $("#become_review_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var count = $(".become-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#become_review_path" + i).val(),
        en_des: $("#become_review_en_des" + i).val(),
        no_des: $("#become_review_no_des" + i).val(),
        name: $("#become_author" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.become-review-group').on('click', '.remove_review_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#become_review_panel' + key).remove();
    var count = $(".become-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#become_review_path" + i).val(),
        en_des: $("#become_review_en_des" + i).val(),
        no_des: $("#become_review_no_des" + i).val(),
        name: $("#become_author" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".become_register_title_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "register_title",
      page_body: {
        "en": $("#en_become_register_title").val(),
        "no": $("#no_become_register_title").val(),
        "en_des": $("#en_become_register_des_title").val(),
        "no_des": $("#no_become_register_des_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $("#become_register_add").click(function () {
    var key = $(".become-register-group .panel").length;
    var new_item = "<div class='panel panel-default' id='become_register_panel" + key + "'><a class='remove_register_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#become_register_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span></div></div>";
    new_item += "<div id='become_register_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='en_become_register_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_become_register_des" + key + "'></textarea></div></div></div>";
    $(".become-register-group").append(new_item);
  });
  $("#become_register_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "register_arr",
      page_body: []
    };
    var count = $(".become-register-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_des: $("#en_become_register_des" + i).val(),
        no_des: $("#no_become_register_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.become-register-group').on('click', '.remove_register_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "register_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#become_register_panel' + key).remove();
    var count = $(".become-register-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_des: $("#en_become_register_des" + i).val(),
        no_des: $("#no_become_register_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // About us page functions
  $(".article_title_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "article_title",
      page_body: {
        "en": $("#en_article_title").val(),
        "no": $("#no_article_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".article_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#article_icon" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#about_article_add").click(function () {
    var key = $(".article-group .panel").length;
    var new_item = "<div class='panel panel-default' id='about_article_panel" + key + "'><a class='remove_article_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#article_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='article_en_title" + key + "'></div></div>";
    new_item += "<div id='article_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='article_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='article_icon" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='article_en_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='article_no_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='article_no_des" + key + "'></textarea></div></div></div>";
    $(".article-group").append(new_item);
  });
  $("#about_article_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "article_arr",
      page_body: []
    };
    var count = $(".article-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#article_icon" + i).val(),
        en_title: $("#article_en_title" + i).val(),
        no_title: $("#article_no_title" + i).val(),
        en_des: $("#article_en_des" + i).val(),
        no_des: $("#article_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.article-group').on('click', '.remove_article_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "article_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#about_article_panel' + key).remove();
    var count = $(".article-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#article_icon" + i).val(),
        en_title: $("#article_en_title" + i).val(),
        no_title: $("#article_no_title" + i).val(),
        en_des: $("#article_en_des" + i).val(),
        no_des: $("#article_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".story_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#story_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#about_story_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "story",
      page_body: {
        "en_part_title": $("#en_part_title").val(),
        "no_part_title": $("#no_part_title").val(),
        "en_title": $("#en_story_title").val(),
        "no_title": $("#no_story_title").val(),
        "en_des": $("#en_story_des").val(),
        "no_des": $("#no_story_des").val(),
        "path": $("#story_path").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Story part is updated successfully");
      }
    });
  });
  $(".team_member_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#team_member_avatar" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".about_team_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "team_title",
      page_body: {
        "en_part_title": $("#en_team_part_title").val(),
        "no_part_title": $("#no_team_part_title").val(),
        "en_title": $("#en_team_title").val(),
        "no_title": $("#no_team_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Team header is updated successfully");
      }
    });
  });
  $("#about_team_add").click(function () {
    var key = $(".team-group .panel").length;
    var new_item = "<div class='panel panel-default' id='about_team_panel" + key + "'><a class='remove_team_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#team_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='team_name" + key + "'></div></div>";
    new_item += "<div id='team_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='team_member_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='team_member_avatar" + key + "'><label>Job (English)</label><input type='text' id='en_team_job" + key + "'><br><label>Job (Norwegian)</label><input type='text' id='no_team_job" + key + "'><br><label>Bio (English)</label><textarea rows='5' cols='150' class='form-control' id='en_team_bio" + key + "'></textarea><br><label>Bio (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_team_bio" + key + "'></textarea></div></div></div>";
    $(".team-group").append(new_item);
  });
  $("#about_team_member_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "team_arr",
      page_body: []
    };
    var count = $(".team-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        avatar: $("#team_member_avatar" + i).val(),
        name: $("#team_member_name" + i).val(),
        en_bio: $("#en_team_bio" + i).val(),
        no_bio: $("#no_team_bio" + i).val(),
        en_job: $("#en_team_job" + i).val(),
        no_job: $("#no_team_job" + i).val(),
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.team-group').on('click', '.remove_team_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "team_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#about_team_panel' + key).remove();
    var count = $(".team-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        avatar: $("#team_member_avatar" + i).val(),
        name: $("#team_member_name" + i).val(),
        en_bio: $("#en_team_bio" + i).val(),
        no_bio: $("#no_team_bio" + i).val(),
        en_job: $("#en_team_job" + i).val(),
        no_job: $("#no_team_job" + i).val(),
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".about_get_started_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "get_started_title",
      page_body: {
        en: $("#en_get_started_title").val(),
        no: $("#no_get_started_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Get started part is updated successfully");
      }
    });
  });
  $("#about_started_add").click(function () {
    var key = $(".started-group .panel").length;
    var new_item = "<div class='panel panel-default' id='about_started_panel" + key + "'><a class='remove_started_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#started_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='started_en_title" + key + "'></div></div>";
    new_item += "<div id='started_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='started_en_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='started_no_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='started_no_des" + key + "'></textarea></div></div></div>";
    $(".started-group").append(new_item);
  });
  $("#about_started_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "get_started_arr",
      page_body: []
    };
    var count = $(".started-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_title: $("#started_en_title" + i).val(),
        no_title: $("#started_no_title" + i).val(),
        en_des: $("#started_en_des" + i).val(),
        no_des: $("#started_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.started-group').on('click', '.remove_started_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "get_started_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#about_started_panel' + key).remove();
    var count = $(".started-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_title: $("#started_en_title" + i).val(),
        no_title: $("#started_no_title" + i).val(),
        en_des: $("#started_en_des" + i).val(),
        no_des: $("#started_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Register page functions
  $("#register_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "en_des": $("#register_header_en_des").val(),
        "no_des": $("#register_header_no_des").val(),
        "en_title": $("#register_header_en_title").val(),
        "no_title": $("#register_header_no_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Register header part is updated successfully");
      }
    });
  });
  $(".register_item_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#register_item_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#register_list_add").click(function () {
    var key = $(".register-item-group .panel").length;
    var new_item = "<div class='panel panel-default' id='register_panel" + key + "'><a class='remove_register_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#reg_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='register_item_en_text" + key + "'></div></div>";
    new_item += "<div id='reg_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='register_item_file' data-key='" + key + "' accept='image/*'><br><input type='hidden' id='register_item_path" + key + "'><label>Text (Norwegian)</label><input type='text' id='register_item_no_text" + key + "'></div></div></div>";
    $(".register-item-group").append(new_item);
  });
  $('.register-item-group').on('click', '.remove_register_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "list",
      page_body: []
    };
    var key = $(this).data('key');
    $('#register_panel' + key).remove();
    var count = $(".register-item-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#register_item_path" + i).val(),
        en_title: $("#register_item_en_title" + i).val(),
        no_title: $("#register_item_no_title" + i).val(),
        en_txt: $("#register_item_en_text" + i).val(),
        no_txt: $("#register_item_no_text" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("List item is updated successfully");
      }
    });
  });
  $("#register_item_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "list",
      page_body: []
    };
    var count = $(".register-item-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#register_item_path" + i).val(),
        en_title: $("#register_item_en_title" + i).val(),
        no_title: $("#register_item_no_title" + i).val(),
        en_txt: $("#register_item_en_text" + i).val(),
        no_txt: $("#register_item_no_text" + i).val()
      });
    }
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("List item is updated successfully");
      }
    });
  });
  //Login page functions
  $(".login_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#login_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#login_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#login_path").val(),
        "en_des": $("#login_header_en_des").val(),
        "no_des": $("#login_header_no_des").val(),
        "en_title": $("#login_header_en_title").val(),
        "no_title": $("#login_header_no_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Login part is updated successfully");
      }
    });
  });
  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
};

Controllers.editPrivacy = function (en_content, no_content) {
  $("#page_save").click(function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".privacy_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#privacy_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#privacy_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#privacy_path").val(),
        "en_des": $("#privacy_header_en_des").val(),
        "no_des": $("#privacy_header_no_des").val(),
        "en_title": $("#privacy_header_en_title").val(),
        "no_title": $("#privacy_header_no_title").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#privacy_page_body_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "contents",
      page_body: {
        "en": $("#en_privacy_page_body").summernote('code'),
        "no": $("#no_privacy_page_body").summernote('code')
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  var init = function () {
    $("#en_privacy_page_body").summernote({ height: 300 });
    $("#en_privacy_page_body").summernote('code', en_content);
    $("#no_privacy_page_body").summernote({ height: 300 });
    $("#no_privacy_page_body").summernote('code', no_content);
  };
  init();
};
Controllers.editTermsCustomer = function (en_content, no_content) {
  $("#page_save").click(function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".terms_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#terms_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#terms_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#terms_path").val(),
        "en_des": $("#terms_header_en_des").val(),
        "no_des": $("#terms_header_no_des").val(),
        "en_title": $("#terms_header_en_title").val(),
        "no_title": $("#terms_header_no_title").val(),
        "link": $("#terms_header_link").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#terms_page_body_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "contents",
      page_body: {
        "en": $("#en_terms_page_body").summernote('code'),
        "no": $("#no_terms_page_body").summernote('code')
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  var init = function () {
    $("#en_terms_page_body").summernote({ height: 300 });
    $("#en_terms_page_body").summernote('code', en_content);
    $("#no_terms_page_body").summernote({ height: 300 });
    $("#no_terms_page_body").summernote('code', no_content);
  };
  init();
};
Controllers.editTermsProvider = function (en_content, no_content) {
  $("#page_save").click(function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".terms_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#terms_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#terms_header_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#terms_path").val(),
        "en_des": $("#terms_header_en_des").val(),
        "no_des": $("#terms_header_no_des").val(),
        "en_title": $("#terms_header_en_title").val(),
        "no_title": $("#terms_header_no_title").val(),
        "link": $("#terms_header_link").val()
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#terms_page_body_save").click(function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "contents",
      page_body: {
        "en": $("#en_terms_page_body").summernote('code'),
        "no": $("#no_terms_page_body").summernote('code')
      }
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#meta_save").click(function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  var init = function () {
    $("#en_terms_page_body").summernote({ height: 300 });
    $("#en_terms_page_body").summernote('code', en_content);
    $("#no_terms_page_body").summernote({ height: 300 });
    $("#no_terms_page_body").summernote('code', no_content);
  };
  init();
};

Controllers.settings = function () {
  // personal info updating
  $("#personal_info_save").click(function () {
    var personal_info = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      phone: $("#phone").val(),
      type: 'personal'
    };
    $.ajax({
      url: '/update_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: personal_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (!status) {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Data updated successfully");
        }
      }
    });
  });
  // mail setting updating
  $("#mail_save").click(function () {
    var mail_info = {
      old_mail: $("#old_mail").val(),
      new_mail: $("#new_mail").val(),
      type: 'mail'
    };
    $.ajax({
      url: '/update_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: mail_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (status == 0) {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else if (status == 1) {
          $("#old_mail_error").show();
          $("#old_mail_error").text('Enter correct Email address');
        } else if (status == 2) {
          alert("Mail updated successfully");
        } else if (status == 3) {
          $("#new_mail_error").show();
          $("#new_mail_error").text('Email already registered');
        }
      }
    });
  });
  //password updating
  $("#password_save").click(function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      type: 'password'
    };
    $.ajax({
      url: '/update_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: password_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (status == 0) {
          $("#old_password_error").show();
          $("#new_password_error").show();
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else if (status == 1) {
          alert("Mail updated successfully");
        } else if (status == 2) {
          $("#old_password_error").show();
          $("#old_password_error").text('Enter the password correctly');
        }
      }
    });
  });
};
var gotoconsult = {
  Controllers: Controllers
};