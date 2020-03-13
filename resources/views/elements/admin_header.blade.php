<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid wraper">
  <a class="navbar-brand" href="{{ $lang == 'en' ? url('/') : url('/no') }}"><img src="{{ asset('images/logo.png')}}" alt="logo"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <div class="end-nav ml-auto">
        <div class="dropdown">
          <button type="button" class="btn btn-primary nav-right dropdown-toggle user-btn" data-toggle="dropdown">
            <img src="{{asset('images/user-profile.png')}}" alt="icon"><span>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/logout')}}">@lang('admin_sidebar.logout')</a>
            <a class="dropdown-item" href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">@lang('admin_sidebar.profile')</a>
          </div>
        </div>
        <div class="dropdown">
          <form id="admin-lang-form" method="post" action="{{url('/site-lang')}}">
            {{ csrf_field() }}
            <input id="admin_site_lang" class="form-control" readonly>
            <input type="text" id="admin_selected_lang" name="lang" hidden>
            <input type="text" id="admin_current_address" name="address" hidden>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>
