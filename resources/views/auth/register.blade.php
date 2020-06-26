@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="container">
	<div class="col-12 create-account">
		<div class="create-account-left">
			<div class="login-sec create-acc d-flex flex-column">
				@if($lang == 'en')
				<h1>{!! $data->header->en_title !!}</h1>
				<span style="text-align: center!important;">{!! $data->header->en_des !!}</span>
				@else
				<h1>{!! $data->header->no_title !!}</h1>
				<span style="text-align: center!important;">{!! $data->header->no_des !!}</span>
				@endif
				<form id="register-form" class="pt-3" method="POST" action="{{ url('register') }}">
					@csrf
					<div class="form-group">
						<label for="first_name">@lang('forms.first_name')</label>
						<input type="text" class="form-control" id="first_name" name="first_name" required>
					</div>
					<div class="form-group">
						<label for="last_name">@lang('forms.last_name')</label>
						<input type="text" class="form-control" id="last_name" name="last_name" required>
					</div>
					<div class="form-group">
						<label for="email">@lang('forms.email')</label>
						<input type="email" class="form-control" id="email" name="email" required>
						@if ($errors->has('email'))
						<span class="feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group">
						<label for="phone">@lang('forms.phone')</label>
						<input type="text" class="form-control" id="phone" name="phone" required>
					</div>
					<div class="form-group">
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
					</div>
					<div class="form-btn d-flex">
						<button type="submit" class="btn btn-primary register">@lang('forms.sign_up')</button>
        	</div>
				</form>
			</div>
			<div class="bottom-link d-flex justify-content-center pt-2">
				<a class="nav-link" href="{{$lang=='en' ? url('/login') : url('/no/logg-inn')}}">@lang('forms.login_account')</a>
			</div>
		</div>
		<div class="create-account-right">
			<?php $count = count($data->list); ?>
			@foreach($data->list as $key => $item)
				@if($key == 0)
					<div class="des-item">
				@elseif ($key % 2 ==0)
					</div><div class="des-item">
				@endif
				<div class="figure-div">
					<img src="{{ $item->path }}" alt="logo" />
					<div class="description">
						<p class="m-0">
							<b>@if($lang == 'en'){{$item->en_title}}@else{{$item->no_title}}@endif</b>
						</p>
						<p class="m-0">				
							@if($lang == 'en')
							{!! $item->en_txt !!}
							@else
							{!! $item->no_txt !!}
							@endif
						</p>
					</div>
				</div>
				@if ($key == $count -1)
					</div>
				@endif
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
		new gotoconsult.Controllers.authenticator();
		new gotoconsult.Controllers.register();
	});
</script>
@endsection