<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid wraper">
  <a class="navbar-brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/logo.png')}}" alt="logo"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <div class="end-nav ml-auto">
        {{--  <a class="notify-count" href=""> <img src="{{ asset('images/bell-icon.png')}}" alt="icon"/> <span>2</span></a>  --}}       
        @if(auth()->user())
        <div class="dropdown">
          <button type="button" class="btn btn-primary nav-right dropdown-toggle user-btn" data-toggle="dropdown">
            <img src="{{asset('images/user-profile.png')}}" alt="icon"><span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
          </button>
          <div class="dropdown-menu profile-dropdown">
            @if(Auth::user()->role=='consultant')
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/find-customer') : url('/no/finn-kunde') }}">@lang('member.my_customers')</a>
            @elseif(Auth::user()->role=='customer')
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('member.my_consultants')</a>
            @endif
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/prepaid-card') : url('/no/kontantkort') }}">@lang('member.prepaid_card')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/invoice') : url('/no/fakturaer') }}">@lang('member.invoices')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">@lang('member.settings')</a>
            <a class="dropdown-item" href="{{url('/logout')}}">@lang('member.log_out')</a>
          </div>
        </div>
        @endif
        <div class="dropdown">
          <form id="member-lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input id="member_site_lang" class="form-control" readonly>
            <input type="text" id="member_selected_lang" name="lang" hidden>
            <input type="text" id="member_current_address" name="address" hidden>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>
