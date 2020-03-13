@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="banner become-consultant">
    <div class="col-12 no-padding">
        <div class="banner-head">
        @if($lang=='en')
        <h3>{!! $data->en_header->title !!}</h3>
        <p>{!! $data->en_header->description !!}</p>
        <a href="{{ url('') }}/{{$data->en_header->button_link}}"> <button class="btn">{{$data->en_header->button_title}}</button></a>
        @else
        <h3>{!! $data->no_header->title !!}</h3>
        <p>{!! $data->no_header->description !!}</p>
        <a href="{{ url('') }}/{{$data->no_header->button_link}}"> <button class="btn">{{$data->no_header->button_title}}</button></a>
        @endif
        </div>
    </div>
</div>

<div class="full-consultant consultant-service">
    <div class="wrap">
        <div class="cart-full">
            <h3>@lang('become_consultant.our_consultant_services')</h3>
            @foreach($categories as $key => $category)
                @if($key == 0)
                    <div class="row">
                @elseif ($key % 2 == 0)
                    </div><div class="row">
                @endif
                    <div class="col-lg-6 col-md-6 service-section">
                        <img src="{{asset($category->category_icon)}}" alt="no-img"/>
                        <p><span class="text-capitalize">{{$category->category_name}}</span> <br/> {{$category->category_description}}</p>
                    </div>
                @if($key == $count - 1)
                    <div class="col-lg-6 col-md-6 service-section become">
                        <p>@lang('become_consultant.become_consultant')</p>
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-down fa-w-10 fa-lg"><path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" class=""></path></svg>
                    </div>
                </div>
                @endif
            @endforeach
            </div>
        </div>
    </div>
</div>

<div class="full-consultant consultant-platform">
    <div class="wrap">
        <div class="cart-full">
            <div class="row">
                <div class="col-lg-5 col-md-6 platform-group">
                    @if($lang=='en')
                    <h3>{{$data->platform_list->en_title}}</h3>
                    @else
                    <h3>{{$data->platform_list->no_title}}</h3>
                    @endif
                    @foreach($data->platform_list->arr as $key=>$item)
                    <div class="platform">
                        <img src="{{$item->icon}}" alt="logo">
                        @if($lang == 'en')
                        <p><span>{{$item->en_title}}</span> <br/> {{$item->en_des}}</p>
                        @else
                        <p><span>{{$item->no_title}}</span> <br/> {{$item->no_des}}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-7 col-md-6">
                    <img src="{{$data->platform_list->plat_img}}" class="platform-img" alt="logo">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="full-consultant gd-ppl-words">
    <div class="wrap">
        <div class="cart-full">
            @if($lang == 'en')
            <h3>{{$data->review_list->en_title}}</h3>
            @else
            <h3>{{$data->review_list->no_title}}</h3>
            @endif
            <div class="row">
                @foreach($data->review_list->arr as $key => $item)
                <div class="col-lg-3 col-md-5 cart-section">
                    <div class="content">
                        <img src="{{$item->path}}" alt="logo">
                        @if($lang == 'en')
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

<div class="full-consultant consultant-contact">
    <div class="wrap">
        <div class="cart-full">
            <div class="row">
                <div class="col-lg-6 col-md-6 contact-form">
                    @if($lang == 'en')
                    <h3>{{$data->register_list->en_title}}</h3>
                    @else
                    <h3>{{$data->register_list->no_title}}</h3>
                    @endif
                    <form id="consultant-form" action="{{ url('join_consultant') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" placeholder="@lang('become_consultant.first_name') *" data-msg-required="First name required." required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" placeholder="@lang('become_consultant.last_name') *" data-msg-required="Last name required." required>
                        </div>
                        <div class="form-group">
                            <!-- <input type="text" class="form-control" name="industry" placeholder="Industry Expertise *" data-msg-required="Industry selection required." required> -->
                            <select class="form-control drop-box" name="industry" data-msg-required="Industry selection required." required>
                                <option selected disabled hidden>@lang('become_consultant.industry_expertise') *</option>
                                @foreach($categories as $category)
                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="phone" placeholder="@lang('become_consultant.phone') *" data-msg-required="Phone number is required." required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="@lang('become_consultant.email') *" data-msg-required="E-mail is required." required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="@lang('become_consultant.create_password') *" data-msg-required="Password is required." required>
                        </div>
                        <div class="checkbox agree_check">
                            <label class="container">@lang('become_consultant.read_accept')<br/> @lang('become_consultant.gotoconsult') <a href="{{url('/terms')}}" target="_blank">@lang('become_consultant.terms') </a> @lang('become_consultant.and') <a href="{{url('/privacy')}}" target="_blank">@lang('become_consultant.privacy'). </a><input type="checkbox"><span class="checkmark"></span></label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn" value="@lang('become_consultant.create_consultant_account')">
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6 requirements">
                    @if($lang == 'en')
                    <label>{{$data->register_list->en_des_title}}</label>
                    @else
                    <label>{{$data->register_list->no_des_title}}</label>
                    @endif
                    @foreach ($data->register_list->arr as $key=>$item)
                    <div class="require-item">
                        <p>{{$key+1}}.</p>
                        @if ($lang == 'en')
                        <p>{{$item->en_des}}</p>
                        @else
                        <p>{{$item->no_des}}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(".btn").click(function (event) {
        event.preventDefault();
        if ($("#consultant-form").valid()) {
            $("#consultant-form").submit();
        }
    });
</script>
@endsection