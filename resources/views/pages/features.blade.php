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
<div class="full-cart solve feature-service">
  <div class="container">
    <div class="col-12 d-flex align-items-center flex-column">
      @if($lang == 'en')
      <h2>{!! $data->services->en_title !!}</h2>
      @else
      <h2>{!! $data->services->no_title !!}</h2>
      @endif
      <div class="feature-service-groups my-5">
        <?php $count = count($data->services->arr); ?>
        @foreach($data->services->arr as $key => $item)
          @if($key == 0)
            <div class="feature-service-group my-3">
          @elseif ($key % 4 ==0)
            </div><div class="feature-service-group my-3">
          @endif
          <div class="feature-service-item text-center">
            <img src="{{URL::asset('')}}{{$item->path}}" alt="logo">
            @if($lang == 'en')
            <h3 class="text-capitalize">{!! $item->en_title !!}</h3>
            <p>{!! $item->en_des !!}</p>
            @else
            <h3 class="text-capitalize">{!! $item->no_title !!}</h3>
            <p>{!! $item->no_des !!}</p>
            @endif
          </div>
          @if ($key == $count -1)
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
<div class="full-cart abs-img">
  <div class="container">
    <div class="col-12 abs-item px-3">
      <div class="text-section">
        @if ($lang == 'en')
        <h2>{{$data->consultant->en_title}}</h2>
        <p>{{$data->consultant->en_des}}</p>
        @else
        <h2>{{$data->consultant->no_title}}</h2>
        <p>{{$data->consultant->no_des}}</p>
        @endif
      </div>
      <div class="img-section">
        <img src="{{URL::asset('')}}{{$data->consultant->path}}" />
      </div>
    </div>
  </div>
</div>
<div class="full-cart abs-img">
  <div class="container">
    <div class="col-12 abs-item px-3">
      <div class="text-section">
        @if ($lang == 'en')
        <h2>{{$data->session->en_title}}</h2>
        <p>{{$data->session->en_des}}</p>
        @else
        <h2>{{$data->session->no_title}}</h2>
        <p>{{$data->session->no_des}}</p>
        @endif
      </div>
      <div class="img-section session">
        <img src="{{URL::asset('')}}{{$data->session->path}}" />
      </div>
    </div>
  </div>
</div>
<div class="full-cart normal-img">
  <div class="container">
    <div class="col-12 abs-item px-3">
      <div class="text-section mobile">
        <div class="w-100">
          @if ($lang == 'en')
          <h2>{{$data->wallet->en_title}}</h2>
          <p>{{$data->wallet->en_des}}</p>
          @else
          <h2>{{$data->wallet->no_title}}</h2>
          <p>{{$data->wallet->no_des}}</p>
          @endif
        </div>
      </div>
      <div class="img-section">
        <img src="{{URL::asset('')}}{{$data->wallet->path}}" />
      </div>
      <div class="text-section desktop">
        <div class="w-50">
          @if ($lang == 'en')
          <h2>{{$data->wallet->en_title}}</h2>
          <p>{{$data->wallet->en_des}}</p>
          @else
          <h2>{{$data->wallet->no_title}}</h2>
          <p>{{$data->wallet->no_des}}</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="full-cart abs-img profile">
  <div class="container">
    <div class="col-12 abs-item px-3">
      <div class="text-section">
        @if ($lang == 'en')
        <h2>{{$data->profile->en_title}}</h2>
        <p>{{$data->profile->en_des}}</p>
        @else
        <h2>{{$data->profile->no_title}}</h2>
        <p>{{$data->profile->no_des}}</p>
        @endif
      </div>
      <div class="img-section profile">
        <img src="{{URL::asset('')}}{{$data->profile->path}}" />
      </div>
    </div>
  </div>
</div>
<div class="full-cart abs-img transaction">
  <div class="container">
    <div class="col-12 abs-item px-3">
      <div class="text-section">
        @if ($lang == 'en')
        <h2>{{$data->transactions->en_title}}</h2>
        <p>{{$data->transactions->en_des}}</p>
        @else
        <h2>{{$data->transactions->no_title}}</h2>
        <p>{{$data->transactions->no_des}}</p>
        @endif
      </div>
      <div class="img-section">
        <img src="{{URL::asset('')}}{{$data->transactions->path}}" />
      </div>
    </div>
  </div>
</div>
<div class="full-cart gd-ppl-words feature">
  <div class="container">
      <div class="col-12">
        <h2>@lang('home.review-title')</h2>
        <div class="header px-3">
          <p class="customer active">@lang('home.customers')</p>
          <p class="consultant">@lang('home.consultants')</p>
        </div>
        <div class="customer-review mt-3">
          <?php $url = $string = rtrim(URL::asset(''), "/");?>
          @foreach($review_list as $key=>$review)
              @if($review->type == 'CUSTOCON')
                  <div class="review">
                      <div class="avatar">
                          @if ($review->customer->profile && $review->customer->profile->avatar)
                          <img src="{{$url.$review->customer->profile->avatar}}">
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
@endsection
@section('scripts')
<script>
	jQuery(function(){
    new gotoconsult.Controllers.features();
    new gotoconsult.Controllers.sticky();
	});
</script>
@endsection