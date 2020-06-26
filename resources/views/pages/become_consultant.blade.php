@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="full-consultant">
    <div class="container">
        <div class="col-12 consultant-page px-3">
            <div class="form-box">
                <form id="consultant-form" method="POST" action="{{ url('/api/become-consultant') }}">
                    @if($lang == 'en')
                        <h1>{{$data->en_header->title}}</h1>
                        <p>{{$data->en_header->description}}</p>
                    @else
                        <h1>{{$data->no_header->title}}</h1>
                        <p>{{$data->no_header->description}}</p>
                    @endif
                    <div class="step">
                        <h5>1. @lang('forms.create-account')</h5>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="first_name">@lang('forms.first_name')</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">@lang('forms.last_name')</label>
                                <input type="text" class="form-control" id="last_name"  name="last_name" required>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group">
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('forms.email')</label>
                                <input type="email" class="form-control" id="email"  name="email" required>
                                @if ($errors->has('email'))
                                <span class="feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group mr-0">
                                <label for="password">@lang('forms.password')</label>
                                <span id="pwd_show">@lang('forms.show')</span>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @if ($errors->has('password'))
                                <span class="feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group mr-0">
                                <label for="from" class="labelfocus">@lang('forms.from')</label>
                                <select class="crs-country form-control" id="from" name="from" required></select>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="country" class="labelfocus">@lang('forms.living-in')</label>
                                <select class="crs-country form-control" id="country" name="country" data-region-id="region" required></select>
                            </div>
                            <div class="form-group">
                                <label for="region" class="labelfocus">@lang('forms.choose')</label>
                                <select id="region" name="region" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="timezone" class="labelfocus">@lang('forms.timezone')</label>
                                <select id="timezone" class="form-control" name="timezone" required></select>
                            </div>
                            <div class="form-group">
                                <label for="account">@lang('forms.user-account-id')</label>
                                <input type="text" class="form-control" id="account" name="account" required>
                            </div>
                        </div>
                    </div>
                    <div class="step">
                        <h5>2. @lang('forms.private-information')</h5>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="birthday">@lang('forms.birthday')</label>
                                <span class="img-outline"><img src="{{ asset('images/calendar.svg') }}" /></span>
                                <input type="text" class="form-control date-picker" id="birthday" name="birthday" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="labelfocus">@lang('forms.gender')</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="street">@lang('forms.street-address')</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            <div class="form-group">
                                <label for="zip_code">@lang('forms.zip-code')</label>
                                <input type="text" class="form-control" id="zip_code"  name="zip_code" required>
                            </div>
                        </div>
                    </div>
                    <div class="step">
                        <h5>3. @lang('forms.company-information')</h5>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="company_name" class="labelfocus">@lang('forms.company-name')</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="form-group">
                                <label for="org_number">@lang('forms.organization-number')</label>
                                <input type="text" class="form-control" id="org_number" name="organization_number" required>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group mr-0">
                                <label for="bank_account">@lang('forms.bank-account')</label>
                                <input type="text" class="form-control" id="bank_account" name="bank_account" required>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group">
                                <label for="cfirst_name">@lang('forms.first_name')</label>
                                <input type="text" class="form-control" id="cfirst_name" name="cfirst_name" required>
                            </div>
                            <div class="form-group">
                                <label for="clast_name">@lang('forms.last_name')</label>
                                <input type="text" class="form-control" id="clast_name"  name="clast_name" required>
                            </div>
                        </div>
                        <div class="group-box">
                            <div class="form-group mr-0">
                                <label for="company_address">@lang('forms.company-address')</label>
                                <input type="text" class="form-control" id="company_address" name="company_address" required>
                            </div>
                        </div>
                        <div class="group-box three">
                            <div class="form-group">
                                <label for="company_from" class="labelfocus">@lang('forms.company-in')</label>
                                <select class="crs-country form-control" id="company_from" name="company_from" data-region-id="company_region" required></select>
                            </div>
                            <div class="form-group">
                                <label for="company_region" class="labelfocus">@lang('forms.choose')</label>
                                <select id="company_region" name="company_region" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="czip_code">@lang('forms.zip-code')</label>
                                <input type="text" class="form-control" id="czip_code"  name="czip_code" required>
                            </div>
                        </div>
                    </div>
                    <div class="step step4">
                        <h5>4. @lang('forms.consultant-profile')</h5>
                        <div class="image-upload mt-3">
                            <div class="preview-profile-photo">
                                <img src="/images/white-logo.svg" />
                            </div>
                            <div class="des-profile-photo">
                                <p><b>@lang('forms.edit-photo')</b></p>
                                <ul>
                                    <li>@lang('forms.edit-photo-des1')</li>
                                    <li>@lang('forms.edit-photo-des2')</li>
                                    <li>@lang('forms.edit-photo-des3')</li>
                                </ul>
                                <a class="upload-profile-photo">@lang('forms.btn-upload')</a>
                                <input type="file" id="upload_profile" accept=".jpg,.png,.bmp,.jpeg">
                                <input type="hidden" name="profile_avatar" id="profile_avatar">
                            </div>
                        </div>
                        <div class="underline-bar"></div>
                        <div class="des-profile">
                            <div class="des-profile-photo">
                                <p><b>@lang('forms.following-des')</b></p>
                                <ul>
                                    <li>@lang('forms.following-des1')</li>
                                    <li>@lang('forms.following-des2')</li>
                                    <li>@lang('forms.following-des3')</li>
                                    <li>@lang('forms.following-des4')</li>
                                    <li>@lang('forms.following-des5')</li>
                                </ul>
                            </div>
                            <div class="des-profile-photo following">
                                <div class="d-flex flex-column w-100 mb-3">
                                    <p class="text-left"><b>@lang('forms.following-des6')</b></p>
                                    <div class="d-flex justify-content-between">
                                        <img src="{{asset('images/become_consultant/good-image-1.png')}}">
                                        <img src="{{asset('images/become_consultant/good-image-2.png')}}">
                                        <img src="{{asset('images/become_consultant/good-image-3.png')}}">
                                        <img src="{{asset('images/become_consultant/good-image-4.png')}}">
                                        <img src="{{asset('images/become_consultant/good-image-5.png')}}">
                                    </div>
                                </div>
                                <div class="d-flex flex-column w-100">
                                    <p class="text-left"><b>@lang('forms.following-des7')</b></p>
                                    <div class="d-flex justify-content-between">
                                        <img src="{{asset('images/become_consultant/not-good-image-1.png')}}">
                                        <img src="{{asset('images/become_consultant/not-good-image-2.png')}}">
                                        <img src="{{asset('images/become_consultant/not-good-image-3.png')}}">
                                        <img src="{{asset('images/become_consultant/not-good-image-4.png')}}">
                                        <img src="{{asset('images/become_consultant/not-good-image-5.png')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="underline-bar"></div>
                        <div class="d-flex align-items-center custom-checkbox">
                            <label>
                                <input type="checkbox" value="" id="photo-confirmation">@lang('forms.photo-confirmation')<span class="checkmark" id="photo_check"></span>
                            </label>
                        </div>
                        <div class="underline-bar"></div>                    
                    </div>
                    <div class="step">
                        <h5>5. @lang('forms.consultant-intro')</h5>
                        <div class="form-group textarea">
                            <label for="consultant_introduction">@lang('forms.about-me')</label>
                            <textarea name="consultant_introduction" id="consultant_introduction" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="step step6">
                        <h5>6. @lang('forms.consultant-back')</h5>
                        <div class="group-box">
                            <div class="form-group mr-0">
                                <label for="profession" class="labelfocus">@lang('forms.profession')</label>
                                <select class="form-control" id="profession" name="profession" required>
                                    <option value="psychologists">Psychologists</option>
                                    <option value="economists">Economists</option>
                                    <option value="lawyers">Lawyers</option>
                                    <option value="doctors">Doctors</option>
                                    <option value="nurses">Nurses</option>
                                    <option value="veterinarians">Veterinarians</option>
                                    <option value="astrologers">Astrologers</option>
                                    <option value="teachers">Teachers</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="back-item education">
                                <p>@lang('forms.consultant-edu')</p>
                                <div class="list" id="education-list"></div>
                                <div class="underline-bar"></div>
                                <a id="btn-education">+@lang('forms.add')</a>
                            </div>
                            <div class="back-item experience">
                                <p>@lang('forms.consultant-work')</p>
                                <div class="list" id="experience-list"></div>
                                <div class="underline-bar"></div>
                                <a id="btn-work">+@lang('forms.add')</a>
                            </div>
                            <div class="back-item certificate">
                                <p>@lang('forms.consultant-certificates')</p>
                                <div class="list" id="certificate-list"></div>
                                <div class="underline-bar"></div>
                                <a id="btn-certificate">+@lang('forms.add')</a>
                            </div>
                        </div>
                    </div>
                    <div class="step">
                        <h5>7. @lang('forms.availability-price')</h5>
                        <div class="d-flex flex-column">
                            <div class="ability">
                                <div class="d-flex flex-column ">
                                    <label class="heading-t text-center">@lang('forms.chat')</label>
                                    <label class="switch">
                                        <input type="checkbox" id="chat_checkbox" class="chat_checkbox" >
                                        <span class="slider"></span>
                                        <span class="uncheck"></span>
                                    </label>
                                </div>
                                <div class="d-flex flex-column">
                                    <label class="heading-t text-center">@lang('forms.call')</label>
                                    <label class="switch">
                                        <input type="checkbox" id="phone_checkbox" class="phone_checkbox" >
                                        <span class="slider"></span>
                                        <span class="uncheck"></span>
                                    </label>
                                </div>
                                <div class="d-flex flex-column">
                                    <label class="heading-t text-center">@lang('forms.video')</label>
                                    <label class="switch">
                                        <input type="checkbox" id="video_checkbox" class="video_checkbox" >
                                        <span class="slider"></span>
                                        <span class="uncheck"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="rate-sec group-box">
                                <div class="form-group">
                                    <label for="rate">@lang('forms.price-per-minute')</label>
                                    <input type="text" class="form-control" id="rate"  name="rate" required>
                                </div>
                                <div class="form-group">
                                    <select name="currency" id="currency" class="form-control" required>
                                        <option value="NOK">NOK</option>
                                        <option value="EUR">EUR</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step terms">
                        <h5>8. @lang('forms.terms-provider')</h5>
                        <p>@lang('forms.terms-provider-des')</p>
                        <div class="terms-section">
                            @if ($lang == 'en')
                            {!! $terms->contents->en !!}
                            @else
                            {!! $terms->contents->no !!}
                            @endif
                        </div>
                    </div>
                    <div class="step">
                        <div class="d-flex align-items-center custom-checkbox">
                            <label>
                                <input type="checkbox" value="" id="terms">
                                @lang('forms.terms-check1')
                                <a href="{{ $lang == 'en' ? url('/terms-consultant') : url('/no/vilkar-konsulent') }}">@lang('forms.terms-provider')</a>
                                @lang('forms.terms-check2')
                                <a href="{{ $lang == 'en' ? url('/privacy') : url('/no/personvern') }}">@lang('forms.privacy-policy').</a>
                                <span class="checkmark" id="terms_check"></span>
                            </label>
                        </div>
                    </div>
                    <div class="step">
                        <input type="submit" class="btn btn-submit" value="@lang('forms.become-consultant')" >
                    </div>
                </form>
                <div class="bottom-link d-flex justify-content-center pt-2">
                    <a class="nav-link" href="{{$lang=='en' ? url('/login') : url('/no/logg-inn')}}">@lang('forms.login_account')</a>
                </div>
            </div>
            <div class="benefit d-flex flex-column">
                <?php $count = count($data->list); ?>
                @foreach($data->list as $key => $item)
                    <div class="consultant-benefit-item my-3">
                        <img src="{{ $item->path }}" alt="logo" />
                        <div class="description">
                            <p class="m-0 pl-3">
                                <b>@if($lang == 'en'){{$item->en_title}}@else{{$item->no_title}}@endif</b>
                            </p>
                            <p class="m-0 pl-3">				
                                @if($lang == 'en')
                                {!! $item->en_txt !!}
                                @else
                                {!! $item->no_txt !!}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal fade" id="education-modal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
                            <h3>@lang('forms.add-education')</h3>
                            <button type="button" class="close education-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						</div>
						<div class="modal-body">
                            <form method="POST" action="{{ url('/add-education') }}" id="education-form">
                                <div class="group-box">
                                    <div class="form-group">
                                        <label for="edu_from_date" class="labelfocus">@lang('forms.from')</label>
                                        <input type="text" class="form-control yearpicker" id="edu_from_date" name="edu_from_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edu_to_date" class="labelfocus">@lang('forms.to')</label>
                                        <input type="text" class="form-control yearpicker" id="edu_to_date" name="edu_to_date" required>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group">
                                        <label for="institution">@lang('forms.institution')</label>
                                        <input type="text" name="institution" class="form-control" id="institution" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="major" class="labelfocus">@lang('forms.major')</label>
                                        <input type="text" name="major" class="form-control" id="major" required>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group mr-0">
                                        <label for="degree" class="labelfocus">@lang('forms.degree')</label>
                                        <select name="degree" class="form-control" id="degree" required>
                                            <option disabled selected >@lang('forms.select-default')</option>
                                            <option value="bachelor">@lang('forms.bachelor')</option>
                                            <option value="master">@lang('forms.master')</option>
                                            <option value="doctorate">@lang('forms.doctorate')</option>
                                            <option value="postdoctoral">@lang('forms.postdoctoral')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group textarea mr-0">
                                        <label for="description" class="labelfocus">@lang('forms.description')</label>
                                        <textarea name="description" id="edu_description" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="upload-profile">
                                        <p>@lang('forms.file-upload-des')</p>
                                        <ul>
                                            <li>@lang('forms.file-upload-des1')</li>
                                            <li>@lang('forms.file-upload-des2')</li>
                                            <li>@lang('forms.file-upload-des3')</li>
                                        </ul>
                                        <a class="upload-profile-education text-uppercase">@lang('forms.choose-file')</a>
                                        <input type="file" id="upload_education" name="image-file" accept=".pdf,.jpg">
                                    </div>
                                </div>
                                <div class="underline-bar"></div>
                                <div class="btn-group">
                                    <button type="button" class="close text-uppercase education-close" data-dismiss="modal" aria-label="Close">@lang('forms.cancel')</button>
                                    <input type="submit" class="btn-save text-uppercase" id="education-save" value="@lang('forms.submit')">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="experience-modal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3>@lang('forms.add-experience')</h3>
							<button type="button" class="close experience-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						</div>
						<div class="modal-body">
                            <form method="POST" action="{{ url('/add-experience') }}" id="experience-form">
                                <div class="group-box">
                                    <div class="form-group">
                                        <label for="experience_from_date" class="labelfocus">@lang('forms.from')</label>
                                        <input type="text" name="experience_from_date" class="form-control yearpicker" id="experience_from_date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience_to_date" class="labelfocus">@lang('forms.to')</label>
                                        <input type="text" name="experience_to_date" class="form-control yearpicker" id="experience_to_date" required>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group">
                                        <label for="experience_company">@lang('forms.company')</label>
                                        <input name="experience_company" class="form-control" id="experience_company" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience_position">@lang('forms.position')</label>
                                        <input name="experience_position" class="form-control" id="experience_position" required>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group">
                                        <label for="experience_country" class="labelfocus">@lang('forms.country-region')</label>
                                        <select name="experience_country" class="crs-country form-control" id="experience_country" data-region-id="experience_city" required></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience_city" class="labelfocus">@lang('forms.city')</label>
                                        <select type="text" name="experience_city" class="form-control" id="experience_city" required></select>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group textarea mr-0">
                                        <label for="experience_description" class="labelfocus">@lang('forms.description')</label>
                                        <textarea name="experience_description" id="experience_description" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="underline-bar"></div>
                                <div class="btn-group">
                                    <button type="button" class="close text-uppercase experience-close" data-dismiss="modal" aria-label="Close">@lang('forms.cancel')</button>
                                    <input type="submit" class="btn-save text-uppercase" id="experience-save" value="@lang('forms.submit')">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="certificate-modal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3>@lang('forms.add-certificate')</h3>
							<button type="button" class="close certificate-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						</div>
						<div class="modal-body">
                            <form method="POST" action="{{ url('/add-certificate') }}" id="certificate-form">
                                <div class="group-box">
                                    <div class="form-group mr-0">
                                        <label for="certificate_date" class="labelfocus">@lang('forms.date')</label>
                                        <input type="text" name="certificate_date" class="form-control yearpicker" id="certificate_date" required>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group">
                                        <label for="certificate_name">@lang('forms.certificate-name')</label>
                                        <input name="certificate_name" class="form-control" id="certificate_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="certificate_institution">@lang('forms.institution')</label>
                                        <input name="certificate_institution" class="form-control" id="certificate_institution" required>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="form-group textarea mr-0">
                                        <label for="certificate_description" class="labelfocus">@lang('forms.description')</label>
                                        <textarea name="certificate_description" id="certificate_description" class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="group-box">
                                    <div class="upload-profile">
                                        <p>@lang('forms.file-upload-des')</p>
                                        <ul>
                                            <li>@lang('forms.file-upload-des1')</li>
                                            <li>@lang('forms.file-upload-des2')</li>
                                            <li>@lang('forms.file-upload-des3')</li>
                                        </ul>
                                        <a class="upload-profile-certificate text-uppercase">@lang('forms.choose-file')</a>
                                        <input type="file" id="upload_certificate" name="image-file" accept=".pdf,.jpg">
                                    </div>
                                </div>
                                <div class="underline-bar"></div>
                                <div class="btn-group">
                                    <button type="button" class="close text-uppercase certificate-close" data-dismiss="modal" aria-label="Close">@lang('forms.cancel')</button>
                                    <input type="submit" class="btn-save text-uppercase" id="certificate-save" value="@lang('forms.submit')">
                                </div>
                            </form>
                        </div>
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
        new gotoconsult.Controllers.authenticator();
	});
