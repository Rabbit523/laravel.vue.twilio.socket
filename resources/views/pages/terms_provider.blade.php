@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="full-cart category">
  <div class="container">
    <div class="col-12 px-3 category-header">
      <div class="img-sec mr-3">
        <img src="{{$data->header->path}}" alt="icon">
      </div>
      <div class="des-sec">
        @if($lang == 'en')
        <h3>{!! $data->header->en_title !!}</h3>
        <p>{!! $data->header->en_des !!} <a href="{{$data->header->link}}">here.</a></profile>
        @else
        <h3>{!! $data->header->no_title !!}</h3>
        <p>{!! $data->header->no_des !!} <a href="{{$data->header->link}}">here.</a></p>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="p-p-content">
  <div class="container">
    <div class="col-12 px-3">
      <div class="center-content d-flex flex-column">
        @if ($lang == 'en')
        {!! $data->contents->en !!}
        @else
        {!! $data->contents->no !!}
        @endif
      </div>
    </div>
  </div>
</div>
@endsection