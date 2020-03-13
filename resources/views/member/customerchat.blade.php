@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')

<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof chat">
        <div id="chat-component">
            <customer-component :_auth-user="{{ auth()->user() }}" :_consultants="{{ $consultants }}" :auth-customer="{{ $authCustomer }}"></customer-component>
        </div>
    </div>
</div>

@endsection
