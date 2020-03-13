@extends('layout.private')
@section('title', 'GoToConsult - Profile')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
			<div class="content_holesecion">
				<div class="single-page d-flex flex-column">
					<div class="single-page-heading single-page d-flex flex-column">
							<h2>@lang('admin.settings')</h2>
					</div>			
					<div class="page-setting p-info d-flex flex-column">
						<h2>@lang('admin.personal_info')</h2>
						<div class="page-seting-content d-flex flex-column">
						<label>@lang('admin.first_name')</label>
						<input type="text" id="first_name" class="first_name" value="{{auth()->user()->first_name}}">
						<div class="alert" id="first_name_error"></div>
						<label>@lang('admin.last_name')</label>
						<input type="text" id="last_name" class="last_name" value="{{auth()->user()->last_name}}">
						<div class="alert" id="last_name_error"></div>
						<label>@lang('admin.phone')</label>
						<input type="phone" id="phone" class="phone" value="{{auth()->user()->phone}}">
						<div class="alert" id="phone_error"></div>
						<button type="button" id="personal_info_save" class="sp-f cs save-btn btn">@lang('admin.save')</button>
				</div>
			</div>
			<div class="page-setting setting-info d-flex flex-column">
				<h2>@lang('admin.mail_settings')</h2>
				<div class="page-seting-content d-flex flex-column">
					<label>@lang('admin.old_email')</label>
					<input type="text" id="old_mail" class="old_mail" value="{{auth()->user()->email}}">
					<div class="alert" id="old_mail_error"></div>
					<label>@lang('admin.new_email')</label>
					<input type="text" id="new_mail" class="new_mail">
					<div class="alert" id="new_mail_error"></div>
					<button class="sp-f cs save-btn btn" id="mail_save">@lang('admin.save')</button>
				</div>
			</div>
			<div class="page-setting setting-info d-flex flex-column">
				<h2>@lang('admin.password_settings')</h2>
				<div class="page-seting-content d-flex flex-column">
					<label>@lang('admin.old_password')</label>
					<input type="text" id="old_password" class="old_password">
					<div class="alert" id="old_password_error"></div>
					<label>@lang('admin.new_password')</label>
					<input type="text" id="new_password" class="new_password">
					<div class="alert" id="new_password_error"></div>
					<button class="sp-f cs save-btn btn" id="password_save">@lang('admin.save')</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		// personal info updating
  		$("#personal_info_save").click(function(){
			var personal_info = {
				first_name: $("#first_name").val(),
				last_name: $("#last_name").val(),
				phone: $("#phone").val(),
				type: 'personal'
			};
			$.ajax({
				url: '/update_setting',
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
		
		// mail setting updating
		$("#mail_save").click(function(){
			var mail_info = {
				old_mail: $("#old_mail").val(),
				new_mail: $("#new_mail").val(),
				type: 'mail'
			};
			$.ajax({
				url: '/update_setting',
				headers:  {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				data: mail_info,
				dataType: 'JSON',
				success: function (data) { 
					status=JSON.stringify(data['status']);
					if(status == 0) {
						$.each(data.errors,function(index,value){
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
		$("#password_save").click(function(){
			var password_info = {
				old_password: $("#old_password").val(),
				new_password: $("#new_password").val(),
				type: 'password'
			};
			$.ajax({
				url: '/update_setting',
				headers:  {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				data: password_info,
				dataType: 'JSON',
				success: function (data) { 
					status=JSON.stringify(data['status']);
					if(status == 0) {
						$("#old_password_error").show();
						$("#new_password_error").show();
						$.each(data.errors,function(index,value){
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
	});
</script>
@endsection