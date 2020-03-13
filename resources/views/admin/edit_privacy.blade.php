@extends('layout.private')
@section('title', 'GoToConsult - Edit Privacy')
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
                        <input type="file" class="privacy_file" accept="image/*"><br>
                        <input type="hidden" id="privacy_path" value="{{$page_body->header->path}}">
                        <label>Title (English)</label>
                        <input type="text" id="privacy_header_en_title" value="{{$page_body->header->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="privacy_header_no_title" value="{{$page_body->header->no_title}}" ><br>
                        <label>Description (English)</label>
                        <textarea rows="2" cols="100" class="form-control" id="privacy_header_en_des">{{$page_body->header->en_des}}</textarea><br>
                        <label>Description (Norwegian)</label>
                        <textarea rows="2" cols="100" class="form-control" id="privacy_header_no_des">{{$page_body->header->no_des}}</textarea>
                        <button class="sp-f save-btn btn" id="privacy_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="body-section d-flex flex-column">
                    <h2>Content (English)</h2>
                    <textarea class="form-control" id="en_privacy_page_body"></textarea> <br>
                    <h2>Content (Norwegian)</h2>
                    <textarea class="form-control" id="no_privacy_page_body"></textarea>
                    <div class="save-button d-flex">
                        <button class="sp-f btn save-btn cs" id="privacy_page_body_save">@lang('admin.save')</button>
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
    $(document).ready(function() {
        
		var en_content = "{{$page_body->contents->en}}";
		en_content = en_content.replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
		$("#en_privacy_page_body").summernote({ height: 300 });
		$("#en_privacy_page_body").summernote('code', en_content);
		var no_content = "{{$page_body->contents->no}}";
		no_content = en_content.replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
		$("#no_privacy_page_body").summernote({ height: 300 });
		$("#no_privacy_page_body").summernote('code', no_content);

		$("#page_save").click(function(){
            var page_info = {
                page_name: $("#page_name").val(),
                page_url: $("#page_url").val(),
                hidden_id: $("#hidden_id").val(),
                type: "page"
            };
            $.ajax({
                url: '/update_page',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: page_info,
                dataType: 'JSON',
                success: function (data) {
                    var status=JSON.stringify(data['status']);
                    if(status=='false') {
                        $.each(data.errors,function(index,value){
                            $("#" + index + "_error").show();
                            $("#" + index + "_error").text(value[0]);
                        });
                    } else {
                        var id=JSON.stringify(data['id']);
                        if(id!='') {
                            $("#category_name_error").hide();
                            $("#category_url_error").hide();
                            $("#category_description_error").hide();
                            alert("Category updated successfully");
                        } 
                    }
                }
            });
        });
      
        $(".privacy_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/admin_become_consultant_platform_image_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    if (e.status) {
                        $("#privacy_path").val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });

        $("#privacy_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "header",
                page_body: {
                    "path": $("#privacy_path").val(),
                    "en_des": $("#privacy_header_en_des").val(),
                    "no_des": $("#privacy_header_no_des").val(),
                    "en_title": $("#privacy_header_en_title").val(),
                    "no_title": $("#privacy_header_no_title").val()
                }
            };
            $.ajax({
                url: '/update_page',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: body_info,
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    alert("Updated successfully");
                }
            });
        });

        $("#privacy_page_body_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "contents",
                page_body: {
                    "en": $("#en_privacy_page_body").summernote('code'),
                    "no": $("#no_privacy_page_body").summernote('code')
                }
            };
            $.ajax({
                url: '/update_page',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: body_info,
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    alert("Updated successfully");
                }
            });
        });

		$("#meta_save").click(function(){
            var meta_info = {
                meta_title: $("#meta_title").val(),
                meta_description: $("#meta_description").val(),
                hidden_id: $("#hidden_id").val(),
                type: "meta"
            };
            $.ajax({
                url: '/update_page',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: meta_info,
                dataType: 'JSON',
                success: function (data) {
                    var status=JSON.stringify(data['status']);
                    if(status=='false') {
                        $.each(data.errors,function(index,value){
                            $("#" + index + "_error").show();
                            $("#" + index + "_error").text(value[0]);
                        });
                    } else {
                        alert("Meta Data updated successfully");
                        $("#meta_title_error").hide();
                        $("#meta_description_error").hide();
                    }
                }
            });
        });
	});
</script>
@endsection