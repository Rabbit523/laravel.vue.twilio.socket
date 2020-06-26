@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
	@if(Auth::check())
	@include('elements.member_sidebar')
	<div class="content-wrapper member-content">
	@else
	<div class="content-wrapper member-content no-user">
	@endif
		<svg width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg">
			<defs>
				<linearGradient id="MyGradient" x1="0%" y1="0%" x2="0%" y2="100%">
					<stop offset="5%" stop-color="#6c9cff" />
					<stop offset="95%" stop-color="#8773ff" />
				</linearGradient>
			</defs>
		</svg>
		@if(!Auth::check())
		<div class="container">
		<div class="col-12">
		@endif
		<div class="profile-card-left">
			<div class="profile-header">
				@if($user_info->profile && $user_info->profile->cover_img)
				<div class="profile-cover" style="background-image: url('{{ $user_info->profile->cover_img}}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
				@else
				<div class="profile-cover">
					<img src="{{asset('images/white-logo.svg')}}" />
				@endif
				<?php 
					$origin_url = $_SERVER['REQUEST_URI'];
					if ($lang == 'en') {
						$val = explode("/profile", $origin_url);
					} else {
						$val = explode("/no/profil", $origin_url);
					}
				?>
				@if($val[1] == "")
					<button class="btn-edit-profile">@lang('member.edit-profile')</button>
				@endif
				</div>
				<div class="profile-card profile-sub-header">
					@if($user_info->profile && $user_info->profile->avatar)
					<div class="avatar-pic" style="background-image: url('{{ $user_info->profile->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;">
					@else
					<div class="avatar-pic">
						<img src="{{asset('images/white-logo.svg')}}" />
						<div class="default-pic">
							<img src="{{asset('images/photo-camera.svg')}}" alt="no-img" />
						</div>
					@endif
					</div>
					<div class="detail-info">
						@if($user_info->user->role == 'consultant' && $agent->isMobile())
						{{$user_info->hourly_rate}} kr pr.minute
						@endif
						<h2>{{$user_info->user->first_name}} {{$user_info->user->last_name}}</h2>
						@if($user_info->profile && $user_info->profile->profession)
						<div class="details">
							@if($user_info->user->role == 'consultant')
							<span>
								<img src="{{asset('images/portfolio.svg')}}" alt="no-img" />
								{{$user_info->profile->profession}}
							</span>
							@if($user_info->profile->college && !$agent->isMobile())
							<span>
								<img src="{{asset('images/mortarboard.svg')}}" alt="no-img" />
								{{$user_info->profile->college}}
							</span>
							@endif
							@if(!$agent->isMobile())
							<span>
								<img src="{{asset('images/pin.svg')}}" alt="no-img" />
								@lang('member.from') {{$user_info->profile->from}}
							</span>
							<span>
								<img src="{{asset('images/home.svg')}}" alt="no-img" />
								@lang('member.lives-in') {{$user_info->profile->region}}, {{$user_info->profile->country}}
							</span>
							@endif
							@else
								<span>
									<img src="{{asset('images/pin.svg')}}" alt="no-img" />
									@lang('member.from') {{$user_info->profile->from}}
								</span>
								@if(!$agent->isMobile())
								<span>
									<img src="{{asset('images/home.svg')}}" alt="no-img" />
									@lang('member.lives-in') {{$user_info->profile->region}}, {{$user_info->profile->country}}
								</span>
								@endif
							@endif
						</div>
						@else
						<div class="no-details">
							@lang('member.no-details')
							<button class="btn-edit-profile btn-no-info">@lang('member.edit-details')</button>
						</div>
						@endif
					</div>
				</div>
				<div class="mobile-tab-view">
					<div class="tab about active">
						<img src="{{asset('images/profile-icon-w.svg')}}" alt="">@lang('member.about')
					</div>
					<div class="tab sessions">
						<img src="{{asset('images/comment.svg')}}" alt="">@lang('member.sessions')
					</div>
					<div class="tab reviews">
						<img src="{{asset('images/star.svg')}}" alt="">@lang('member.reviews')
					</div>
				</div>
			</div>
			<div class="profile-card about">
				<div class="header">
					<h3>@lang('member.about-me')</h3>
					<p>@lang('member.member-since') {{$user_info->user->created_at}}</p>
				</div>
				<div class="body">
					@if ($user_info->profile && $user_info->profile->description)
					{!!$user_info->profile->description!!}
					@else
					<p>@lang('member.no-about-us')</p>
					<button class="btn-edit-profile btn-no-info">@lang('member.edit-information')</button>
					@endif
				</div>
			</div>
			<div class="profile-card sessions">
				<div class="rate-charts">
					<div class="chart-sec">
						<div class="header">
							<h3>@lang('member.completed-sessions')</h3>
						</div>
						<div class="chart-body">
							<div class="completed-session-chart" id="completed-session-chart"></div>
						</div>
					</div>
					@if(Auth::check() && auth()->user()->role == 'consultant')
					<div class="chart-sec">
						<div class="header">
							<h3>@lang('member.response-rate')</h3>
						</div>
						<div class="chart-body">
							<div class="response-rate-chart" id="response-rate-chart"></div>
						</div>
					</div>
					@endif
				</div>
			</div>
			<div class="profile-card reviews">
				<div class="header">
					<h3>@lang('member.reviews')</h3>
				</div>
				<div class="body review-sec">
					<?php $count = count($review_info); ?>
					@if($count > 0)
						@foreach($review_info as $key => $review)
							@if($key == 0)
							<div class="review-group">
							@elseif($key %2 == 0)
							</div>
							<div class="review-group">
							@endif						
							<div class="review" style="{{$key > 5 ? 'display: none' : ''}}">
								<div class="review-header">
									<div class="review-personal-info">
										@if($review->type == 'CUSTOCON' && $review->customer->profile && $review->customer->profile->avatar)
										<div class="review-avatar mr-3" style="background-image: url('{{ $review->customer->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
										@elseif($review->type == 'CONTOCUS' && $review->consultant->profile && $review->consultant->profile->avatar)
										<div class="review-avatar mr-3" style="background-image: url('{{ $review->consultant->profile->avatar }}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
										@else
										<div class="review-avatar mr-3">
											<img src="{{asset('images/white-logo.svg')}}" />
										</div>
										@endif
										<div class="review-info">
											@if($review->type == 'CUSTOCON' && $review->customer->user)
											<p class="m-0"><b>{{$review->customer->user->first_name}} {{$review->customer->user->last_name}}</b></p>
											@elseif($review->type == 'CONTOCUS' && $review->consultant->user)
											<p class="m-0"><b>{{$review->consultant->user->first_name}} {{$review->consultant->user->last_name}}</b></p>
											@endif
											<?php $newDate = date('M d, Y', strtotime($review->created_at));?>
											<p class="m-0">
												@if($review->session < 2)
												{{$review->session}} session
												@else
												{{$review->session}} sessions
												@endif
												&#183; {{$newDate}}
											</p>
										</div>
									</div>
									<div class="review-rate d-flex">
										@if($review->rate > 4.5)
										<div class="rate-stars d-flex pr-2">
											<img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-dg.png')}}" alt="no-image"/>
										</div>
										@elseif($review->rate > 3.5)
										<div class="rate-stars d-flex pr-2">
											<img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-g.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
										</div>
										@elseif($review->rate > 2.5)
										<div class="rate-stars d-flex pr-2">
											<img src="{{asset('images/home/star-y.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-y.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-y.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
										</div>
										@elseif($review->rate > 1.5)
										<div class="rate-stars d-flex pr-2">
											<img src="{{asset('images/home/star-o.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-o.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
										</div>
										@elseif($review->rate > 0.5)
										<div class="rate-stars d-flex pr-2">
											<img src="{{asset('images/home/star-r.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
										</div>
										@else
										<div class="rate-stars d-flex pr-2">
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
											<img src="{{asset('images/home/star-w.png')}}" alt="no-image"/>
										</div>
										@endif
										{{$review->rate}}.0
									</div>
								</div>
								<div class="review-body">
									{{$review->description}}
								</div>
							</div>
							@if($key == $count -1)
							</div>
							@endif
						@endforeach
						@if($count > 6)
						<div id="loadMore" style="">
							<a href="#">@lang('member.view-more')</a>
						</div>
						@endif
					@else
						<p>@lang('member.no-reviews')</p>
					@endif
				</div>
			</div>		
			<div class="modal fade" id="edit-profile-modal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3>@lang('member.edit-profile')</h3>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						</div>
						<div class="modal-body">
							<div class="edit-cover-photo">
								<div class="imageupload">
									<label class="btn cover-file">
										<img src="{{asset('images/photo-camera.svg')}}" />
										<input type="file" id="upload_cover" name="image-file">
									</label>
								</div>
							</div>
							<div class="edit-profile-photo my-3">
								<div class="preview-profile-photo">
									@if($user_info->profile && !$user_info->profile->avatar)
									<img src="{{asset('images/white-logo.svg')}}" />
									@endif
								</div>
								<div class="profile-photo">
									<label>@lang('member.edit-profile-photo')</label>
									<p>@lang('member.edit-profile-photo-text')</p>
									<button class="btn upload-profile-photo">@lang('member.upload')</button>
									<input type="file" id="upload_profile" name="image-file">
								</div>
							</div>
							<div class="basic-info">
								<label>@lang('member.profile_settings')</label>
								<form class="basic-form">
									<div class="row m-0">
										<div class="form-group">
											<label>@lang('member.first_name')</label>
											<input type="text" id="first_name" name="first_name" value="{{$user_info->user->first_name}}" required/>
										</div>
										<div class="form-group">
											<label>@lang('member.last_name')</label>
											<input type="text" id="last_name" name="last_name" value="{{$user_info->user->last_name}}" required/>
										</div>
									</div>
									<div class="row m-0">
										<div class="form-group">
											<label>@lang('member.email')</label>
											<input type="text" id="email" name="email" value="{{$user_info->user->email}}" required/>
										</div>
										<div class="form-group">
											<label>@lang('member.phone')</label>
											<input type="text" id="phone" name="phone" value="{{$user_info->user->phone}}" required/>
										</div>
									</div>
									<div class="row m-0">
										<div class="form-group">
											<label>@lang('member.profession')</label>
											<select class="profession" name="profession" required>
												<option @if($user_info->profile && $user_info->profile->profession == 'psychologists') {{'selected'}} @endif value="psychologists">Psychologists</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'economists') {{'selected'}} @endif value="economists">Economists</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'lawyers') {{'selected'}} @endif value="lawyers">Lawyers</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'doctors') {{'selected'}} @endif value="doctors">Doctors</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'nurses') {{'selected'}} @endif value="nurses">Nurses</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'veterinarians') {{'selected'}} @endif value="veterinarians">Veterinarians</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'astrologers') {{'selected'}} @endif value="astrologers">Astrologers</option>
												<option @if($user_info->profile && $user_info->profile->profession == 'teachers') {{'selected'}} @endif value="teachers">Teachers</option>
											</select>
										</div>
										<div class="form-group">
											<label>@lang('member.from')</label>
											<select class="crs-country" id="from" name="from" required></select>
										</div>
									</div>
									<div class="row m-0">
										<div class="form-group">
											<label>@lang('member.college')</label>
											<select class="university-list" name="university" required></select>
										</div>
									</div>
									<div class="row m-0 three">
										<div class="form-group">
											<label>@lang('member.country')</label>
											<select class="crs-country" id="country" name="country" data-region-id="region" required></select>
										</div>
										<div class="form-group">
											<label>@lang('member.region')</label>	
											<select id="region" name="region" required></select>
										</div>
										<div class="form-group">
											<label>@lang('member.timezone')</label>	
											<select id="timezone" name="timezone" required></select>
										</div>
									</div>
									<div class="row m-0">
										<div class="form-group">
											<label>@lang('member.about-me')</label>
											<textarea id="description" name="description"></textarea>
										</div>
									</div>
									<input type="submit" class="btn-save" id="profile_save" value="@lang('member.save')">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if(!Auth::check())
		</div>
		</div>
		@endif
	</div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
		var user_info = @json($user_info);
		var review_info = @json($review_info);
		var chart_info = @json($chart_info);
		new gotoconsult.Controllers.public(user_info);
		new gotoconsult.Controllers.profile(user_info, review_info, chart_info);
	});
</script>
@endsection
