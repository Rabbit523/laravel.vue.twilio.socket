@extends('layout.member')
@section('title', "Klarna Checkout")
@section('description', "Klarna Checkout API")
@section('content')

<div class="wrapper member-sidebar">
  @include('elements.member_sidebar')
  <div class="content-wrapper adminprof">
		<div class="content_holesecion">
      {!! $html_snippet !!}
    </div>
  </div>
</div>

@endsection