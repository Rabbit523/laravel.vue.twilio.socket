@extends('layout.private')
@section('title', 'GoToConsult - Edit Consultant')
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
                                <img src="{{asset($consultant->prof_image)}}" id="avatar"/>
                                <button class="btn up-img">@lang('member.upload_image')</button>
                                <input type="file" id="upload_file" name="image-file">
                            </label>
                            <label class="switch">
                                <input type="checkbox" id="image_access" {{ $consultant->image_access == 1 ? 'checked' : '' }}>
                                <span class="slider"></span>
                                <span class="uncheck"></span>
                            </label>
                            <input type="hidden" id="checkbox_value" name="checkbox_value" value="{{$consultant->image_access}}">
                            <button class="sp-f save-btn btn ml-3" id="image_save">Save</button>
                        </div>
                    </div>
                </div>
                <div class="page-setting d-flex flex-column">
                    <h2>@lang('admin.page_settings')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.first_name')</label>
                        <input type="text" id="first_name" class="first_name" value="{{$user->first_name}}">
                        <div class="alert" id="first_name_error"></div>
                        <label>@lang('admin.last_name')</label>
                        <input type="text" id="last_name" class="last_name" value="{{$user->last_name}}">
                        <div class="alert" id="last_name_error"></div>
                        <label>@lang('admin.email')</label>
                        <input type="text" id="email" class="email" value="{{$user->email}}" readonly>
                        <label>@lang('admin.phone')</label>
                        <input type="text" id="phone" class="phone" value="{{$user->phone}}">
                        <div class="alert" id="phone_error"></div>
                        <label>@lang('admin.industry_expertise')</label>
                        <select id="industry_expertise" class="form-control" style="height: auto!important;">
                            @foreach($categories as $data)
                            <option value="{{$data->category_name}}" {{ $consultant->industry_expertise == $data->category_name ? 'selected="selected"' : '' }}>{{$data->category_name}}</option>
                            @endforeach 
                        </select>
                        <div class="alert" id="industry_expertise_error"></div>
                        <button class="sp-f cs save-btn btn" id="profile_save">Save</button>
                    </div>
                </div>
                <div class="profile-uploader d-flex flex-column">
                    <h2>@lang('admin.contact_settings')</h2>
                    <div class="profile-sec contact-sec d-flex flex-column">
                        <label class="heading-t">@lang('admin.phone')</label>
                        <label class="switch">
                            <input type="checkbox"  id="phone_checkbox" class="phone_checkbox" value='1' {{ $consultant->phone_contact == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                        <label class="heading-t">@lang('admin.chat')</label>
                        <label class="switch">
                            <input type="checkbox" id="chat_checkbox" class="chat_checkbox" value='1' {{ $consultant->chat_contact == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                            <span class="uncheck"></span>
                        </label>
                        <label class="heading-t">@lang('admin.video')</label>
                        <label class="switch">
                            <input type="checkbox" id="video_checkbox" class="video_checkbox" value='1' {{ $consultant->video_contact == 1 ? 'checked' : '' }}>
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
                        <input type="text" id="company_name" class="company_name" value="{{$consultant->company_name}}">
                        <div class="alert" id="company_name_error"></div>
                        <label>@lang('admin.invoice_email')</label>
                        <input type="text" id="invoice_mail" class="invoice_mail" value="{{$consultant->invoice_mail}}">
                        <div class="alert" id="invoice_mail_error"></div>
                        <label>@lang('admin.first_name')</label>
                        <input type="text" id="company_first_name" class="company_first_name" value="{{$consultant->invoice_first_name}}">
                        <div class="alert" id="company_first_name_error"></div>
                        <label>@lang('admin.last_name')</label>
                        <input type="text" id="company_last_name" class="company_last_name" value="{{$consultant->invoice_last_name}}">
                        <div class="alert" id="company_last_name_error"></div>
                        <label>@lang('admin.address')</label>
                        <input type="text" id="address" class="address" value="{{$consultant->invoice_address}}">
                        <div class="alert" id="address_error"></div>
                        <label>@lang('admin.zip_code')</label>
                        <input type="text" id="zip_code" class="zip_code" value="{{$consultant->invoice_zip_code}}">
                        <div class="alert" id="zip_code_error"></div>
                        <label>@lang('admin.zip_place')</label>
                        <input type="text" id="zip_place" class="zip_place" value="{{$consultant->invoice_zip_place}}">
                        <div class="alert" id="zip_place_error"></div>
                        <button class="sp-f cs save-btn btn" id="invoice_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting meta-info d-flex flex-column">
                    <h2>@lang('member.change_password')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('member.old_password')</label>
                        <input type="password" id="old_password">
                        <div class="alert" id="old_password_error"></div>
                        <label>@lang('member.new_password')</label>
                        <input type="password" id="new_password">
                        <button class="sp-f cs save-btn btn" id="password_save">@lang('member.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        var temp = "{{$consultant}}";
        temp = temp.replace(/&quot;/g, '"');
        var consultant = JSON.parse(temp);
        if (!consultant.prof_image) {
            $("#avatar").attr('src', '/images/file-up.png');
        }
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
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#image_save").click(function() {
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
        $("#profile_save").click(function(){
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
                    var status=JSON.stringify(data['status']);
                    if(status=='false') {
                        $.each(data.errors,function(index,value){
                            $("#" + index + "_error").show();
                            $("#" + index + "_error").text(value[0]);
                        });
                    } else {
                        var id=JSON.stringify(data['id']);
                        if(id!='') {
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
        $("#contact_save").click(function (){
            var contact = {
                phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1: 0,
                chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1: 0,
                video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1: 0,
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
        $("#invoice_save").click(function (){
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
                    }
                }
            });
        });
        $("#password_save").click(function(){
			var password_info = {
				old_password: $("#old_password").val(),
				new_password: $("#new_password").val(),
                hidden_id: consultant.unique_id,
				type: 'password'
			};

			$.ajax({
				url: '/update_consultant',
				headers:  {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				data: password_info,
				dataType: 'JSON',
				success: function (data) { 
					status=JSON.stringify(data['status']);
					if(status == 1) {
						$("#old_password_error").attr('style', 'display: block;');
						$("#old_password_error").text('Enter the previous password correctly');
					} else {
						alert("Updated successfully");
					}
				}
			});
		});
    });
</script>
@endsection