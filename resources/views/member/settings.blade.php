@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="wrapper member-sidebar">
  @include('elements.member_sidebar')
  <div class="content-wrapper member-content">
		<h2 class="pre-topic">@lang('member.settings')</h2>
		<div class="setting-page">
			<div class="profile-uploader">
				<div class="profile-sec contact-sec d-flex flex-column">
					<h3>@lang('member.communication-payment')</h3>
					<div class="setting-content">
						<div class="d-flex flex-column">
							<label class="heading-t">@lang('member.phone')</label>
							<label class="switch">
								<input type="checkbox" id="phone_checkbox" class="phone_checkbox" value='1'
									{{ $user_info->phone_contact == 1 ? 'checked' : '' }}>
								<span class="slider"></span>
								<span class="uncheck"></span>
							</label>
						</div>
						<div class="d-flex flex-column ">
							<label class="heading-t">@lang('member.chat')</label>
							<label class="switch">
								<input type="checkbox" id="chat_checkbox" class="chat_checkbox" value='1'
									{{ $user_info->chat_contact == 1 ? 'checked' : '' }}>
								<span class="slider"></span>
								<span class="uncheck"></span>
							</label>
						</div>
						<div class="d-flex flex-column">
							<label class="heading-t">@lang('member.video')</label>
							<label class="switch">
								<input type="checkbox" id="video_checkbox" class="video_checkbox" value='1'
									{{ $user_info->video_contact == 1 ? 'checked' : '' }}>
								<span class="slider"></span>
								<span class="uncheck"></span>
							</label>
						</div>
					</div>
					@if(auth()->user()->role == 'consultant')
					<div class="currency-selector d-flex flex-column my-2">
						<label for="currency">@lang('member.price_minute')</label>
						<input type="text" id="rate" placeholder="Input your hourly rate" value="{{$user_info->hourly_rate}}"/>
					</div>
					@endif
					<div class="currency-selector d-flex flex-column">
						<label for="currency">@lang('member.currency')</label>
						<select id="selected-currency" name="currency">
							<option disabled selected>Select the currency</option>
							<option value="NOK">NOK kr</option>
							<option value="USD">USD $</option>
							<option value="EUR">EUR €</option>
						</select>
					</div>
					<button class="sp-f cs btn save-btn" id="contact_save">@lang('member.save')</button>
				</div>
			</div>

			<div class="profile-uploader">
				<div class="profile-sec contact-sec d-flex flex-column">
					<h3 for="currency">@lang('member.saved_payment_method')</h3>
					<p>@lang('member.hourly_rate_description')</p>
				</div>
			</div>
			@if(auth()->user()->role == 'consultant')
			<div class="profile-uploader">
				<div class="profile-sec contact-sec d-flex flex-column">
					<h3>@lang('member.company_information')</h3>
					<form class="d-flex flex-column">
						<div class="form-group">
							<label>@lang('member.company_name')</label>
							<input type="text" name="company_name" id="company_name" value="{{$user_info->company ? $user_info->company->company_name : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.organization_number')</label>
							<input type="text" name="organization_number" id="organization_number" value="{{$user_info->company ? $user_info->company->organization_number : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.bank_account')</label>
							<input type="text" name="bank_account" id="bank_account" value="{{$user_info->company ? $user_info->company->bank_account : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.first_name')</label>
							<input type="text" name="first_name" id="first_name" value="{{$user_info->company ? $user_info->company->first_name : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.last_name')</label>
							<input type="text" name="last_name" id="last_name" value="{{$user_info->company ? $user_info->company->last_name : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.address')</label>
							<input type="text" name="address" id="address" value="{{$user_info->company ? $user_info->company->address : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.zip_code')</label>
							<input type="text" name="zip_code" id="zip_code" value="{{$user_info->company ? $user_info->company->zip_code : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.zip_place')</label>
							<input type="text" name="zip_place" id="zip_place" value="{{$user_info->company ? $user_info->company->zip_place : ''}}" required>
						</div>
						<div class="form-group">
							<label>@lang('member.country')</label>
							<input type="text" name="country" id="country" value="{{$user_info->company ? $user_info->company->country : ''}}" required>
						</div>
						<button class="sp-f cs btn save-btn" id="company_save" type="submit">@lang('member.save')</button>
					</form>
				</div>
			</div>
			@endif
			<div class="profile-uploader">
				<div class="profile-sec contact-sec d-flex flex-column">
					<h3>@lang('member.password_settings')</h3>
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
	jQuery(function(){
		var user_info = @json($user_info);
		new gotoconsult.Controllers.public(user_info);
		new gotoconsult.Controllers.setting(user_info);
	});
</script>
@endsection
