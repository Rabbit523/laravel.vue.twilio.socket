@extends('layout.private')
@section('title', 'GoToConsult - Create Page')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
	    <div class="content_holesecion">
		    <div class="page-list d-flex flex-column">
                <div class="single-page-heading single-page d-flex flex-column">
                    <a href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}"><img src="{{ asset('images/back-icon.png')}}" alt="icon"/></a>
                </div>
                <div class="page-setting d-flex flex-column">
                    <h2>@lang('admin.page_settings')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <input type="hidden" id="hidden_id">
                        <label>@lang('admin.page_name')</label>
                        <input type="text" name="page_name" id="page_name"/>
                        <div class="alert" id="page_name_error"></div>
                        <label>@lang('admin.page_url')</label>
                        <div class="link-input d-flex">
                            <a href="#">https://gotoconsult.com/</a>
                            <input type="text" name="page_url" id="page_url"/>
                            <div class="alert" id="page_url_error"></div>
                        </div>
                        <button type="button" id="page_save" class="sp-f save-btn btn cs" >@lang('admin.save')</button>
                    </div>
                </div>

                <div class="body-section d-flex flex-column">
                    <h2>@lang('admin.body')</h2>
                    <textarea class="form-control" id="page_body" name="page_body" ></textarea>
                    <div class="alert" id="page_body_error"></div>
                    <div class="save-button d-flex">
                        <button class="sp-f btn save-btn cs" id="page_body_save">@lang('admin.save')</button>
                    </div>
                </div>

                <div class="page-setting meta-info d-flex flex-column">
                    <h2>@lang('admin.meta_information')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.meta_title')</label>
                        <input type="text" id="meta_title" ><br>
                        <div class="alert" id="meta_title_error"></div>
                        <label>@lang('admin.meta_description')</label>
                        <textarea rows="4" cols="150" class="form-control" id="meta_description"></textarea><br>
                        <div class="alert" id="meta_description_error"></div>
                        <button class="sp-f save-btn btn" id="meta_save">@lang('admin.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
		new gotoconsult.Controllers.createPage();
	});
</script>
@endsection