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

@section ('scripts')
<script>
    $("#page_body").summernote({ height: 300 });
    $(document).ready(function() {

        $("#page_save").click(function(){
            var page_info = {
                page_name: $("#page_name").val(),
                page_url: $("#page_url").val(),
                type: "page"
            };
            if ($("#hidden_id").val() == '') {
                $.ajax({
                    url: '/create_page',
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
                                $("#hidden_id").val(id);
                                alert("Page is created successfully");
                            } 
                        }
                    }
                });
            } else {
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
                            alert("Updated successfully");
                        }
                    }
                });
            }
        });

        $("#page_body_save").click(function () {
            var body_info = {
                page_body: $("#page_body").summernote('code'),
                hidden_id: $("#hidden_id").val(),
                type: "page_body"
            };
            if ($("#hidden_id").val() != '') {
                $.ajax({
                    url: '/create_page',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: body_info,
                    dataType: 'JSON',
                    success: function (data) {
                        var status=JSON.stringify(data['status']);
                        if(status=='false') {
                            $.each(data.errors,function(index,value){
                                $("#" + index + "_error").show();
                                $("#" + index + "_error").text(value[0]);
                            });
                        } else {
                            $("#hidden_id").val(data['id']);
                            alert("Page Body updated successfully");
                        }
                    }
                });
            } else {
                alert("Complete page setting first!");
            }
        });

        $("#meta_save").click(function(){
            var meta_info = {
                meta_title: $("#meta_title").val(),
                meta_description: $("#meta_description").val(),
                hidden_id: $("#hidden_id").val(),
                type: "meta"
            };
            if ($("#hidden_id").val() != '') {
                $.ajax({
                    url: '/create_page',
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
            } else {
                alert("Complete page setting first!");
            }
        });
    });
</script>
@endsection