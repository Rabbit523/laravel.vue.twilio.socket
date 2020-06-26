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
                                @if($consultant->profile && $consultant->profile->avatar)
                                <img src="{{asset($consultant->profile->avatar)}}" id="avatar"/>
                                @else
                                <img src="{{asset('/images/file-up.png')}}" id="avatar"/>
                                @endif
                                <button class="btn up-img">@lang('member.upload_image')</button>
                                <input type="file" id="upload_file" name="image-file">
                            </label>
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
                        <label>@lang('admin.profile->profession')</label>
                        <select id="profile->profession" class="form-control" style="height: auto!important;">
                            @foreach($categories as $data)
                            <option value="{{$data->category_name}}" {{ $consultant->profile->profession == $data->category_name ? 'selected="selected"' : '' }}>{{$data->category_name}}</option>
                            @endforeach 
                        </select>
                        <div class="alert" id="profile->profession_error"></div>
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
	jQuery(function(){
        var consultant = @json($consultant);
		new gotoconsult.Controllers.editConsultant(consultant);
	});
</script>
@endsection