@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')

<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof">
		<div class="content_holesecion">
			<div class="single-page d-flex flex-column">
                <div class="single-page-heading log-settings-head d-flex flex-column">
                    <h2>@lang('member.settings')</h2>
                </div>
			
                <div class="profile-uploader d-flex flex-column">
                    <div class="profile-sec log-sec1 d-flex flex-column">
                        <h3>@lang('member.profile_settings')</h3>
                        <div class="imageupload log-setting-up">
                            <h3>@lang('member.profile_image')</h3>
                            <label class="btn btn-file">
                                <img src="{{asset($user_info->prof_image)}}" id="avatar"/>
                                <button class="btn up-img">@lang('member.upload_image')</button>
                                <input type="file" id="upload_file" name="image-file">
                            </label>
                        </div>
                        <div class="page-seting-content psc-log d-flex flex-column">
                            <label>@lang('member.first_name')</label>
                            <input type="text" id="first_name" value="{{auth()->user()->first_name}}"/>
                            <div class="alert" id="first_name_error"></div>
                            <label>@lang('member.last_name')</label>
                            <input type="text" id="last_name" value="{{auth()->user()->last_name}}"/>
                            <div class="alert" id="last_name_error"></div>
                            <label>@lang('member.email')</label>
                            <input type="text" id="email" value="{{auth()->user()->email}}" readonly/>
                            <label>@lang('member.phone')</label>
                            <input type="text" id="phone" value="{{auth()->user()->phone}}"/>
                            <div class="alert" id="phone_error"></div>
                            <label>@lang('member.industry_expertise')</label>
                            <input type="text" id="industry_expertise" value="{{$user_info->industry_expertise}}"/>
                            <div class="alert" id="industry_expertise_error"></div>	
                            <button class="sp-f cs save-btn btn" id="profile_save">@lang('member.save')</button>
                        </div>
                    </div>
                </div>

                <div class="profile-uploader setting-uploader d-flex flex-column">
                    <div class="profile-sec contact-sec d-flex flex-column">
                        <h3>@lang('member.contact_settings')</h3>
                        <div class="three-uploader d-flex">
                            <div class="up-one d-flex flex-column">
                                <label class="heading-t">@lang('member.phone')</label>
                                <label class="switch">
                                    <input type="checkbox"  id="phone_checkbox" class="phone_checkbox" value='1' {{ $user_info->phone_contact == 1 ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                    <span class="uncheck"></span>
                                </label>
                            </div>
                            <div class="up-two d-flex flex-column ">
                                <label class="heading-t">@lang('member.chat')</label>
                                <label class="switch">
                                    <input type="checkbox" id="chat_checkbox" class="chat_checkbox" value='1' {{ $user_info->chat_contact == 1 ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                    <span class="uncheck"></span>
                                </label>
                            </div>
                            <div class="up-three d-flex flex-column">
                                <label class="heading-t">@lang('member.video')</label>
                                <label class="switch">
                                    <input type="checkbox" id="video_checkbox" class="video_checkbox" value='1' {{ $user_info->video_contact == 1 ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                    <span class="uncheck"></span>
                                </label>
                            </div>
                        </div>
                        <button class="sp-f cs btn save-btn" id="contact_save">@lang('member.save')</button>
                    </div>
                </div>

                <div class="page-setting d-flex flex-column">
                    <div class="page-seting-content login-invo-setting d-flex flex-column">
                        <label>@lang('member.company_name')</label>
                        <input type="text" id="company_name" value="{{$user_info->company_name}}">
                        <div class="alert" id="company_name_error"></div>
                        <label>@lang('member.invoice_email')</label>
                        <input type="text" id="invoice_mail" value="{{$user_info->invoice_mail}}">
                        <div class="alert" id="invoice_mail_error"></div>
                        <label>@lang('member.first_name')</label>
                        <input type="text" id="company_first_name" value="{{$user_info->invoice_first_name}}">
                        <div class="alert" id="company_first_name_error"></div>
                        <label>@lang('member.last_name')</label>
                        <input type="text" id="company_last_name" value="{{$user_info->invoice_last_name}}">
                        <div class="alert" id="company_last_name_error"></div>
                        <label>@lang('member.address')</label>
                        <input type="text" id="address" value="{{$user_info->invoice_address}}">
                        <div class="alert" id="address_error"></div>
                        <label>@lang('member.zip_code')</label>
                        <input type="text" id="zip_code" value="{{$user_info->invoice_zip_code}}">
                        <div class="alert" id="zip_code_error"></div>
                        <label>@lang('member.zip_place')</label>
                        <input type="text" id="zip_place" value="{{$user_info->invoice_zip_place}}">
                        <div class="alert" id="zip_place_error"></div>
                        <button class="sp-f cs save-btn btn" id="invoice_save">@lang('member.save')</button>
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
        var user_info = "{{$user_info}}";
        user_info = user_info.replace(/&quot;/g, '"');
        var user = JSON.parse(user_info);
        if (!user.prof_image) {
            $("#avatar").attr('src', '/images/file-up.png');
        }
        // upload profile image
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
		// personal info updating
  		$("#profile_save").click(function(){
			var personal_info = {
                hidden_id: user.unique_id,
                prof_image: $("#avatar").attr('src'),
				first_name: $("#first_name").val(),
				last_name: $("#last_name").val(),
				phone: $("#phone").val(),
                industry_expertise: $("#industry_expertise").val(),
				type: 'personal'
			};
			$.ajax({
				url: '/update_member_setting',
				headers:  {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				data: personal_info,
				dataType: 'JSON',
				success: function (data) { 
					status=JSON.stringify(data['status']);
					if(!status) {
						$.each(data.errors,function(index,value){
							$("#" + index + "_error").show();
							$("#" + index + "_error").text(value[0]);
						});
					} else {
						alert("Data updated successfully");
					}                                     
				}
			});
		});
        // contact setting
		$("#contact_save").click(function (){
            var contact = {
                phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1: 0,
                chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1: 0,
                video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1: 0,
                hidden_id: user.unique_id,
                role: user.user.role,
                type: "contact"
            };
            $.ajax({
                url: '/update_member_setting',
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
        // invoice setting
        $("#invoice_save").click(function (){
            var invoice = {
                company_name: $("#company_name").val(),
                invoice_mail: $("#invoice_mail").val(),
                invoice_first_name: $("#company_first_name").val(),
                invoice_last_name: $("#company_last_name").val(),
                invoice_address: $("#address").val(),
                invoice_zip_code: $("#zip_code").val(),
                invoice_zip_place: $("#zip_place").val(),
                hidden_id: user.unique_id,
                role: user.user.role,
                type: "invoice"
            };
            $.ajax({
                url: '/update_member_setting',
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
                            $("#" + index + "_error").attr('style', 'display: block;');
                            $("#" + index + "_error").text(value[0]);
                        });
                    } else {
                        alert("Updated successfully");
                    }
                }
            });
        });
		//password updating
		$("#password_save").click(function(){
			var password_info = {
				old_password: $("#old_password").val(),
				new_password: $("#new_password").val(),
                hidden_id: user.unique_id,
				type: 'password'
			};

			$.ajax({
				url: '/update_member_setting',
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

@section('scripts')
<script>
    $(document).ready(function() {
        if (user.status != 'Offline') {
            $.ajax({
                url: '/api/manage_status',
                headers:  {
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
    });
</script>
@endsection