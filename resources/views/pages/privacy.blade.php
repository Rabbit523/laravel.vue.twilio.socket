@extends('layout.public')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>

<div class="wrap">
  <div class="cate-info-page d-flex">
    <div class="left-ham d-flex">
      <img src="{{ $data->header->path }}" alt="hammer"/>
    </div>
    <div class="ham-content d-flex flex-column">
      @if($lang == 'en')
      <h3>{!! $data->header->en_title !!}</h3>
      <span>{!! $data->header->en_des !!}</span>
      @else
      <h3>{!! $data->header->no_title !!}</h3>
      <span>{!! $data->header->no_des !!}</span>
      @endif
    </div>
  </div>
</div>

<div class="p-p-content">
  <div class="center-content d-flex flex-column wrap">
    @if($lang == 'en')
    {!! $data->contents->en !!}
    @else
    {!! $data->contents->no !!}
    @endif
  </div>
</div>

@endsection