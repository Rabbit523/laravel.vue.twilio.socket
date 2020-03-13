@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="create-account d-flex">
    <div class="create-account-left">
        <div class="login-sec create-acc d-flex flex-column">
            <img src="{{ $data->header->path }}" alt="logo"/>
            @if($lang == 'en')
            <h2>{!! $data->header->en_title !!}</h2>
            <span style="text-align: center!important;">{!! $data->header->en_des !!}</span>
            @else
            <h2>{!! $data->header->no_title !!}</h2>
            <span style="text-align: center!important;">{!! $data->header->no_des !!}</span>
            @endif
            <form id="register-form" method="POST" action="{{ url('register') }}">
                @csrf
                <div class="form-group check-form top-check">
                    <input type="checkbox" id="html1" name="checkbox">
                    <label for="html1">@lang('register.consultant')</label> 
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="first_name" placeholder="@lang('register.first_name') *" name="first_name" required>
                    @if($errors->has('first_name'))
                    <div class="alert alert-danger">
                        <ul>{{$errors->first('first_name')}}</ul>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="last_name" placeholder="@lang('register.last_name') *" name="last_name" required>
                    @if($errors->has('last_name'))
                    <div class="alert alert-danger">
                        <ul>{{$errors->first('last_name')}}</ul>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <select id="industry_expertise"  class="drop-box" name="industry_expertise" required>
                        <option selected disabled hidden>@lang('register.expertise') *</option>
                        @foreach($categories as $category)
                        <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('industry_expertise'))
                <div class="alert alert-danger">
                    <ul>{{$errors->first('industry_expertise')}}</ul>
                </div>
                @endif
                <div class="form-group">
                    <input type="text" class="form-control" id="phone" placeholder="@lang('register.phone') *" name="phone" required>
                    @if($errors->has('phone'))
                    <div class="alert alert-danger">
                        <ul>{{$errors->first('phone')}}</ul>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="@lang('register.email') *" name="email" required>
                    @if($errors->has('email'))
                    <div class="alert alert-danger">
                        <ul>{{$errors->first('email')}}</ul>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="@lang('register.create_password') *" name="password" required>
                    @if($errors->has('password'))
                    <div class="alert alert-danger">
                        <ul>{{$errors->first('password')}}</ul>
                    </div>
                    @endif
                </div>
                <div class="form-group check-form top-check">			  
                    <div class="l-ch">
                        <input type="checkbox" id="html2">
                        <label for="html2"></label>
                        <small>@lang('register.read_accept') <b>@lang('register.terms')</b> @lang('register.and') <b>@lang('register.privacy').</b></small>
                    </div>
                </div>
                <div class="form-btn d-flex">
                    <a href="{{$lang=='en' ? url('/login') : url('/no/logg-inn')}}">@lang('register.login')</a>
                    <button type="submit" class="btn btn-primary register">@lang('register.create_account')</button>
                </div>
            </form>
        </div>
        <div class="bottom-link c-a-bottom d-flex">
            <a href="{{$lang=='en' ? url('/') : url('/no')}}">@lang('register.back_home')</a> 
            <a href="{{$lang=='en' ? url('/privacy') : url('/no/personvern')}}">@lang('register.privacy')</a>
            <img src="{{asset('images/dot.png')}}" alt="dot"/>
            <a href="{{$lang=='en' ? url('/terms-customer') : url('/no/vilkar-kunde')}}">@lang('register.terms')</a>
        </div>
    </div>        
    <div class="create-account-right">
        @if($lang == 'en')
        <h2>{!! $data->header->en_list_title !!}</h2>
        @else
        <h2>{!! $data->header->no_list_title !!}</h2>
        @endif
        @foreach($data->list as $key => $item)
        <p>
            <img src="{{ $item->path }}" alt="logo"/>
            @if($lang == 'en')
            {!! $item->en_txt !!}
            @else
            {!! $item->no_txt !!}
            @endif
        </p>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(".register").click(function (event) {
        event.preventDefault();
        if ($("#register-form").valid()) {
            $("#register-form").submit();
        }
    });
</script>
@endsection
