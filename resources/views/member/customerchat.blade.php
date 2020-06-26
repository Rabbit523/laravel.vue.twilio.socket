@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof chat">
        <div id="chat-component">
            <customer-component :_consultants="{{ $consultants }}" :auth-customer="{{ $authCustomer }}"></customer-component>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(function(){
        var user = @json($authCustomer);
        new gotoconsult.Controllers.public(user);
    });
</script>
@endsection