</script>
<script>
    var education = {}, certificate = {}, experience = {};
    var consultant = {
        docs: {
            educations: [],
            experiences: [],
            certificates: []
        }
    };
    // file upload
    $(".upload-profile-photo").click(function () {
        $("#upload_profile").trigger("click");
    });
    $("#upload_profile").on('change', function () {
        var filesize = ((this.files[0].size / 1024) / 1024).toFixed(4);
        if (filesize < 2) {
            $(".step4 h5").attr("style", "color: #000;");
            $(".preview-profile-photo").attr('style', 'border: 1px solid #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,.25);');
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
                    $(".preview-profile-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${e.url}')`);
                    $(".preview-profile-photo img").attr('style', 'display: none;');
                    $("#profile_avatar").val(e.url);
                }
            });
        } else {
            $(".step4 h5").attr("style", "color: #e71f1f;");
            $(".preview-profile-photo").attr('style', 'border: 1px solid #e71f1f; box-shadow: 0 2px 8px 0 #e71f1f;');
        }
    });
    $(".upload-profile-education").click(function () {
        $("#upload_education").trigger("click");
    });
    $("#upload_education").on('change', function () {
        var filesize = ((this.files[0].size / 1024) / 1024).toFixed(4);
        if (filesize < 2) {
            $("#education-modal .upload-profile p").attr("style", "color: #000;");
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/api/consultant_doc_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    education.diploma = e.url;
                }
            });
        } else {
            $("#education-modal .upload-profile p").attr("style", "color: #e71f1f;");
        }
    });
    $(".upload-profile-certificate").click(function () {
        $("#upload_certificate").trigger("click");
    });
    $("#upload_certificate").on('change', function () {
        var filesize = ((this.files[0].size / 1024) / 1024).toFixed(4);
        if (filesize < 2) {
            $("#certificate-modal .upload-profile p").attr("style", "color: #000;");
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/api/consultant_doc_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    certificate.diploma = e.url;
                }
            });
        } else {
            $("#certificate-modal .upload-profile p").attr("style", "color: #e71f1f;");
        }
    });
    // modal show & close
    $("#btn-education").click(function () {
        $("#education-modal").addClass('show');
        $("#education-modal").attr('style', 'display: flex;');
    });
    $(".education-close").click(function () {
        $("#education-modal").removeClass('show');
        $("#education-modal").attr('style', 'display: none;');
    });
    $("#btn-work").click(function () {
        $("#experience-modal").addClass('show');
        $("#experience-modal").attr('style', 'display: flex;');
    });
    $(".experience-close").click(function () {
        $("#experience-modal").removeClass('show');
        $("#experience-modal").attr('style', 'display: none;');
    });
    $("#btn-certificate").click(function () {
        $("#certificate-modal").addClass('show');
        $("#certificate-modal").attr('style', 'display: flex;');
    });
    $(".certificate-close").click(function () {
        $("#certificate-modal").removeClass('show');
        $("#certificate-modal").attr('style', 'display: none;');
    });
    // check box & password show
    $('#pwd_show').click(function () {
        var btn_name = $(this).html();
        if (btn_name == 'Show' || btn_name == 'Forestilling') {
            if (btn_name == 'Show') {
                $(this).html('Hide');
            } else if (btn_name == 'Forestilling') {
                $(this).html('Gjemme seg');
            }
            $('#password').attr('type', 'text');
        } else {
            if (btn_name == 'Hide') {
                $(this).html('Show');
            } else if (btn_name == 'Gjemme seg') {
                $(this).html('Forestilling');
            }
            $('#password').attr('type', 'password');
        }
    });
    $("#terms").click(function () {
        if ($(this).prop("checked")) {
            $("#terms_check").removeClass("error");
        } else {
            $("#terms_check").addClass("error");
        }
    });
    $("#photo-confirmation").click(function () {
        if ($(this).prop("checked")) {
            $("#photo_check").removeClass("error");
        } else {
            $("#photo_check").addClass("error");
        }
    });
    // set content on modals
    $("#education-save").click(function (event) {
        event.preventDefault();
        if ($("#education-form").valid()) {
            education.id = consultant.docs.educations.length;
            education.from = $("#edu_from_date").val();
            education.to = $("#edu_to_date").val();
            education.institution = $("#institution").val();
            education.major = $("#major").val();
            education.degree = $("#degree").val();
            education.description = $("#edu_description").val();
            consultant.docs.educations.push(education);
            var content = `<div class="item education${education.id}"><div class="date-sec">${education.from} - ${education.to}</div><div class="main-sec"><p><b>${education.degree} - ${education.major}</b></p><p>${education.institution}</p>`;
            if (education.diploma) {
                content += `<p class="diploma">Dimploma uploaded</p>`;
            }
            content += `</div><div class="btn-sec" id="education${education.id}">Remove</div><script>$('.btn-sec').click(function(){var id = $(this).attr('id'); remove(id);});</` + `script></div>`;
            $("#education-list").append(content);
            $("#education-list").attr('style', 'display: block;');
            $("#education-modal").removeClass('show');
            $("#education-modal").attr('style', 'display: none;');
            education = {};
        }
    });
    $("#experience-save").click(function (event) {
        event.preventDefault();
        if ($("#experience-form").valid()) {
            experience.id = consultant.docs.experiences.length;
            experience.from = $("#experience_from_date").val();
            experience.to = $("#experience_to_date").val();
            experience.company = $("#experience_company").val();
            experience.position = $("#experience_position").val();
            experience.country = $("#experience_country").val();
            experience.city = $("#experience_city").val();
            experience.description = $("#experience_description").val();
            consultant.docs.experiences.push(experience);
            var content = `<div class="item experience${experience.id}"><div class="date-sec">${experience.from} - ${experience.to}</div><div class="main-sec"><p><b>${experience.position}</b></p><p>${experience.company} - ${experience.country} ${experience.city}</p><p>${experience.description}</p></div><div class="btn-sec" id="experience${experience.id}">Remove</div><script>$('.btn-sec').click(function(){var id = $(this).attr('id'); remove(id);});</` + `script></div>`;
            $("#experience-list").append(content);
            $("#experience-list").attr('style', 'display: block;');
            $("#experience-modal").removeClass('show');
            $("#experience-modal").attr('style', 'display: none;');
            experience = {};
        }
    });
    $("#certificate-save").click(function (event) {
        event.preventDefault();
        if ($("#certificate-form").valid()) {
            certificate.id = consultant.docs.certificates.length;
            certificate.date = $("#certificate_date").val();
            certificate.name = $("#certificate_name").val();
            certificate.institution = $("#certificate_institution").val();
            certificate.description = $("#certificate_description").val();
            consultant.docs.certificates.push(certificate);
            var content = `<div class="item certificate${certificate.id}"><div class="date-sec">${certificate.date}</div><div class="main-sec"><p><b>${certificate.name}</b></p><p>${certificate.institution}</p>`;
            if (certificate.diploma) {
                content += `<p class="diploma">Dimploma uploaded</p>`;
            }
            content += `</div><div class="btn-sec" id="certificate${certificate.id}">Remove</div><script>$('.btn-sec').click(function(){var id = $(this).attr('id'); remove(id);});</` + `script></div>`;
            $("#certificate-list").append(content);
            $("#certificate-list").attr('style', 'display: block;');
            $("#certificate-modal").removeClass('show');
            $("#certificate-modal").attr('style', 'display: none;');
            certificate = {};
        }
    });
    function remove(id) {
        $("." + id).remove();
        if (id.includes('education')) {
            var index = consultant.docs.educations.map(x => { return x.id;}).indexOf(id);
            consultant.docs.educations.splice(index, 1);
            if (consultant.docs.educations.length == 0) {
                $("#education-list").attr('style', 'display: none;');
            }
        } else if (id.includes('experience')) {
            var index = consultant.docs.experiences.map(x => { return x.id;}).indexOf(id);
            consultant.docs.experiences.splice(index, 1);
            if (consultant.docs.experiences.length == 0) {
                $("#experience-list").attr('style', 'display: none;');
            }
        } else {
            var index = consultant.docs.certificates.map(x => { return x.id;}).indexOf(id);
            consultant.docs.certificates.splice(index, 1);
            if (consultant.docs.certificates.length == 0) {
                $("#consultant-list").attr('style', 'display: none;');
            }
        }
    };
    // form submit
    $(".btn-submit").click(function (event) {
        event.preventDefault();
        if ($("#consultant-form").valid()) {
            if ($("#phone").intlTelInput("isValidNumber")) {
                if (consultant.docs.educations.length > 0 && consultant.docs.experiences.length > 0) {
                    $(".step6 h5").attr("style", "color: #000;");
                    if ($("#terms").prop("checked") && $("#photo-confirmation").prop("checked")) {
                        $("#photo_check").removeClass("error");
                        $("<input>").attr({ name: "ex_phone", type: "hidden", value: $("#phone").intlTelInput("getNumber") }).appendTo("#consultant-form");
                        $("<input>").attr({ name: "phone_contact", type: "hidden", value: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0 }).appendTo("#consultant-form");
                        $("<input>").attr({ name: "chat_contact", type: "hidden", value: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0 }).appendTo("#consultant-form");
                        $("<input>").attr({ name: "video_contact", type: "hidden", value: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0 }).appendTo("#consultant-form");
                        $("<input>").attr({ name: "education_count", type: "hidden", value: consultant.docs.educations.length }).appendTo("#consultant-form");
                        $("<input>").attr({ name: "experience_count", type: "hidden", value: consultant.docs.experiences.length }).appendTo("#consultant-form");
                        $("<input>").attr({ name: "certificate_count", type: "hidden", value: consultant.docs.certificates.length }).appendTo("#consultant-form");
                        consultant.docs.educations.forEach(item => {
                            $("<input>").attr({ name: "education" + item.id + "_from", type: "hidden", value: item.from }).appendTo("#consultant-form");
                            $("<input>").attr({ name: "education" + item.id + "_to", type: "hidden", value: item.to }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "education" + item.id + "_institution", type: "hidden", value: item.institution }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "education" + item.id + "_major", type: "hidden", value: item.major }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "education" + item.id + "_degree", type: "hidden", value: item.degree }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "education" + item.id + "_description", type: "hidden", value: item.description }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "education" + item.id + "_diploma", type: "hidden", value: item.diploma }).appendTo("#consultant-form"); 
                        });
                        consultant.docs.experiences.forEach(item => {
                            $("<input>").attr({ name: "experience" + item.id + "_from", type: "hidden", value: item.from }).appendTo("#consultant-form");
                            $("<input>").attr({ name: "experience" + item.id + "_to", type: "hidden", value: item.to }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "experience" + item.id + "_company", type: "hidden", value: item.company }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "experience" + item.id + "_position", type: "hidden", value: item.position }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "experience" + item.id + "_country", type: "hidden", value: item.country }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "experience" + item.id + "_city", type: "hidden", value: item.city }).appendTo("#consultant-form"); 
                            $("<input>").attr({ name: "experience" + item.id + "_description", type: "hidden", value: item.description }).appendTo("#consultant-form"); 
                        });
                        if (consultant.docs.certificates.length > 0) {
                            consultant.docs.certificates.forEach(item => {
                                $("<input>").attr({ name: "certificate" + item.id + "_date", type: "hidden", value: item.date }).appendTo("#consultant-form");
                                $("<input>").attr({ name: "certificate" + item.id + "_name", type: "hidden", value: item.name }).appendTo("#consultant-form"); 
                                $("<input>").attr({ name: "certificate" + item.id + "_institution", type: "hidden", value: item.institution }).appendTo("#consultant-form"); 
                                $("<input>").attr({ name: "certificate" + item.id + "_description", type: "hidden", value: item.description }).appendTo("#consultant-form"); 
                                $("<input>").attr({ name: "certificate" + item.id + "_diploma", type: "hidden", value: item.diploma }).appendTo("#consultant-form"); 
                            });
                        }
                        $("#consultant-form").submit();
                    } else {
                        if ($("#terms").prop("checked") !== true && $("#photo-confirmation").prop("checked") !== true) {
                            $("#terms_check").addClass("error");
                            $("#photo_check").addClass("error");
                        } else if ($("#terms").prop("checked") !== true) {
                            $("#terms_check").addClass("error");
                        } else if ($("#photo-confirmation").prop("checked") !== true) {
                            $("#photo_check").addClass("error");
                        }
                    }
                } else {
                    $(".step6 h5").attr("style", "color: #e71f1f;");
                }
            }
        }
    });

    var init = function () {
        $("#timezone").timezones();
        $("#phone").intlTelInput({
            allowDropdown: true,
            autoHideDialCode: false,
            autoPlaceholder: "polite",
            dropdownContainer: "body",
            preferredCountries: ['no', 'se', 'gb', 'de', 'us'],
            utilsScript: "/js/utils.js"
        });
        $(".date-picker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: 'mm/dd/yyyy',
            changeMonth: true,
            changeYear: true,
            yearRange: '-110:-18'
        });
        $(".yearpicker").yearpicker();
        $('#consultant-form').validate({
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
        $('#education-form').validate({
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
        $('#experience-form').validate({
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
        $('#certificate-form').validate({
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
    };
    init();
</script>
@endsection