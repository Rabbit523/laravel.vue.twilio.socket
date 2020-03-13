@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="banner about-us">
    <div class="col-12 no-padding">
        <div class="banner-head">
            @if($lang == 'en')
            <h3>{!! $data->en_header->title !!}</h3>
            <a href="{{ url('') }}/{{$data->en_header->button_link}}"><button class="btn">{{$data->en_header->button_title}}</button></a>
            @else
            <h3>{!! $data->no_header->title !!}</h3>
            <a href="{{ url('') }}/{{$data->no_header->button_link}}"><button class="btn">{{$data->no_header->button_title}}</button></a>
            @endif
        </div>
    </div>
</div>
    
<div class="full-cart benifits solve">
    <div class="wrap">
        <div class="cart-full">
            @if($lang == 'en')
            <h3>{!! $data->article_list->en_title !!}</h3>
            @else
            <h3>{!! $data->article_list->no_title !!}</h3>
            @endif
            <div class="row">
                @foreach($data->article_list->arr as $key => $item)
                <div class="col-lg-3 col-md-5 cart-section">
                    <img src="{{$item->icon}}" alt="logo">
                    @if($lang == 'en')
                    <h5>{!! $item->en_title !!}</h5>
                    <p>{!! $item->en_des !!}</p>
                    @else
                    <h5>{!! $item->no_title !!}</h5>
                    <p>{!! $item->no_des !!}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
   
<div class="full-cart our_story">
    <div class="wrap">
        <div class="cart-full">
            <div class="row">
                <div class="col-lg-6 col-md-6 cart-section">
                    @if($lang == 'en')
                    <h6>{!! $data->story->en_part_title !!}</h6>
                    <h3>{!! $data->story->en_title !!}</h3>
                    @else
                    <h6>{!! $data->story->no_part_title !!}</h6>
                    <h3>{!! $data->story->no_title !!}</h3>
                    @endif
                    <img src="{{$data->story->path}}" alt="logo">
                </div>
                <div class="col-lg-6 col-md-6 cart-section">
                    @if($lang == 'en')
                    <p>{!! $data->story->en_des !!}</p>
                    @else
                    <p>{!! $data->story->no_des !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="full-cart our_team">
    <div class="wrap">
        <div class="cart-full">
            @if($lang == 'en')
            <h6>{!! $data->team->en_part_title !!}</h6>
            <h3>{!! $data->team->en_title !!}</h3>
            @else
            <h6>{!! $data->team->no_part_title !!}</h6>
            <h3>{!! $data->team->no_title !!}</h3>
            @endif
            <div class="row">
                @foreach($data->team->arr as $key => $item)
                <div class="col-lg-4 col-md-4 cart-section">
                    <img src="{{$item->avatar}}" alt="logo">
                    <h6>{!! $item->name !!}</h6>
                    @if($lang == 'en')
                    <p>{!! $item->en_job !!}</p>
                    <span class="show_hide_bio{{$key}}" onclick="itemshow({{$key}})">Hide Bio</span>                
                    <p class="bio_content{{$key}}">{!! $item->en_bio !!}</p>
                    @else
                    <p>{!! $item->no_job !!}</p>
                    <span class="show_hide_bio{{$key}}" onclick="itemshow({{$key}})">Hide Bio</span>                
                    <p class="bio_content{{$key}}">{!! $item->no_bio !!}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
  
<div class="ec-full consult-steps">
    <div class="wrap">
        @if($lang == 'en')
        <h5>{!! $data->get_started->en_title !!}</h5>
        @else
        <h5>{!! $data->get_started->no_title !!}</h5>
        @endif
        <div class="row">
            @foreach($data->get_started->arr as $key => $item)
            <?php $key = $key + 1; $path = "images/home/count-".$key.".png"; ?>
            <div class="col-md-4 step-blk">
                <div>
                    <img src="{{asset('')}}{{$path}}" alt="no-img" />
                </div>
                <div class="content">
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
        <div class="consult-btn">
            <button class="btn">@lang('about.find_consult')</button>
            <button class="btn">@lang('about.become_consult')</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function itemshow(x) {
        if ($(".show_hide_bio"+x).text() == "Hide Bio") {
            $(".show_hide_bio"+x).html("Show Bio");
        } else {
            $(".show_hide_bio"+x).html("Hide Bio");
        }
        $(".bio_content"+x).slideToggle(); 
    }
</script>
@endsection