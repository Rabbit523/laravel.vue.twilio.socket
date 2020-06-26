@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="banner">
    <div class="container h-100">
        <div class="col-12 h-100 d-flex flex-column justify-content-center">
            <div class="banner-head px-3">
                @if($lang=='en')
                <h1>{!! $data->en_header->title !!}</h1>
                <p>{!! $data->en_header->description !!}</p>
                <div class="d-flex btn-group">
                    <a href="{{ url('') }}/{{$data->en_header->button_link1}}"> {{$data->en_header->button_title1}}</a>
                    <a href="{{ url('') }}/{{$data->en_header->button_link2}}"> {{$data->en_header->button_title2}}</a>
                </div>
                @else
                <h1>{!! $data->no_header->title !!}</h1>
                <p>{!! $data->no_header->description !!}</p>
                <div class="d-flex btn-group">
                    <a href="{{ url('') }}/{{$data->no_header->button_link1}}"> {{$data->no_header->button_title1}}</a>
                    <a href="{{ url('') }}/{{$data->no_header->button_link2}}"> {{$data->no_header->button_title2}}</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="full-cart search-consult">
    <div class="container">
        @foreach($data->help_list as $key=>$item)
        <div class="col-12 search-item my-5">
            <div class="col-md-6 mobile">
                <div class="content">
                    @if($lang=='en')
                    <h2>{!! $item->en_title !!}</h2>
                    <p>{!! $item->en_des !!}</p>
                    @else
                    <h2>{!! $item->no_title !!}</h2>
                    <p>{!! $item->no_des !!}</p>
                    @endif
                </div>
            </div>
            @if($key%2==0)
            <div class="col-md-6">
                <img src="{{$item->path}}" alt="no-img" />
            </div>
            @endif
            <div class="col-md-6 desktop">
                <div class="content">
                    @if($lang=='en')
                    <h2>{!! $item->en_title !!}</h2>
                    <p>{!! $item->en_des !!}</p>
                    @else
                    <h2>{!! $item->no_title !!}</h2>
                    <p>{!! $item->no_des !!}</p>
                    @endif
                </div>
            </div>
            @if($key%2==1)
            <div class="col-md-6">
                <img src="{{$item->path}}" alt="no-img" />
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
<div class="full-cart benefits">
    <div class="container">
        <div class="col-12 d-flex align-items-center flex-column">
            @if($lang == 'en')
            <h2>{{$data->benefit_list->en_title}}</h2>
            @else
            <h2>{{$data->benefit_list->no_title}}</h2>
            @endif
            <?php $count = count($data->benefit_list->arr); ?>
            @foreach($data->benefit_list->arr as $key=>$item)
                @if($key == 0)
                <div class="benefit-group">
                @elseif ($key % 3 ==0)
                    </div><div class="benefit-group">
                @endif
                <div class="benefit-item">
                    <img src="{{$item->path}}" alt="logo">
                    @if($lang == 'en')
                    <h3 class="mt-3">{{$item->en_title}}</h3>
                    <p>{{$item->en_des}}</p>
                    @else
                    <h3 class="mt-3">{{$item->no_title}}</h3>
                    <p>{{$item->no_des}}</p>
                    @endif
                </div>
                @if ($key == $count -1)
                    </div>
                @endif
                @endforeach
            </div>
            <div class="btn-group">
                <a id="view-features" href="{{ $lang == 'en' ? url('/features') : url('/no/funksjoner') }}">@lang('home.view-features')</a>
            </div>
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
            <div class="home-info-footer">
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
        new gotoconsult.Controllers.home();
        new gotoconsult.Controllers.sticky();
	});
</script>
@endsection