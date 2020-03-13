@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="banner faq wrap">
    <img src="{{$data->header->path}}" alt="">
    <div class="banner-content">
        @if($lang == 'en')
        <h3>{!! $data->header->en_title !!}</h3>
        <p>{!! $data->header->en_des !!}</p>
        @else
        <h3>{!! $data->header->no_title !!}</h3>
        <p>{!! $data->header->no_des !!}</p>
        @endif
    </div>
</div>

<div class="p-p-content p-p-faq">
    <div class="faq-content d-flex wrap">
        <div class="left-accordion">
            <div class="bs-example">
                @if($lang == 'en')
                <h3>{!! $data->question_header->en_title !!}</h3>
                @else
                <h3>{!! $data->question_header->no_title !!}</h3>
                @endif
                <div class="panel-group" id="accordion">
                    @foreach($data->questions as $key => $item)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                @if($lang == 'en')
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}"><span class="glyphicon glyphicon-menu-right"></span>{!! $item->en_que !!}</a>
                                @else
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}"><span class="glyphicon glyphicon-menu-right"></span>{!! $item->no_que !!}</a>
                                @endif
                            </h5>
                            <h4></h4>
                        </div>
                        <div id="collapse{{$key}}" class="panel-collapse collapse">
                            <div class="panel-body">
                                @if($lang == 'en')
                                <span>{!! $item->en_asw !!}</span>
                                @else
                                <span>{!! $item->no_asw !!}</span>
                                @endif
			                </div>
                        </div>
                    </div>
                    @endforeach
			    </div>
			</div>
        </div>
        <div class="right-faq">
            @if($lang == 'en')
            <h3>{!! $data->question_header->en_msg_title !!}</h3>
            @else
            <h3>{!! $data->question_header->no_msg_title !!}</h3>
            @endif
            <form action="/action_page.php">
                <div class="form-group">
                    <input type="text" class="form-control" id="email" placeholder="@lang('faq.full_name') *" name="email">
                    <input type="email" class="form-control" id="pwd" placeholder="@lang('faq.email') *" name="pswd">
                    <input type="text" class="form-control" id="email" placeholder="@lang('faq.subject') *" name="email">
                    <textarea placeholder="@lang('faq.write_message') *"></textarea>
                    <button class=" btn s-msg">@lang('faq.send_message')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section ('scripts')
<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.in").each(function(){
        	$(this).siblings(".panel-heading").find(".glyphicon").addClass("rotate");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").addClass("rotate");
        }).on('hide.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("rotate");
        });
    });
</script>
@endsection