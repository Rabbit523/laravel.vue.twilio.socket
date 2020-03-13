<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid wraper">
  <a class="navbar-brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/logo.png')}}" alt="logo"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <div class="dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            @lang('header.categories')
            </button>
            <div class="dropdown-menu">
              @foreach ($categories as $key => $category)
              <?php $route = $category->category_url ?>
              @if($lang == 'en')
              <a class="dropdown-item" href="{{url('/category/').'/'.$route}}">{{$category->category_name}}</a>
              @else
              <a class="dropdown-item" href="{{url('/no/kategori/').'/'.$route}}">{{$category->category_name_no}}</a>
              @endif
              @endforeach
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('header.become_consultant') </a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('header.about_us')</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="{{ $lang == 'en' ? url('/faq') : url('/no/faq') }}">@lang('header.faq')</a>
        </li>
      </ul>

      <div class="end-nav">
        @if(!auth()->user())
        <a class="nav-log" href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('header.login')</a>
        <a class="btn" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">	@lang('header.find_consultant') </a>
        @endif
        {{--  <a class="notify-count" href=""> <img src="{{ asset('images/bell-icon.png')}}" alt="icon"/> <span>2</span></a>  --}}
       
        @if(auth()->user())
        <div class="dropdown">
          <button type="button" class="btn btn-primary nav-right dropdown-toggle user-btn" data-toggle="dropdown">
            <img src="{{asset('images/user-profile.png')}}" alt="icon"><span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
          </button>
          <div class="dropdown-menu profile-dropdown">
            @if(Auth::user()->role=='consultant')
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/find-customer') : url('/no/finn-kunde') }}">@lang('header.my_customers')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/prepaid-card') : url('/no/kontantkort') }}">@lang('header.prepaid_card')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/invoice') : url('/no/fakturaer') }}">@lang('header.invoices')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('header.settings')</a>
            <a class="dropdown-item" href="{{url('/logout')}}">@lang('header.log_out')</a>
            @elseif(Auth::user()->role=='customer')
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('header.my_consultants')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/prepaid-card') : url('/no/kontantkort') }}">@lang('header.prepaid_card')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/invoice') : url('/no/fakturaer') }}">@lang('header.invoices')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('header.settings')</a>
            <a class="dropdown-item" href="{{url('/logout')}}">@lang('header.log_out')</a>
            @elseif(Auth::user()->role=='admin')
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">@lang('header.customers')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">@lang('header.consultants')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}">@lang('header.categories')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}">@lang('header.pages')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">@lang('header.settings')</a>
            <a class="dropdown-item" href="{{url('/logout')}}">@lang('header.log_out')</a>
            @endif
          </div>
        </div>
        <div class="dropdown">
          <form id="lang-form" method="post" action="{{url('/site-lang')}}" class="pt-2">
            {{ csrf_field() }}
            <input id="site_lang" class="form-control" readonly>
            <input type="text" id="selected_lang" name="lang" hidden>
            <input type="text" id="current_address" name="address" hidden>
          </form>
        </div>
        @endif
        @if(!auth()->user())
        <div class="dropdown">
          <form id="lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input id="site_lang" class="form-control" readonly>
            <input type="text" id="selected_lang" name="lang" hidden>
            <input type="text" id="current_address" name="address" hidden>
          </form>
        </div>
        @endif
      </div>
    </div>
  </div>
</nav>