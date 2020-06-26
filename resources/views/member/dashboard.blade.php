@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof">
        <div class="page-list">
            <div class="pages-heading">
                <h2>@lang('member.dashboard')</h2>
            </div>
            <div class="page-dashboard">
                <div class="profile-header">
                    <div class="profile-sec page-border">
                        @if($user_info->profile && $user_info->profile->avatar)
                        <div class="avatar-pic" style="background-image: url('{{ $user_info->profile->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                        @else
                        <div class="avatar-pic">
                            <img src="/images/white-logo.svg" />
                            <div class="default-pic">
                                <img src="/images/photo-camera.svg" alt="no-img" />
                            </div>
                        </div>
                        @endif
                        <div class="detail-info">
                            <h3>{{$user_info->user->first_name}} {{$user_info->user->last_name}}</h3>
                            <div class="detail-profile">
                                <div class="d-flex mr-3"><img src="/images/user.svg" /><span>@lang('member.user-id') {{$user_info->user->id}}</span></div>
                                <?php
                                    if ($user_info->profile && $user_info->profile->timezone)  {
                                        $date = new DateTime("now", new DateTimeZone($user_info->profile->timezone) );
                                    } else {
                                        $date = new DateTime("now", new DateTimeZone('Europe/Oslo') );
                                    }
                                    $cur_time = $date->format('H:i:A'); 
                                ?>
                                <div class="d-flex"><img src="/images/clock.svg" /><span>{{$cur_time}} ({{$user_info->profile->timezone}})</span></div>
                                <a href="{{ $lang == 'en' ? url('/profile') : url('/no/profil') }}">@lang('member.edit')</a>
                            </div>
                        </div>
                    </div>
                    @if($user_info->user->role == 'customer')
                    <div class="current-bal page-border">
                        <div class="icon-box pr-3">
                            <img src="{{asset('images/money.svg')}}" alt="no-image"/>
                        </div>
                        <div class="balance-status">
                            <h3>@lang('member.my_balance')</h3>
                            <div class="underline-bar"></div>
                            <span>{{$user_info->user->balance}} NOK <a href="{{ $lang == 'en' ? url('/wallet') : url('/no/lommebok') }}">@lang('member.add-credits')</a></span>
                        </div>
                    </div>
                    <div class="mobile-step2">
                        <div class="d-flex justify-content-center pb-3">
                            <img src="{{asset('images/earnings-icon.svg')}}">
                        </div>
                        <div class="d-flex align-items-center flex-column">
                            <h3>@lang('member.my_balance')</h3>
                            <div class="underline-bar"></div>
                            <span class="updated_balance">{{$user_info->user->balance}} NOK</span>
                        </div>
                        <button class="btn add-credit-btn">@lang('member.add-credits')</button>
                    </div>
                    @elseif($user_info->user->role == 'consultant')
                    <div class="current-bal page-border">
                        <div class="icon-box pr-3">
                            <img src="{{asset('images/money.svg')}}" alt="no-image"/>
                        </div>
                        <div class="balance-status">
                            <h3>@lang('member.today_earning')</h3>
                            <div class="underline-bar"></div>
                            <span>{{$consultants['earning']}} NOK <a href="{{ $lang == 'en' ? url('/transactions') : url('/no/transaksjoner') }}">@lang('member.view_transactions')</a></span>
                        </div>
                    </div>
                    <div class="mobile-step2">
                        <div class="d-flex justify-content-center pb-3">
                            <img src="{{asset('images/earnings-icon.svg')}}">
                        </div>
                        <div class="d-flex align-items-center flex-column">
                            <h3>@lang('member.today_earning')</h3>
                            <div class="underline-bar"></div>
                            <span class="updated_balance">{{$consultants['earning']}} NOK</span>
                        </div>
                        <button class="btn add-credit-btn">@lang('member.view_transactions')</button>
                    </div>
                    @endif
                </div>
                @if($user_info->user->role == 'customer')
                    <h3>@lang('member.recommended-consultants')</h3>
                    <div class="page-border recommend">
                    @foreach($consultants as $consultant)
                    <div class="cart-section d-flex flex-column">
                        @if($consultant->profile && $consultant->profile->avatar)
                            <div class="avatar-pic" style="background-image: url('{{ $consultant->profile->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                        @else
                            <div class="avatar-pic">
                                <img src="{{asset('images/white-logo.svg')}}" />
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
                    @endforeach
                    </div>
                @elseif($user_info->user->role == 'consultant')
                    <h3>@lang('member.recent-sessions')</h3>
                    <div class="page-border recommend">
                    @foreach($customers as $customer)
                    <div class="cart-section d-flex flex-column">
                        @if($customer->profile && $customer->profile->avatar)
                            <div class="avatar-pic" style="background-image: url('{{ $customer->profile->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                        @else
                            <div class="avatar-pic">
                                <img src="/images/white-logo.svg" />
                            </div>
                        @endif
                        @if($customer->profile)
                        <label class="mt-3 mb-0">{{$customer->profile->profession}}</label>
                        @endif
                        <h3>{{$customer->user->first_name}} {{$customer->user->last_name}}</h3>
                        <small></small>
                        <div class="star-images d-flex">
                            @if($customer['rate'] == 5)
                            <ul class="d-flex">
                                <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                            </ul>
                            @elseif($customer['rate'] == 4)
                            <ul class="d-flex">
                                <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            </ul>
                            @elseif($customer['rate'] == 3)
                            <ul class="d-flex">
                                <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            </ul>
                            @elseif($customer['rate'] == 2)
                            <ul class="d-flex">
                                <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                                <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                            </ul>
                            @elseif($customer['rate'] == 1)
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
                        <div class="end-button d-flex">
                            <a href="{{ $lang == 'en' ? url('/sessions') : url('/no/moter') }}" class="w-100">@lang('member.view-session')</a>
                        </div>
                    </div>
                    @endforeach
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
        var user = @json($user_info);
        new gotoconsult.Controllers.public(user);
    });
</script>
@endsection