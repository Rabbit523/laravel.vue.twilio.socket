@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion invoices">
            <div class="page-list">
                <div class="pages-heading">
                    <h2>@lang('member.find_consultant')</h2>
                </div>
                <div class="pages-top-sec mt-3">
                    <form class="form mr-3">
                        <input type="text" name="search" class="search-input" placeholder="@lang('member.name-keyword')"/>
                    </form>
                    <div class="sort-section d-flex">
                        <div class="dropdown-box mr-3">
                            <label>@lang('member.category'):</label>
                            <select class="category-sel">
                                <option disabled selected>All</option>
                                <option value="psychologists">Psychologists</option>
                                <option value="economists">Economists</option>
                                <option value="lawyers">Lawyers</option>
                                <option value="doctors">Doctors</option>
                                <option value="nurses">Nurses</option>
                                <option value="veterinarians">Veterinarians</option>
                                <option value="astrologers">Astrologers</option>
                                <option value="teachers">Teachers</option>
                            </select>
                        </div>
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
                            <label>@lang('member.category'):</label>
                            <select class="category-sel">
                                <option disabled selected>All</option>
                                <option value="psychologists">Psychologists</option>
                                <option value="economists">Economists</option>
                                <option value="lawyers">Lawyers</option>
                                <option value="doctors">Doctors</option>
                                <option value="nurses">Nurses</option>
                                <option value="veterinarians">Veterinarians</option>
                                <option value="astrologers">Astrologers</option>
                                <option value="teachers">Teachers</option>
                            </select>
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
                <div class="page-dashboard mt-3">
                    <div class="page-border recommend">
                        @foreach($consultants as $key => $consultant)
                            @if($key == 0)
                                <div class="cart-full d-flex flex-wrap">
                            @elseif ($key % 4 ==0)
                                </div><div class="cart-full d-flex flex-wrap">
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
                                <label class="mt-3 mb-0">{{$consultant->profile->profession}}</label>
                                @endif
                                <h3>{{$consultant->user->first_name}} {{$consultant->user->last_name}}</h3>
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
                                    <button class="btn"><img src="{{asset('images/home/ph-g.png')}}" alt="no-img" /></button>
                                    <button class="btn"><img src="{{asset('images/home/video-g.png')}}" alt="no-img" /></button>
                                    <button class="btn"><img src="{{asset('images/home/msg-g.png')}}" alt="no-img" /></button>
                                    @else
                                    <button class="btn"><img src="{{asset('images/home/ph-y.png')}}" alt="no-img" /></button>
                                    <button class="btn"><img src="{{asset('images/home/video-y.png')}}" alt="no-img" /></button>
                                    <button class="btn"><img src="{{asset('images/home/msg-y.png')}}" alt="no-img" /></button>
                                    @endif
                                </div>
                            </div>
                            @if ($key == $count -1)
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if ($count == 0)
                    <div class="page-border recommend cart-no-result">
                        <img src="/images/mascot.svg" />
                        <h2>@lang('member.no-result')</h2>
                        <p>@lang('member.no-result-des')</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(function(){
        var search = @json($search);
        var countries = @json($countries);
        var user = @json($auth_user);
        new gotoconsult.Controllers.public(user);
        new gotoconsult.Controllers.findConsult(search, countries);
    });
</script>
@endsection