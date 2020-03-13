@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="login-sec d-flex flex-column">
    <img src="{{ $data->header->path }}" alt="logo"/>
    @if($lang == 'en')
    <h2>{!! $data->header->en_title !!}</h2>
    <span style="text-align: center!important;">{!! $data->header->en_des !!}</span>
    @else
    <h2>{!! $data->header->no_title !!}</h2>
    <span style="text-align: center!important;">{!! $data->header->no_des !!}</span>
    @endif
    <form id="login-form" method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
            <label for="email">@lang('login.email')</label>
            <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"  name="email" value="{{ old('email') }}" required>
            @if ($alert = Session::get('alert-success'))
            <div class="alert alert-warning">{{ $alert }}</div>
            @endif
            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>
        <div class="form-group password-sec">
            <label for="password">@lang('login.password')</label>
            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="pwd" name="password" required>
            @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
            <div class="forgot-pass d-flex">
                <a href="{{ url('password/reset') }}">@lang('login.forgot_password')?</a>
            </div>
        </div>
        <div class="form-btn d-flex">
            <a class="nav-link" href="{{$lang=='en' ? url('/register') : url('/no/registrer')}}">@lang('login.create_account')</a>
			<button type="submit" class="btn btn-primary login">@lang('login.login')</button>
        </div>
    </form>
</div>
		
<div class="bottom-link d-flex">
    <a href="{{$lang=='en' ? url('/') : url('/no')}}">@lang('login.back_home')</a>
    <a href="{{$lang=='en' ? url('/privacy') : url('/no/personvern')}}">@lang('login.privacy')</a>
    <img src="{{ asset('images/dot.png')}}" alt="dot"/>
    <a href="{{$lang=='en' ? url('/terms-customer') : url('/no/vilkar-kunde')}}">@lang('login.terms')</a>
</div>
@endsection

@section('scripts')
<script>
    $(".login").click(function (event) {
        event.preventDefault();
        if ($("#login-form").valid()) {
            $("#login-form").submit();
        }
    });
</script>
@endsection