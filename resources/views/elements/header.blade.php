<?php
use Jenssegers\Agent\Agent as Agent;
$agent = new Agent();
?>
<nav class="navbar navbar-expand-lg sticky">
  <div class="container">
    <div class="col-12 d-flex">
      @if($agent->isDesktop())
      <a class="navbar-brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
      @else
        @if($agent->isTablet())
        <a class="navbar-brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
        @else
        <a class="navbar-brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/color-logo.svg')}}" alt="logo"/></a>
        @endif
      @endif
      <div class="ml-auto align-self-center">
        <button class="navbar-toggler">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <div class="collapse navbar-collapse desktop">
          <ul class="end-nav ml-auto mr-3">
            <li class="nav-item active">
              <a class="nav-link disabled" href="{{ $lang == 'en' ? url('/features') : url('/no/funksjoner') }}">@lang('header.features') </a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('header.about_us')</a>
            </li>
            @if(!auth()->user())
            <li class="nav-item">
              <a class="nav-link disabled" href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('header.login')</a>
            </li>
            @endif
          </ul>
          @if(auth()->user() && auth()->user()->role == 'customer')
          <div class="end-nav ml-auto">
            <a class="nav-link" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('header.find_consultant')</a>
          </div>
          @endif
          <div class="end-nav">
            @if(!auth()->user())
            <a class="nav-link mr-3" href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('header.become_consultant') </a>
            <a class="nav-link" href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('header.register')</a>
            @if(auth()->user() && auth()::user()->role == 'customer')
            <a class="nav-link" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('header.find_consultant')</a>
            @endif
            @endif
          
            @if(auth()->user())
            <div class="dropdown">
              <button type="button" class="btn nav-right dropdown-toggle user-btn" data-toggle="dropdown">
                <img src="{{asset('images/user.svg')}}" alt="icon"><span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
              </button>
              <div class="dropdown-menu profile-dropdown">
                @if(Auth::user()->role=='admin')
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">@lang('header.customers')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">@lang('header.consultants')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}">@lang('header.categories')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}">@lang('header.pages')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">@lang('header.settings')</a>
                <a class="dropdown-item" href="{{url('/logout')}}">@lang('header.log_out')</a>
                @else
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}">@lang('member.dashboard')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/sessions') : url('/no/moter') }}">@lang('member.my-sessions')</a>
                @if(Auth::user()->role=='customer')
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/wallet') : url('/no/lommebok') }}">@lang('member.wallet')</a>
                @endif
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/transactions') : url('/no/transaksjoner') }}">@lang('member.my-transaction')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/profile') : url('/no/profil') }}">@lang('member.profile')</a>
                <a class="dropdown-item" href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('member.settings')</a>
                <a class="dropdown-item" href="{{url('/logout')}}">@lang('header.log_out')</a>
                @endif
              </div>
            </div>
            <div class="dropdown">
              <form class="lang-form" method="post" action="{{url('/site-lang')}}">
                {{ csrf_field() }}
                <input type="text" class="selected_lang" name="lang" hidden>
                <input type="text" class="current_address" name="address" hidden>
                <button type="submit" class="btn public-btn-country">
                  @if($lang == 'en')
                    <img src="{{ asset('images/norsk.svg')}}" />
                  @else
                    <img src="{{ asset('images/english.svg')}}" />
                  @endif
                </button>
              </form>
            </div>
            @endif
            @if(!auth()->user())
            <div class="dropdown">
              <form class="lang-form" method="post" action="{{url('/site-lang')}}">
                {{ csrf_field() }}
                <input type="text" class="selected_lang" name="lang" hidden>
                <input type="text" class="current_address" name="address" hidden>
                <button type="submit" class="btn public-btn-country">
                  @if($lang == 'en')
                    <img src="{{ asset('images/norsk.svg')}}" />
                  @else
                    <img src="{{ asset('images/english.svg')}}" />
                  @endif
                  </button>
                </form>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<section class="navbar-sidebar">
  <div class="navbar-sidebar__overlay"></div>
  <div class="navigation__nav">
    <div class="navigation-header">
      <div class="container">
        <div class="col-12 d-flex">
          <a class="navigation__brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
          <div class="ml-auto align-self-center">
            <button class="navigation-toggler">
              <span></span>
              <span></span>
              <span></span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content">
      <div class="item-list">
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/features') : url('/no/funksjoner') }}">@lang('header.features') </a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('header.about_us')</a>
        </div>
        @if(!auth()->user())
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('header.login')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('header.become_consultant') </a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('header.register')</a>
        </div>
        @else
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/dashboard') : url('/no/oversikt') }}">@lang('member.dashboard')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/sessions') : url('/no/moter') }}">@lang('member.my-sessions')</a>
        </div>
        @if(auth()->user()->role == 'customer')
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/wallet') : url('/no/lommebok') }}">@lang('member.wallet')</a>
        </div>
        @endif
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/transactions') : url('/no/transaksjoner') }}">@lang('member.my-transaction')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/profile') : url('/no/profil') }}">@lang('member.profile')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('member.settings')</a>
        </div>
        <div class="nav-item">
          <a href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('header.find_consultant')</a>
        </div>
        <div class="nav-item">
          <a href="{{url('/logout')}}">@lang('member.log_out')</a>
        </div>
        @endif
        <div class="nav-item">
          <form class="lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input type="text" class="selected_lang" name="lang" hidden>
            <input type="text" class="current_address" name="address" hidden>
            <button type="submit" class="btn public-btn-country">
              @if($lang == 'en')
                <img src="{{ asset('images/norsk.svg')}}" />
              @else
                <img src="{{ asset('images/english.svg')}}" />
              @endif
            </button>
          </form>
        </div>
      </div>    
    </div>
  </div>
</section>