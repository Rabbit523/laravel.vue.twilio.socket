@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof chat">
        <div id="chat-component">
            <consultant-component :auth-user="{{ auth()->user() }}" :_customers="{{ $customers }}" :auth-consultant="{{ $authConsultant }}"></consultant-component>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(function(){
        var user = @json($authConsultant);
        new gotoconsult.Controllers.public(user);
    });
</script>
@endsection