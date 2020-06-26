@extends('layout.private')
@section('title', 'GoToConsult - Edit terms of customers')
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
                        <input type="hidden" id="hidden_id" value="{{$page->id}}">
                        <label>@lang('admin.page_name')</label>
                        <input type="text" name="page_name" id="page_name" value="{{$page->page_name}}"/>
                        <div class="alert" id="page_name_error"></div>
                        <label>@lang('admin.page_url')</label>
                        <div class="link-input d-flex">
                            <a href="#">https://gotoconsult.com/</a>
                            <input type="text" name="page_url" id="page_url" value="{{$page->page_url}}"/>
                            <div class="alert" id="page_url_error"></div>
                        </div>
                        <button type="button" id="page_save" class="sp-f save-btn btn cs" >@lang('admin.save')</button>
                    </div>
				</div>
				<div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part</h2>
                        <input type="file" class="terms_file" accept="image/*"><br>
                        <input type="hidden" id="terms_path" value="{{$page_body->header->path}}">
                        <label>Title (English)</label>
                        <input type="text" id="terms_header_en_title" value="{{$page_body->header->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="terms_header_no_title" value="{{$page_body->header->no_title}}" ><br>
                        <label>Description (English)</label>
                        <textarea rows="2" cols="100" class="form-control" id="terms_header_en_des">{{$page_body->header->en_des}}</textarea><br>
                        <label>Description (Norwegian)</label>
                        <textarea rows="2" cols="100" class="form-control" id="terms_header_no_des">{{$page_body->header->no_des}}</textarea><br>
                        <label>Link</label>
                        <input type="text" id="terms_header_link" value="{{$page_body->header->link}}" ><br>
                        <button class="sp-f save-btn btn" id="terms_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="body-section d-flex flex-column">
                    <h2>Content (English)</h2>
                    <textarea class="form-control" id="en_terms_page_body"></textarea><br>
                    <h2>Content (Norwegian)</h2>
                    <textarea class="form-control" id="no_terms_page_body"></textarea>
                    <div class="save-button d-flex">
                        <button class="sp-f btn save-btn cs" id="terms_page_body_save">@lang('admin.save')</button>
                    </div>
                </div>
				<div class="page-setting meta-info d-flex flex-column">
                    <h2>@lang('admin.meta_information')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.meta_title')</label>
                        <input type="text" id="meta_title" value="{{$page->meta_title}}" ><br>
                        <div class="alert" id="meta_title_error"></div>
                        <label>@lang('admin.meta_description')</label>
                        <textarea rows="4" cols="150" class="form-control" id="meta_description">{{$page->meta_description}}</textarea><br>
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
        var en_content = @json($page_body->contents->en);
        var no_content = @json($page_body->contents->no);
		new gotoconsult.Controllers.editTermsCustomer(en_content, no_content);
	});
</script>
@endsection