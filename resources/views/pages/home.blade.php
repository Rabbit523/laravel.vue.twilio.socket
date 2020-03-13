@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="banner">
    <div class="col-12 no-padding">
        <div class="banner-head">
            @if($lang=='en')
            <h3>{!! $data->en_header->title !!}</h3>
            <a href="{{ url('') }}/{{$data->en_header->button_link}}"> <button class="btn">{{$data->en_header->button_title}}</button></a>
            @else
            <h3>{!! $data->no_header->title !!}</h3>
            <a href="{{ url('') }}/{{$data->no_header->button_link}}"> <button class="btn">{{$data->no_header->button_title}}</button></a>
            @endif
        </div>
    </div>
</div>

<div class="ec-full full-explore">
    <div class="wrap">
        <div class="explore-cate-cart d-flex flex-wrap">
            @foreach($categories as $category)
                <?php $route = $category->category_url ?>
                <div class="explore-carts d-flex flex-column">
                    <img src="{{asset($category->category_icon)}}" alt="no-img"/>
                    @if($lang == 'en')
                    <h3>{{$category->category_name}}</h3>
                    <small></small>                    
                    <span>{{$category->category_description}}</span>
                    <small></small>
                    @else
                    <h3>{{$category->category_name_no}}</h3>
                    <small></small>                    
                    <span>{{$category->category_description_no}}</span>
                    <small></small>
                    @endif
                    <a class="btn" href="{{url('/category/').'/'.$route}}">@lang('home.find_consultant')</a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="ec-full consult-steps">
        <div class="wrap">
            <div class="row">
                @foreach($data->list as $key=>$item)
                    <?php $key = $key + 1; $path = "images/home/count-".$key.".png"; ?>
                    <div class="col-md-4 step-blk">
                        <div>
                            <img src="{{asset('')}}{{$path}}" alt="no-img" />
                        </div>
                        <div class="content">
                            @if($lang=='en')
                                <h3>{{$item->en_title}}</h3>
                                <p>{{$item->en_des}}</p>
                            @else
                                <h3>{{$item->no_title}}</h3>
                                <p>{{$item->no_des}}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="full-cart avail-consultant">
    <div class="wrap">
        @if($lang=='en')
        <h3 class="title">{{$data->consult_available->en}}</h3>
        @else
        <h3 class="title">{{$data->consult_available->no}}</h3>
        @endif
        <div class="cart-full d-flex flex-wrap">
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="star-images d-flex">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                </div>
            </div>
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="d-flex star-images">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-r.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                </div>
            </div>
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="d-flex star-images">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-y.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                </div>
            </div>
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="d-flex star-images">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-o.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                </div>
            </div>
        </div>
        @if($lang=='en')
        <h3 class="title">{{$data->consult_review->en}}</h3>
        @else
        <h3 class="title">{{$data->consult_review->no}}</h3>
        @endif
        <div class="cart-full d-flex flex-wrap">
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="d-flex star-images">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                </div>
            </div>
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="star-images d-flex">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-dg.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph-y.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video-y.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg-y.png')}}" alt="no-img" /></button>
                </div>
            </div>
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="star-images d-flex">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph-g.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video-g.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg-g.png')}}" alt="no-img" /></button>
                </div>
            </div>
            <div class="cart-section d-flex flex-column">
                <img src="{{asset('images/home/person.png')}}" alt="no-img" />
                <h3>@lang('home.lawyer')</h3>
                <h5>Ola Normann</h5>
                <small></small>
                <h3>@lang('home.call'): <span>918 99 918</span></h3>
                <h3>@lang('home.code'): <span>369</span></h3>
                <small></small>
                <div class="star-images d-flex">
                    <ul class="d-flex">
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-g.png')}}" alt="no-img" /></li>
                        <li><img src="{{asset('images/home/star-w.png')}}" alt="no-img" /></li>
                    </ul>
                </div>
                <small></small>
                <div class="rm d-flex">
                    <a href="#" class="text-capitalize">@lang('home.read_more')</a>
                    <p>39,90 kr p/m</p>
                </div>
                <div class="end-button d-flex">
                    <button class="btn"><img src="{{asset('images/home/ph.png')}}" alt="no-img" /></button>
                    <button class="btn btn-mid"><img src="{{asset('images/home/video.png')}}" alt="no-img" /></button>
                    <button class="btn"><img src="{{asset('images/home/msg.png')}}" alt="no-img" /></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="full-cart search-counsult">
    <div class="wrap">
        @foreach($data->help_list as $key=>$item)
        <div class="row">
            @if($key%2==1)
            <div class="col-md-6 no-padding">
                <img src="{{$item->path}}" alt="no-img" />
            </div>
            @endif
            <div class="col-md-6 no-padding">
                <div class="content">
                    @if($lang=='en')
                    <h3>{!! $item->en_title !!}</h3>
                    <p>{!! $item->en_des !!}</p>
                    <a href="{{ url('') }}/{{$item->button_link}}"> <button class="btn">{{$item->en_button_title}}</button></a>
                    @else
                    <h3>{!! $item->no_title !!}</h3>
                    <p>{!! $item->no_des !!}</p>
                    <a href="{{ url('') }}/{{$item->button_link}}"> <button class="btn">{{$item->no_button_title}}</button></a>
                    @endif
                </div>
            </div>
            @if($key%2==0)
            <div class="col-md-6 no-padding">
                <img src="{{$item->path}}" alt="no-img" />
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<div class="full-cart benifits">
    <div class="wrap">
        <div class="cart-full">
            @if($lang == 'en')
            <h3>{{$data->benefit_list->en_title}}</h3>
            @else
            <h3>{{$data->benefit_list->no_title}}</h3>
            @endif
            <div class="row">
                @foreach($data->benefit_list->arr as $key=>$item)
                <div class="col-lg-3 col-md-5 cart-section">
                    <img src="{{$item->path}}" alt="logo">
                    @if($lang == 'en')
                    <p>{{$item->en_des}}</p>
                    @else
                    <p>{{$item->no_des}}</p>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="consult-btn">
                @foreach($data->benefit_list->buttons as $item)
                @if($lang == 'en')
                <a href="{{ url('') }}/{{$item->link}}"> <button class="btn">{{$item->en_title}}</button></a>
                @else
                <a href="{{ url('') }}/{{$item->link}}"> <button class="btn">{{$item->no_title}}</button></a>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="full-cart gd-ppl-words">
    <div class="wrap">
        <div class="cart-full">
            @if($lang=='en')
            <h3>{{$data->review_list->en_title}}</h3>
            @else
            <h3>{{$data->review_list->no_title}}</h3>
            @endif
            <div class="row">
                @foreach($data->review_list->arr as $key=>$item)
                <div class="col-lg-3 col-md-5 cart-section">
                    <div class="content">
                        <img src="{{$item->path}}" alt="logo">
                        @if($lang=='en')
                        <p>{{$item->en_des}}</p>
                        @else
                        <p>{{$item->no_des}}</p>
                        @endif
                        <p>{{$item->name}}</p>
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
    $(document).ready(function() {
            
    });
</script>
@endsection