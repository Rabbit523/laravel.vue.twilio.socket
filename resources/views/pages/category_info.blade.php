@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="full-cart category">
    <div class="container">
        <div class="col-12 px-3 category-header">
            <div class="img-sec mr-3">
                <img src="{{$category->category_icon}}" alt="icon">
            </div>
            <div class="des-sec">
                @if($lang == 'en')
                <h3 class="text-capitalize">{{$category->category_name}}</h3>
                <p>{{$category->category_description}}</p>
                @else
                <h3 class="text-capitalize">{{$category->category_name_no}}</h3>
                <p>{{$category->category_description_no}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="full-cart consultant-search">
    <div class="container">
        <div class="col-12 d-flex px-3 flex-column">
            <div class="pages-top-sec mt-3">
                <form class="form mr-3">
                    <input type="text" name="search" class="search-input" placeholder="@lang('member.name-keyword')"/>
                </form>
                <div class="sort-section d-flex">
                    <div class="dropdown-box mr-3">
                        <label>@lang('member.price'):</label>
                        <select class="price-sel">
                            <option disabled selected>Default</option>
                            <option value="high-low">High-Low</option>
                            <option value="low-high">Low-High</option>
                        </select>
                    </div>
                    <div class="dropdown-box mr-3">
                        <label>@lang('member.status'):</label>
                        <select class="status-sel">
                            <option disabled selected>All</option>
                            <option value="available">Available</option>
                            <option value="busy">Busy</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.country'):</label>
                        <select class="country-sel">
                            <option disabled selected>All</option>
                        </select>
                    </div>
                    <div class="ml-auto">
                        <label>@lang('member.showing'):</label>
                        <span>{{ $count }} @lang('member.results')</span>
                    </div>
                </div>
            </div>
            <div class="filter-sec mt-3">
                <div class="filter-header">
                    <p>{{$count}} @lang('member.results')</p>
                    <button id="show-filter">@lang('member.filter')</button>
                </div>
                <div class="filter-body">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control search-input" placeholder="@lang('member.name-keyword')"/>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.price'):</label>
                        <select class="price-sel">
                            <option disabled selected>Default</option>
                            <option value="high-low">High-Low</option>
                            <option value="low-high">Low-High</option>
                        </select>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.status'):</label>
                        <select class="status-sel">
                            <option disabled selected>All</option>
                            <option value="available">Available</option>
                            <option value="busy">Busy</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    <div class="dropdown-box">
                        <label>@lang('member.country'):</label>
                        <select class="country-sel">
                            <option disabled selected>All</option>
                        </select>
                    </div>
                </div>
            </div>
            @foreach($consultants as $key => $consultant)
                @if($key == 0)
                    <div class="cart-full">
                @elseif ($key % 4 ==0)
                    </div><div class="cart-full">
                @endif            
                <div class="cart-section d-flex flex-column">
                    @if($consultant->profile && $consultant->profile->avatar)
                        <div class="avatar-pic" style="background-image: url('{{ $consultant->profile->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                    @else
                        <div class="avatar-pic">
                            <img src="/images/white-logo.svg" />
                        </div>
                    @endif
                    @if($consultant->profile)
                    <h3 class="mt-3 mb-0">{{$consultant->profile->profession}}</h3>
                    @endif
                    <h5>{{$consultant->user->first_name}} {{$consultant->user->last_name}}</h5>
                    <small></small>
                    <div class="star-images d-flex">
                        @if($consultant['rate'] == 5)
                        <ul class="d-flex">
                            <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                        </ul>
                        @elseif($consultant['rate'] == 4)
                        <ul class="d-flex">
                            <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        </ul>
                        @elseif($consultant['rate'] == 3)
                        <ul class="d-flex">
                            <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        </ul>
                        @elseif($consultant['rate'] == 2)
                        <ul class="d-flex">
                            <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        </ul>
                        @elseif($consultant['rate'] == 1)
                        <ul class="d-flex">
                            <li><img src="{{asset('images/home/star-r.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        </ul>
                        @else
                        <ul class="d-flex">
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        </ul>
                        @endif
                    </div>
                    <small></small>
                    <div class="rm d-flex justify-content-between">
                        @if($lang == 'en')
                        <a href="{{ url('/profile') }}/{{$consultant->user->id}}" class="text-capitalize">@lang('member.view-profile')</a>
                        @else
                        <a href="{{ url('/no/profil') }}/{{$consultant->user->id}}" class="text-capitalize">@lang('member.view-profile')</a>
                        @endif
                        <p>{{$consultant->hourly_rate}} kr p/m</p>
                    </div>
                    <div class="end-button d-flex">
                        @if($consultant->user->status == "Available")
                        <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                        <button class="btn"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                        <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                        @elseif($consultant->user->status == "Offline")
                        <button class="btn" disabled><img src="{{asset('images/home/ph-g.png')}}" alt="no-img" /></button>
                        <button class="btn" disabled><img src="{{asset('images/home/video-g.png')}}" alt="no-img" /></button>
                        <button class="btn" disabled><img src="{{asset('images/home/msg-g.png')}}" alt="no-img" /></button>
                        @else
                        <button class="btn" disabled><img src="{{asset('images/home/ph-y.png')}}" alt="no-img" /></button>
                        <button class="btn" disabled><img src="{{asset('images/home/video-y.png')}}" alt="no-img" /></button>
                        <button class="btn" disabled><img src="{{asset('images/home/msg-y.png')}}" alt="no-img" /></button>
                        @endif
                    </div>
                </div>
                @if ($key == $count -1)
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="full-cart gd-ppl-words">
    <div class="container">
        <div class="col-12">
            <h2>@lang('home.review-title')</h2>
            <div class="header px-3">
                <p class="customer active">@lang('home.customers')</p>
                <p class="consultant">@lang('home.consultants')</p>
            </div>
            <div class="customer-review mt-3">
                @foreach($review_list as $key=>$review)
                    @if($review->type == 'CUSTOCON')
                        <div class="review">
                            <div class="avatar">
                                @if ($review->customer->profile && $review->customer->profile->avatar)
                                <img src="{{$review->customer->profile->avatar}}">
                                @else
                                <img src="{{asset('images/profile-icon.svg')}}">
                                @endif
                            </div>
                            <div class="description mt-3">
                                <p class="mb-3">"{{$review->description}}"</p>
                                <p><b>{{$review->customer->user->first_name}} {{$review->customer->user->last_name[0]}}.</b></p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="consultant-review mt-3">
                @foreach($review_list as $key=>$review)
                    @if($review->type == 'CONTOCUS')
                        <div class="review">
                            <div class="avatar">
                                @if ($review->consultant->profile && $review->consultant->profile->avatar)
                                <img src="{{$review->consultant->profile->avatar}}">
                                @else
                                <img src="{{asset('images/profile-icon.svg')}}">
                                @endif
                            </div>
                            <div class="description mt-3">
                                <p class="mb-3">"{{$review->description}}"</p>
                                <p><b>{{$review->consultant->user->first_name}} {{$review->consultant->user->last_name[0]}}.</b></p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="inner-footer">
    <div class="container h-100">
        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
            <div class="home-info-footer d-flex flex-column align-items-center">
                @if($lang == 'en')
                <h2 class="mb-3">{{$data->footer->en_title}}</h2>
                <p>{!!$data->footer->en_des!!}</p>
                <div class="btn-group mt-3">
                    <a href="{{ url('') }}/{{$data->footer->en_btn_link1}}"> {{$data->footer->en_btn_title1}}</a>
                    <a href="{{ url('') }}/{{$data->footer->en_btn_link2}}"> {{$data->footer->en_btn_title2}}</a>
                </div>
                @else
                <h2 class="mb-3">{{$data->footer->no_title}}</h2>
                <p>{!!$data->footer->no_des!!}</p>
                <div class="btn-group mt-3">
                    <a href="{{ url('') }}/{{$data->footer->no_btn_link1}}"> {{$data->footer->no_btn_title1}}</a>
                    <a href="{{ url('') }}/{{$data->footer->no_btn_link2}}"> {{$data->footer->no_btn_title2}}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
        var is_login = @json(Auth::check());
        var search = @json($search);
        var countries = @json($countries);
        new gotoconsult.Controllers.category(search, countries, is_login);
	});
</script>
@endsection