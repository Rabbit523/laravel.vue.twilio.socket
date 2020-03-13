@extends('layout.private')
@section('title', 'GoToConsult - Create Consultant')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion">
		    <div class="single-page d-flex flex-column">
			    <div class="single-page-heading single-page d-flex flex-column">
			        <a href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}"><img src="{{ asset('images/back-icon.png')}}" alt="icon"/></a>
                </div>
                <div class="profile-uploader d-flex flex-column">
                    <div class="imageupload log-setting-up">
                        <h3>@lang('admin.profile_image')</h3>
                        <div class="d-flex">
                            <label class="btn btn-file">
                                <img src="{{asset('/images/file-up.png')}}" id="avatar"/>
                                <button class="btn up-img">@lang('member.upload_image')</button>
                                <input type="file" id="upload_file" name="image-file">
                            </label>
                            <label class="switch">
                                <input type="checkbox" id="image_access">
                                <span class="slider"></span>
                                <span class="uncheck"></span>
                            </label>
                            <input type="hidden" id="avatar_file">
                            <input type="hidden" id="checkbox_value" name="checkbox_value" >
                        </div>
                    </div>
                </div>
                <div class="page-setting d-flex flex-column">
                    <h2>@lang('admin.page_settings')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.first_name')</label>
                        <input type="text" id="first_name" class="first_name">
                        <div class="alert" id="first_name_error"></div>
                        <label>@lang('admin.last_name')</label>
                        <input type="text" id="last_name" class="last_name">
                        <div class="alert" id="last_name_error"></div>
                        <label>@lang('admin.email')</label>
                        <input type="text" id="email" class="email">
                        <div class="alert" id="email_error"></div>
                        <label>@lang('admin.phone')</label>
                        <input type="text" id="phone" class="phone">
                        <div class="alert" id="phone_error"></div>
                        <label>@lang('admin.industry_expertise')</label>
                        <select id="industry_expertise" class="form-control" style="height: auto!important;">
                            @foreach($categories as $data)
                            <option value="{{$data->category_name}}">{{$data->category_name}}</option>
                            @endforeach 
                        </select>
                        <div class="alert" id="industry_expertise_error"></div>
                        <input type="hidden" id="hidden_id" >
                        <button class="sp-f cs save-btn btn" id="profile_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="profile-uploader d-flex flex-column">
                    <h2>@lang('admin.contact_settings')</h2>
                    <div class="profile-sec contact-sec d-flex flex-column">
                        <label class="heading-t">@lang('admin.phone')</label>
                        <label class="switch">
                            <input type="checkbox"  id="phone_checkbox" class="phone_checkbox" value='1'>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                        <label class="heading-t">@lang('admin.chat')</label>
                        <label class="switch">
                            <input type="checkbox" id="chat_checkbox" class="chat_checkbox" value='1'>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                        <label class="heading-t">@lang('admin.video')</label>
                        <label class="switch">
                            <input type="checkbox" id="video_checkbox" class="video_checkbox" value='1'>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                        <button class="sp-f cs btn save-btn" id="contact_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting d-flex flex-column">
                    <h2>@lang('admin.invoice_settings')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.company_name')</label>
                        <input type="text" id="company_name" class="company_name">
                        <div class="alert" id="company_name_error"></div>
                        <label>@lang('admin.invoice_email')</label>
                        <input type="text" id="invoice_mail" class="invoice_mail">
                        <div class="alert" id="invoice_mail_error"></div>
                        <label>@lang('admin.first_name')</label>
                        <input type="text" id="company_first_name" class="company_first_name">
                        <div class="alert" id="company_first_name_error"></div>
                        <label>@lang('admin.last_name')</label>
                        <input type="text" id="company_last_name" class="company_last_name">
                        <div class="alert" id="company_last_name_error"></div>
                        <label>@lang('admin.address')</label>
                        <input type="text" id="address" class="address">
                        <div class="alert" id="address_error"></div>
                        <label>@lang('admin.zip_code')</label>
                        <input type="text" id="zip_code" class="zip_code">
                        <div class="alert" id="zip_code_error"></div>
                        <label>@lang('admin.zip_place')</label>
                        <input type="text" id="zip_place" class="zip_place">
                        <div class="alert" id="zip_place_error"></div>
                        <button class="sp-f cs save-btn btn" id="invoice_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting meta-info d-flex flex-column">
                    <h2>@lang('admin.set_password')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.password')</label>
                        <input type="password" id="password">
                        <div class="alert" id="password_error"></div>
                        <label>@lang('admin.confirm_password')</label>
                        <input type="password" id="confirm_password">
                        <div class="alert" id="confirm_password_error"></div>
                        <button class="sp-f cs save-btn btn" id="password_save">@lang('admin.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $("#image_access").click(function(){
        if ($('#image_access').is(":checked")) {
            $("#checkbox_value").val(1);
        } else {
            $("#checkbox_value").val(0);
        }
    });
    $("#upload_file").on('change', function() {
        var formdata = new FormData();
        formdata.append('file', this.files[0]);
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/member_image_upload',
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
    $("#profile_save").click(function(){
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
                var status=JSON.stringify(data['status']);
                if(status=='false') {
                    $.each(data.errors,function(index,value){
                        $("#" + index + "_error").show();
                        $("#" + index + "_error").text(value[0]);
                    });
                } else {
                    var id=JSON.stringify(data['id']);
                    $("#hidden_id").val(id);
                    $("#profile_save").prop("disabled", true);
                    alert("A consultant is added successfully");
                }
            }
        });
    });
    $("#contact_save").click(function (){
        var contact = {
            phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1: 0,
            chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1: 0,
            video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1: 0,
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
    $("#invoice_save").click(function (){
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
                    var status=JSON.stringify(data['status']);
                    if(status=='false') {
                        $.each(data.errors,function(index,value){
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
    $("#password_save").click(function(){
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
                    var status=JSON.stringify(data['status']);
                    if(status==1) {
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
</script>
@endsection