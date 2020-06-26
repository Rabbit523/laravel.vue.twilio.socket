@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="login-page-container">
    <div class="login-sec">
        @if($lang == 'en')
        <h1>{!! $data->header->en_title !!}</h1>
        <span style="text-align: center!important;">{!! $data->header->en_des !!}</span>
        @else
        <h1>{!! $data->header->no_title !!}</h1>
        <span style="text-align: center!important;">{!! $data->header->no_des !!}</span>
        @endif
        <form id="login-form" class="pt-5" method="POST" action="{{ url('/login') }}">
            @csrf
            @if ($alert = Session::get('alert-success'))
            <div class="alert alert-error">
                {{ $alert }}
            </div>
            @endif
            <div class="form-group">
                <label for="email">@lang('forms.email')</label>
                <input type="email" class="form-control" id="email"  name="email" required>
                @if ($errors->has('email'))
                <span class="feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group password-sec">
                <label for="password">@lang('forms.password')</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @if ($errors->has('password'))
                <span class="feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="d-flex justify-content-between align-items-center pb-3">
                <div class="d-flex align-items-center custom-checkbox">
                    <label>
                        <input type="checkbox" value="" id="remember">@lang('forms.remember-me')
                        <span class="checkmark"></span>
                    </label>
                </div>
                <a href="{{ url('password/reset') }}">@lang('forms.forgot_password')?</a>
            </div>
            <div class="form-btn d-flex">
                <button type="submit" class="btn btn-primary login">@lang('forms.login')</button>
            </div>
        </form>
    </div>
    <div class="bottom-link d-flex justify-content-center pt-2">
        <a class="nav-link" href="{{$lang=='en' ? url('/register') : url('/no/registrer')}}">@lang('forms.create_account')</a>
    </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(function(){
        new gotoconsult.Controllers.authenticator();
        new gotoconsult.Controllers.login();
	});
</script>
@endsection