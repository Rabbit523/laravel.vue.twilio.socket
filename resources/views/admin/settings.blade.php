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
	jQuery(function(){
		new gotoconsult.Controllers.settings();
	});
</script>
@endsection