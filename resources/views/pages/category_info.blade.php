@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="wrap">
    <div class="cate-info-page d-flex">
        <div class="left-ham d-flex">
            <img src="{{asset($category->category_icon)}}" alt="no_img"/>
        </div>
        <div class="ham-content d-flex flex-column">
            @if($lang == 'en')
            <h3>{{$category->category_name}}</h3>
            <span>{{$category->category_description}}</span>
            @else
            <h3>{{$category->category_name_no}}</h3>
            <span>{{$category->category_description_no}}</span>
            @endif
        </div>
    </div>
</div>
    
<div class="pages-list d-flex">
    <div class="pages-list-l d-flex">
        <div class="pages-left d-flex">
            <h2>@lang('category_info.showing') {{$count}} of {{$count}} 
                @if($lang == 'en')
                <span>{{$category->category_name}}</span>
                @else
                <span>{{$category->category_name_no}}</span>
                @endif
            </h2>
        </div>
        <div class="pages-right d-flex flex-column wrap-d">
            <span>@lang('category_info.sortby')</span>
            <div class="dropdown">
                <button type="button" class="btn p-l dropdown-toggle" data-toggle="dropdown">
                    Dropdown button
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Link 1</a>
                    <a class="dropdown-item" href="#">Link 2</a>
                    <a class="dropdown-item" href="#">Link 3</a>
                </div>
            </div>
        </div>
    </div>
</div>
		
<div class="full-cart">
    <div class="wrap">
        @foreach($consultants as $key => $consultant)
            @if($key == 0)
                <div class="cart-full d-flex flex-wrap">
            @elseif ($key % 4 ==0)
                </div><div class="cart-full d-flex flex-wrap">
            @endif
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img"/>
                @if($lang == 'en')
                <h3>{{$category->category_name}}</h3>
                @else
                <h3>{{$category->category_name_no}}</h3>
                @endif
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="star-images d-flex">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img"/></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img"/></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img"/></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img"/></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img"/></li>
                    </ul>
                </div>
                    <small></small>
                <div class="rm d-flex">
                    <a href="#">@lang('category_info.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img"/></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img"/></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img"/></button>
                </div>
            </div>
            @if ($key == $count -1)
                </div>
            @endif
        @endforeach
    </div>
</div>
   
<div class="wrap">
    <div class="people-words d-flex flex-column">
        @if($lang == 'en')
        <h3>{{$data->review_list->en_title}}</h3>
        @else
        <h3>{{$data->review_list->no_title}}</h3>
        @endif
        <div class="four-sec d-flex">
            @foreach ($data->review_list->arr as $key => $item)
            <div class="sec-words d-flex flex-column">
                <img src="{{$item->path}}" alt="no-img"/>
                @if($lang == 'en')
                <p>{!! $item->en_des !!}</p>
                @else
                <p>{!! $item->no_des !!}</p>
                @endif
                <p>{!! $item->name !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="ec-full category-info">
    @if($lang == 'en')
    <h3>{!! $data->category_title->en !!}</h3>
    @else
    <h3>{!! $data->category_title->no !!}</h3>
    @endif
    <div class="wrap">
        @foreach($categories as $key => $category)
            @if($key%4 == 0)
            <div class="explore-cate-cart d-flex flex-wrap">
            @endif
            <div class="explore-carts d-flex flex-column">
                <img src="{{asset($category->category_icon)}}" alt="no-img"/>
                <h3>{{$category->category_name}}</h3>
                <small></small>
                <span>{{$category->category_description}}</span>
                <small></small>
                <button class="btn">@lang('category_info.find_consultant')</button>
            </div>
            @if($key%4 == 3 || $key>4 && $key%4 == 2)
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection