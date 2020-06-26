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
                @else
                <h1>{!! $data->no_header->title !!}</h1>
                <p>{!! $data->no_header->description !!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="full-cart solve feature-service">
    <div class="container">
        <div class="col-12 d-flex align-items-center my-5 flex-column">
            @if($lang == 'en')
            <h2>{!! $data->article_list->en_title !!}</h2>
            @else
            <h2>{!! $data->article_list->no_title !!}</h2>
            @endif
            <div class="feature-service-group my-5 px-3">
                @foreach($data->article_list->arr as $key => $item)
                <div class="feature-service-item text-center">
                    <img src="{{$item->icon}}" alt="logo">
                    @if($lang == 'en')
                    <h3>{!! $item->en_title !!}</h3>
                    <p>{!! $item->en_des !!}</p>
                    @else
                    <h3>{!! $item->no_title !!}</h3>
                    <p>{!! $item->no_des !!}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>   
<div class="full-cart our_story">
    <div class="container">
        <div class="col-12 story_item px-3">
            <div class="des-sec mobile">
                @if($lang == 'en')
                <h2>{!! $data->story->en_title !!}</h2>
                <p>{!! $data->story->en_des !!}</p>
                @else
                <h2>{!! $data->story->no_title !!}</h2>
                <p>{!! $data->story->no_des !!}</p>
                @endif
            </div>
            <div class="img-sec">
                <img src="{{$data->story->path}}" alt="logo">
            </div>
            <div class="des-sec desktop">
                @if($lang == 'en')
                <h2>{!! $data->story->en_title !!}</h2>
                <p>{!! $data->story->en_des !!}</p>
                @else
                <h2>{!! $data->story->no_title !!}</h2>
                <p>{!! $data->story->no_des !!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="full-cart our_team">
    <div class="container">
        <div class="col-12 d-flex px-3">
            <div class="team_item">
                @foreach($data->team as $key => $item)
                <div class="item">
                    @if($item->avatar)
                        <div class="avatar-pic" style="background-image: url('{{ $item->avatar}}'); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
                    @else
                        <div class="avatar-pic">
                            <img src="/images/white-logo.svg" />
                        </div>
                    @endif
                    <h6>{!! $item->name !!}</h6>
                    @if($lang == 'en')
                    <p>{!! $item->en_job !!}</p>
                    <span class="btn-bio" id="show_hide_bio{{$key}}" data-key="{{$key}}">@lang('about.show-bio')</span>                
                    <p id="bio_content{{$key}}">{!! $item->en_bio !!}</p>
                    @else
                    <p>{!! $item->no_job !!}</p>
                    <span class="btn-bio" id="show_hide_bio{{$key}}" data-key="{{$key}}">@lang('about.show-bio')</span>
                    <p id="bio_content{{$key}}">{!! $item->no_bio !!}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="full-cart gd-ppl-words about">
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
<div class="ec-full consult-steps">
    <div class="container">
        <div class="col-12 px-3">
            @if($lang == 'en')
            <h2>{!! $data->get_started->en_title !!}</h2>
            @else
            <h2>{!! $data->get_started->no_title !!}</h2>
            @endif
            <div class="step-group">
                @foreach($data->get_started->arr as $key => $item)
                <?php $num = $key + 1; ?>
                <div class="item">
                    <div class="number-sec"><span>{{$num}}</span></div>
                    <div class="des-sec">
                        @if($lang == 'en')
                        <h3>{!! $item->en_title !!}</h3>
                        <p>{!! $item->en_des !!}</p>
                        @else
                        <h3>{!! $item->no_title !!}</h3>
                        <p>{!! $item->no_des !!}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
        new gotoconsult.Controllers.about();
        new gotoconsult.Controllers.sticky();
	});
</script>
@endsection