@extends('layout.private')
@section('title', 'GoToConsult - Edit Page')
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
                @if($page->id == 63)
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part (English)</h2>
                        <label>Title</label>
                        <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" ><br>
                        <label>Button</label>
                        <input type="text" id="header_en_button" value="{{$page_body->en_header->button_title}}" ><br>
                        <label>Button Link</label>
                        <input type="text" id="header_en_button_link" value="{{$page_body->en_header->button_link}}" ><br>
                        <button class="sp-f save-btn btn" id="en_header_save">@lang('admin.save')</button>
                    </div>
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part (Norwegian)</h2>
                        <label>Title</label>
                        <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" ><br>
                        <label>Button</label>
                        <input type="text" id="header_no_button" value="{{$page_body->no_header->button_title}}" ><br>
                        <label>Button Link</label>
                        <input type="text" id="header_no_button_link" value="{{$page_body->no_header->button_link}}" ><br>
                        <button class="sp-f save-btn btn" id="no_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting toggle-content">
                    <h2>List</h2>
                    <button class="sp-f btn add" id="home_list_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                    <div class="guide-group">
                        @foreach($page_body->list as $key => $item)
                        <div class="panel panel-default" id="home_guide_panel{{$key}}">
                            <a class="remove_guide_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                            <div class="panel-heading">
                                <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#guide_collapse{{$key}}">
                                    <span class="glyphicon glyphicon-menu-right"></span>
                                    <input type="text" id="guide_en_title{{$key}}" value="{{$item->en_title}}" ><br>
                                </div>
                            </div>
                            <div id="guide_collapse{{$key}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <label>Description (English)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="guide_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                    <label>Title (Norwegian)</label>
                                    <input type="text" id="guide_no_title{{$key}}" value="{{$item->no_title}}" ><br>
                                    <label>Description (Norwegian)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="guide_no_des{{$key}}">{{$item->no_des}}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="sp-f save-btn btn" id="home_list_save">@lang('admin.save')</button>
                </div>
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Consultants Available Text (English)</h2>
                        <input type="text" id="consult_en_available" value="{{$page_body->consult_available->en}}" ><br>
                        <h2>Consultants Available Text (Norwegian)</h2>
                        <input type="text" id="consult_no_available" value="{{$page_body->consult_available->no}}" ><br>
                        <button class="sp-f save-btn btn" id="consult_available">@lang('admin.save')</button>
                    </div>
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Consultants Review Text (English)</h2>
                        <input type="text" id="consult_en_review" value="{{$page_body->consult_review->en}}" ><br>
                        <h2>Consultants Review Text (Norwegian)</h2>
                        <input type="text" id="consult_no_review" value="{{$page_body->consult_review->no}}" ><br>
                        <button class="sp-f save-btn btn" id="consult_review">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting toggle-content">
                    <h2>Description with Image</h2>
                    <button class="sp-f btn add" id="home_help_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                    <div class="help-group">
                        @foreach($page_body->help_list as $key => $item)
                        <div class="panel panel-default" id="home_help_panel{{$key}}">
                            <a class="remove_help_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                            <div class="panel-heading">
                                <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#help_collapse{{$key}}">
                                    <span class="glyphicon glyphicon-menu-right"></span>
                                    <input type="text" id="help_en_title{{$key}}" value="{{$item->en_title}}" ><br>
                                </div>
                            </div>
                            <div id="help_collapse{{$key}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <input type="file" class="help_file" data-id="{{$key}}" accept="image/*"><br>
                                    <input type='hidden' id="help_path{{$key}}" value="{{$item->path}}">
                                    <label>Description (English)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="help_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                    <label>Title (Norwegian)</label>
                                    <input type="text" id="help_no_title{{$key}}" value="{{$item->no_title}}" ><br>
                                    <label>Description (Norwegian)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="help_no_des{{$key}}">{{$item->no_des}}</textarea><br>
                                    <label>Button Link</label>
                                    <input type="text" id="help_button_link{{$key}}" value="{{$item->button_link}}" ><br>
                                    <label>Button Title (English)</label>
                                    <input type="text" id="help_en_btn_title{{$key}}" value="{{$item->en_button_title}}" ><br>
                                    <label>Button Title (Norwegian)</label>
                                    <input type="text" id="help_no_btn_title{{$key}}" value="{{$item->no_button_title}}" >
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="sp-f save-btn btn" id="home_help_save">@lang('admin.save')</button>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Benefit Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_benefit_title" value="{{$page_body->benefit_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_benefit_title" value="{{$page_body->benefit_list->no_title}}" ><br>
                        <button class="sp-f save-btn btn benefit_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Benefit Item List</h2>
                        <button class="sp-f btn add" id="home_benefit_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="benefit-group">
                            @foreach($page_body->benefit_list->arr as $key => $item)
                            <div class="panel panel-default" id="home_benefit_panel{{$key}}">
                                <a class="remove_benefit_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#benefit_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                    </div>
                                </div>
                                <div id="benefit_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="icon_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type="hidden" id="benefit_icon{{$key}}" value="{{$item->path}}">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="benefit_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="benefit_no_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="home_benefit_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Benefit Button List</h2>
                        <button class="sp-f btn add" id="home_benefit_btn_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="benefit-btn-group">
                            @foreach($page_body->benefit_list->buttons as $key => $item)
                            <div class="panel panel-default" id="home_benefit_btn_panel{{$key}}">
                                <a class="remove_benefit_btn_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#benefit_btn_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="benefit_btn_en_title{{$key}}" value="{{$item->en_title}}" ><br>
                                    </div>
                                </div>
                                <div id="benefit_btn_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <label>Button Link</label>
                                        <input type="text" id="benefit_btn_link{{$key}}" value="{{$item->link}}" ><br>
                                        <label>Button Title (Norwegian)</label>
                                        <input type="text" id="benefit_btn_no_title{{$key}}" value="{{$item->no_title}}" >
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="home_benefit_btn_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Review Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_review_title" value="{{$page_body->review_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_review_title" value="{{$page_body->review_list->no_title}}" ><br>
                        <button class="sp-f save-btn btn review_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Review Item List</h2>
                        <button class="sp-f btn add" id="home_review_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="review-group">
                            @foreach($page_body->review_list->arr as $key => $item)
                            <div class="panel panel-default" id="home_review_panel{{$key}}">
                                <a class="remove_review_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#review_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="author{{$key}}" value="{{$item->name}}" >
                                    </div>
                                </div>
                                <div id="review_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="user_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type="hidden" id="review_path{{$key}}" value="{{$item->path}}">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="review_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="review_no_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="home_review_save">@lang('admin.save')</button>
                    </div>
                </div>
                @elseif($page->id == 1)
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Review Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_review_title" value="{{$page_body->review_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_review_title" value="{{$page_body->review_list->no_title}}" ><br>
                        <button class="sp-f save-btn btn review_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Review Item List</h2>
                        <button class="sp-f btn add" id="cat_review_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="cat-review-group">
                            @foreach($page_body->review_list->arr as $key => $item)
                            <div class="panel panel-default" id="cat_review_panel{{$key}}">
                                <a class="remove_review_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#cat_review_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="cat_author{{$key}}" value="{{$item->name}}" >
                                    </div>
                                </div>
                                <div id="cat_review_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="cat_review_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type="hidden" id="cat_review_path{{$key}}" value="{{$item->path}}">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="cat_review_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="cat_review_no_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="cat_review_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-seting-content d-flex flex-column">
                    <h2>Explore Category Title</h2>
                    <input type="text" id="en_category_title" value="{{$page_body->category_title->en}}" ><br>
                    <input type="text" id="no_category_title" value="{{$page_body->category_title->no}}" ><br>
                    <button class="sp-f save-btn btn category_title_save">@lang('admin.save')</button>
                </div>
                @elseif($page->id == 2)
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part (English)</h2>
                        <label>Title</label>
                        <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" ><br>
                        <label>Description</label>
                        <textarea rows="3" cols="100" class="form-control" id="header_en_des">{{$page_body->en_header->description}}</textarea><br>
                        <label>Button</label>
                        <input type="text" id="header_en_button" value="{{$page_body->en_header->button_title}}" ><br>
                        <label>Button Link</label>
                        <input type="text" id="header_en_button_link" value="{{$page_body->en_header->button_link}}" ><br>
                        <button class="sp-f save-btn btn" id="en_header_save">@lang('admin.save')</button>
                    </div>
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part (Norwegian)</h2>
                        <label>Title</label>
                        <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" ><br>
                        <label>Description</label>
                        <textarea rows="3" cols="100" class="form-control" id="header_no_des">{{$page_body->no_header->description}}</textarea><br>
                        <label>Button</label>
                        <input type="text" id="header_no_button" value="{{$page_body->no_header->button_title}}" ><br>
                        <label>Button Link</label>
                        <input type="text" id="header_no_button_link" value="{{$page_body->no_header->button_link}}" ><br>
                        <button class="sp-f save-btn btn" id="no_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Consultant Platform Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_platform_title" value="{{$page_body->platform_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_platform_title" value="{{$page_body->platform_list->no_title}}" ><br>
                        <input type="file" class="main_file" accept="image/*"><br>
                        <input type="hidden" id="platform_main_image" value="{{$page_body->platform_list->plat_img}}">
                        <button class="sp-f save-btn btn consultant_platform_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Constulatation Platform Item</h2>
                        <button class="sp-f btn add" id="platform_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="platform-group">
                            @foreach($page_body->platform_list->arr as $key => $item)
                            <div class="panel panel-default" id="platform_panel{{$key}}">
                                <a class="remove_plat_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#plat_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="en_platform_item_title{{$key}}" value="{{$item->en_title}}" ><br>
                                    </div>
                                </div>
                                <div id="plat_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="become_consult_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type='hidden' id="become_consult_icon{{$key}}" value="{{$item->icon}}">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="en_platform_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Title (Norwegian)</label>
                                        <input type="text" id="no_platform_item_title{{$key}}" value="{{$item->no_title}}" ><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="no_platform_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="become_plat_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Review Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_review_title" value="{{$page_body->review_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_review_title" value="{{$page_body->review_list->no_title}}" ><br>
                        <button class="sp-f save-btn btn review_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Review Item List</h2>
                        <button class="sp-f btn add" id="become_review_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="become-review-group">
                            @foreach($page_body->review_list->arr as $key => $item)
                            <div class="panel panel-default" id="become_review_panel{{$key}}">
                                <a class="remove_review_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#become_review_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="become_author{{$key}}" value="{{$item->name}}" >
                                    </div>
                                </div>
                                <div id="become_review_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="become_review_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type="hidden" id="become_review_path{{$key}}" value="{{$item->path}}">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="become_review_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="become_review_no_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="become_review_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Signup Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_become_register_title" value="{{$page_body->register_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_become_register_title" value="{{$page_body->register_list->no_title}}" ><br>
                        <label>Description Title (English)</label>
                        <input type="text" id="en_become_register_des_title" value="{{$page_body->register_list->en_des_title}}" ><br>
                        <label>Description Title (Norwegian)</label>
                        <input type="text" id="no_become_register_des_title" value="{{$page_body->register_list->no_des_title}}" ><br>
                        <button class="sp-f save-btn btn become_register_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Description Item List</h2>
                        <button class="sp-f btn add" id="become_register_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="become-register-group">
                            @foreach($page_body->register_list->arr as $key => $item)
                            <div class="panel panel-default" id="become_register_panel{{$key}}">
                                <a class="remove_register_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#become_register_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                    </div>
                                </div>
                                <div id="become_register_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="en_become_register_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="no_become_register_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="become_register_save">@lang('admin.save')</button>
                    </div>
                </div>
                @elseif($page->id == 3)
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part (English)</h2>
                        <label>Title</label>
                        <input type="text" id="header_en_title" value="{{$page_body->en_header->title}}" ><br>
                        <label>Button</label>
                        <input type="text" id="header_en_button" value="{{$page_body->en_header->button_title}}" ><br>
                        <label>Button Link</label>
                        <input type="text" id="header_en_button_link" value="{{$page_body->en_header->button_link}}" ><br>
                        <button class="sp-f save-btn btn" id="en_header_save">@lang('admin.save')</button>
                    </div>
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part (Norwegian)</h2>
                        <label>Title</label>
                        <input type="text" id="header_no_title" value="{{$page_body->no_header->title}}" ><br>
                        <label>Button</label>
                        <input type="text" id="header_no_button" value="{{$page_body->no_header->button_title}}" ><br>
                        <label>Button Link</label>
                        <input type="text" id="header_no_button_link" value="{{$page_body->no_header->button_link}}" ><br>
                        <button class="sp-f save-btn btn" id="no_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Article Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_article_title" value="{{$page_body->article_list->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_article_title" value="{{$page_body->article_list->no_title}}" ><br>
                        <button class="sp-f save-btn btn article_title_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Article Items</h2>
                        <button class="sp-f btn add" id="about_article_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="article-group">
                            @foreach($page_body->article_list->arr as $key => $item)
                            <div class="panel panel-default" id="about_article_panel{{$key}}">
                                <a class="remove_article_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#article_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="article_en_title{{$key}}" value="{{$item->en_title}}" ><br>
                                    </div>
                                </div>
                                <div id="article_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="article_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type="hidden" id="article_icon{{$key}}" value="{{$item->icon}}">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="article_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Title (Norwegian)</label>
                                        <input type="text" id="article_no_title{{$key}}" value="{{$item->no_title}}" ><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="article_no_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="about_article_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Story Part</h2>
                        <input type="file" class="story_file" accept="image/*"><br>
                        <input type="hidden" id="story_path" value="{{$page_body->story->path}}">
                        <label>Part Title (English)</label>
                        <input type="text" id="en_part_title" value="{{$page_body->story->en_part_title}}" ><br>
                        <label>Part Title (Norwegian)</label>
                        <input type="text" id="no_part_title" value="{{$page_body->story->no_part_title}}" ><br>
                        <label>Title (English)</label>
                        <input type="text" id="en_story_title" value="{{$page_body->story->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_story_title" value="{{$page_body->story->no_title}}" ><br>
                        <label>Description (English)</label>
                        <textarea rows="5" cols="150" class="form-control" id="en_story_des">{{$page_body->story->en_des}}</textarea><br>
                        <label>Description (Norwegian)</label>
                        <textarea rows="5" cols="150" class="form-control" id="no_story_des">{{$page_body->story->no_des}}</textarea><br>
                        <button class="sp-f save-btn btn" id="about_story_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Our Team Part</h2>
                        <label>Part Title (English)</label>
                        <input type="text" id="en_team_part_title" value="{{$page_body->team->en_part_title}}" ><br>
                        <label>Part Title (Norwegian)</label>
                        <input type="text" id="no_team_part_title" value="{{$page_body->team->no_part_title}}" ><br>
                        <label>Title (English)</label>
                        <input type="text" id="en_team_title" value="{{$page_body->team->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_team_title" value="{{$page_body->team->no_title}}" ><br>
                        <button class="sp-f save-btn btn about_team_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Article Items</h2>
                        <button class="sp-f btn add" id="about_team_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="team-group">
                            @foreach($page_body->team->arr as $key => $item)
                            <div class="panel panel-default" id="about_team_panel{{$key}}">
                                <a class="remove_team_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#team_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="team_member_name{{$key}}" value="{{$item->name}}" >
                                    </div>
                                </div>
                                <div id="team_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <input type="file" class="team_member_file" data-key="{{$key}}" accept="image/*"><br>
                                        <input type="hidden" id="team_member_avatar{{$key}}" value="{{$item->avatar}}">
                                        <label>Job (English)</label>
                                        <input type="text" id="en_team_job{{$key}}" value="{{$item->en_job}}" ><br>
                                        <label>Job (Norwegian)</label>
                                        <input type="text" id="no_team_job{{$key}}" value="{{$item->no_job}}" ><br>
                                        <label>Bio (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="en_team_bio{{$key}}">{{$item->en_bio}}</textarea><br>
                                        <label>Bio (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="no_team_bio{{$key}}">{{$item->no_bio}}</textarea><br>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="about_team_member_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="flex-row">
                    <div class="page-seting-content d-flex flex-column">
                        <h2>Get Started Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="en_get_started_title" value="{{$page_body->get_started->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="no_get_started_title" value="{{$page_body->get_started->no_title}}" ><br>
                        <button class="sp-f save-btn btn about_get_started_save">@lang('admin.save')</button>
                    </div>
                    <div class="page-setting toggle-content">
                        <h2>Get Started Items</h2>
                        <button class="sp-f btn add" id="about_started_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                        <div class="started-group">
                            @foreach($page_body->get_started->arr as $key => $item)
                            <div class="panel panel-default" id="about_started_panel{{$key}}">
                                <a class="remove_started_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                                <div class="panel-heading">
                                    <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#started_collapse{{$key}}">
                                        <span class="glyphicon glyphicon-menu-right"></span>
                                        <input type="text" id="started_en_title{{$key}}" value="{{$item->en_title}}" ><br>
                                    </div>
                                </div>
                                <div id="started_collapse{{$key}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <label>Description (English)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="started_en_des{{$key}}">{{$item->en_des}}</textarea><br>
                                        <label>Title (Norwegian)</label>
                                        <input type="text" id="started_no_title{{$key}}" value="{{$item->no_title}}" ><br>
                                        <label>Description (Norwegian)</label>
                                        <textarea rows="5" cols="150" class="form-control" id="started_no_des{{$key}}">{{$item->no_des}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button class="sp-f save-btn btn" id="about_started_save">@lang('admin.save')</button>
                    </div>
                </div>
                @elseif($page->id == 4)
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Header Part</h2>
                        <input type="file" class="faq_file" accept="image/*"><br>
                        <input type="hidden" id="faq_path">
                        <label>Title (English)</label>
                        <input type="text" id="faq_header_en_title" value="{{$page_body->header->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="faq_header_no_title" value="{{$page_body->header->no_title}}" ><br>
                        <label>Description (English)</label>
                        <textarea rows="5" cols="150" class="form-control" id="faq_header_en_des">{{$page_body->header->en_des}}</textarea>
                        <label>Description (Norwegian)</label>
                        <textarea rows="5" cols="150" class="form-control" id="faq_header_no_des">{{$page_body->header->no_des}}</textarea>
                        <button class="sp-f save-btn btn" id="faq_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Question Header Part</h2>
                        <label>Title (English)</label>
                        <input type="text" id="faq_question_header_en_title" value="{{$page_body->question_header->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="faq_question_header_no_title" value="{{$page_body->question_header->no_title}}" ><br>
                        <label>Message Title (English)</label>
                        <input type="text" id="faq_question_message_en_title" value="{{$page_body->question_header->en_msg_title}}" ><br>
                        <label>Message (Norwegian)</label>
                        <input type="text" id="faq_question_message_no_title" value="{{$page_body->question_header->no_msg_title}}" ><br>
                        <button class="sp-f save-btn btn" id="faq_question_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting toggle-content">
                    <h2>Questions</h2>
                    <button class="sp-f btn add" id="faq_question_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                    <div class="question-group">
                        @foreach($page_body->questions as $key => $item)
                        <div class="panel panel-default" id="faq_panel{{$key}}">
                            <a class="remove_question_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                            <div class="panel-heading">
                                <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}">
                                    <span class="glyphicon glyphicon-menu-right"></span>
                                    <input type="text" id="faq_question_en_que{{$key}}" value="{{$item->en_que}}" >
                                </div>
                            </div>
                            <div id="collapse{{$key}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <label>Answer (English)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="faq_question_en_asw{{$key}}">{{$item->en_asw}}</textarea><br>
                                    <label>Question (Norwegian)</label>
                                    <input type="text" id="faq_question_no_que{{$key}}" value="{{$item->no_que}}" ><br>
                                    <label>Answer (Norwegian)</label>
                                    <textarea rows="5" cols="150" class="form-control" id="faq_question_no_asw{{$key}}">{{$item->no_asw}}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="sp-f save-btn btn" id="faq_question_save">@lang('admin.save')</button>
                </div>
                @elseif($page->id == 7)
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Form Header Part</h2>
                        <input type="file" class="login_file" accept="image/*"><br>
                        <input type="hidden" id="login_path" value="{{$page_body->header->path}}">
                        <label>Title (English)</label>
                        <input type="text" id="login_header_en_title" value="{{$page_body->header->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="login_header_no_title" value="{{$page_body->header->no_title}}" ><br>
                        <label>Description (English)</label>
                        <textarea rows="2" cols="100" class="form-control" id="login_header_en_des">{{$page_body->header->en_des}}</textarea>
                        <label>Description (Norwegian)</label>
                        <textarea rows="2" cols="100" class="form-control" id="login_header_no_des">{{$page_body->header->no_des}}</textarea>
                        <button class="sp-f save-btn btn" id="login_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                @elseif($page->id == 8)
                <div class="page-setting meta-info d-flex">
                    <div class="admin page-seting-content d-flex flex-column">
                        <h2>Form Header Part</h2>
                        <input type="file" class="register_file" accept="image/*"><br>
                        <input type="hidden" id="register_path" value="{{$page_body->header->path}}">
                        <label>Title (English)</label>
                        <input type="text" id="register_header_en_title" value="{{$page_body->header->en_title}}" ><br>
                        <label>Title (Norwegian)</label>
                        <input type="text" id="register_header_no_title" value="{{$page_body->header->no_title}}" ><br>
                        <label>Description (English)</label>
                        <textarea rows="2" cols="100" class="form-control" id="register_header_en_des">{{$page_body->header->en_des}}</textarea>
                        <label>Description (Norwegian)</label>
                        <textarea rows="2" cols="100" class="form-control" id="register_header_no_des">{{$page_body->header->no_des}}</textarea>
                        <label>List Title (English)</label>
                        <input type="text" id="register_header_en_list_title" value="{{$page_body->header->en_list_title}}" ><br>
                        <label>List Title (Norwegian)</label>
                        <input type="text" id="register_header_no_list_title" value="{{$page_body->header->no_list_title}}" ><br>
                        <button class="sp-f save-btn btn" id="register_header_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting toggle-content">
                    <h2>Items</h2>
                    <button class="sp-f btn add" id="register_list_add"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus-square fa-w-14 fa-lg"><path fill="currentColor" d="M352 240v32c0 6.6-5.4 12-12 12h-88v88c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-88h-88c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h88v-88c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v88h88c6.6 0 12 5.4 12 12zm96-160v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48zm-48 346V86c0-3.3-2.7-6-6-6H54c-3.3 0-6 2.7-6 6v340c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z" class=""></path></svg></button>
                    <div class="register-item-group">
                        @foreach($page_body->list as $key => $item)
                        <div class="panel panel-default" id="register_panel{{$key}}">
                            <a class="remove_register_item remove_btn" data-key={{$key}}><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-lg"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"></path></svg></a>
                            <div class="panel-heading">
                                <div class="toggle-input" data-toggle="collapse" data-parent="#accordion" href="#reg_collapse{{$key}}">
                                    <span class="glyphicon glyphicon-menu-right"></span>
                                    <input type="text" id="register_item_en_text{{$key}}" value="{{$item->en_txt}}" >
                                </div>
                            </div>
                            <div id="reg_collapse{{$key}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <input type="file" class="register_item_file" data-key="{{$key}}" accept="image/*"><br>
                                    <input type="hidden" id="register_item_path{{$key}}" value="{{$item->path}}">
                                    <label>Text (Norwegian)</label>
                                    <input type="text" id="register_item_no_text{{$key}}" value="{{$item->no_txt}}" ><br>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="sp-f save-btn btn" id="register_item_save">@lang('admin.save')</button>
                </div>
                @endif
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

        //Home page functions
        $("#en_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "en_header",
                page_body: {
                    "title": $("#header_en_title").val(),
                    "button_title": $("#header_en_button").val(),
                    "button_link": $("#header_en_button_link").val(),
                }
            };
            if (body_info.hidden_id == 2) {
                body_info.page_body.description = $("#header_en_des").val();
            }
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
                    alert("Header English part is updated successfully");
                }
            });
        });
        $("#no_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "no_header",
                page_body: {
                    "title": $("#header_no_title").val(),
                    "button_title": $("#header_no_button").val(),
                    "button_link": $("#header_no_button_link").val()
                }
            };
            if (body_info.hidden_id == 2) {
                body_info.page_body.description = $("#header_no_des").val();
            }
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
                    alert("Header Norwegian part is updated successfully");
                }
            });
        });
        $("#home_list_add").click(function() {
            var key = $(".guide-group .panel").length;
            var new_item = "<div class='panel panel-default' id='home_guide_panel"+key+"'><a class='remove_guide_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#guide_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='guide_en_title"+key+"'></div></div>";
            new_item +="<div id='guide_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='guide_en_des"+key+"'></textarea><br><label>Title (Norwegian)</label><input type='text' id='guide_no_title"+key+"'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='guide_no_des"+key+"'></textarea></div></div></div>";
            $(".guide-group").append(new_item);
        });
        $("#home_list_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "list",
                page_body: []
            };
            var count = $(".guide-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_title: $("#guide_en_title"+i).val(),
                    no_title: $("#guide_no_title"+i).val(),
                    en_des: $("#guide_en_des"+i).val(),
                    no_des: $("#guide_no_des"+i).val()
                });
            }
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
                    alert("Question is updated successfully");
                }
            });
        });
        $('.guide-group').on('click', '.remove_guide_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "list",
                page_body: []
            };
            var key = $(this).data('key');
            $('#home_guide_panel'+key).remove();
            var count = $(".guide-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_title: $("#guide_en_title"+i).val(),
                    no_title: $("#guide_no_title"+i).val(),
                    en_des: $("#guide_en_des"+i).val(),
                    no_des: $("#guide_no_des"+i).val()
                });
            }
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
                    alert("Question is updated successfully");
                }
            });
        });
        $("#consult_available").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "consult_available",
                page_body: {
                    en: $("#consult_en_available").val(),
                    no: $("#consult_no_available").val()
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
                    alert("Consult Available part is updated successfully");
                }
            });
        });
        $("#consult_review").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "consult_review",
                page_body: {
                    en: $("#consult_en_review").val(),
                    no: $("#consult_no_review").val()
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
                    alert("Consult Available part is updated successfully");
                }
            });
        });
        $(".help_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('id');
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/admin_home_help_image_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    if (e.status) {
                        $("#help_path"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#home_help_add").click(function() {
            var key = $(".help-group .panel").length;
            var new_item = "<div class='panel panel-default' id='home_help_panel"+key+"'><a class='remove_help_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#help_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='help_en_title"+key+"'></div></div>";
            new_item +="<div id='help_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='help_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='help_path"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='help_en_des"+key+"'></textarea><br><label>Title (Norwegian)</label><input type='text' id='help_no_title"+key+"'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='help_no_des"+key+"'></textarea><br><label>Button Link</label><input type='text' id='help_button_link"+key+"'><br><label>Button Title (English)</label><input type='text' id='help_en_btn_title"+key+"'><br><label>Button Title (Norwegian)</label><input type='text' id='help_no_btn_title"+key+"'></div></div></div>";
            $(".help-group").append(new_item);
        });
        $("#home_help_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "help_list",
                page_body: []
            };
            var count = $(".help-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#help_path"+i).val(), 
                    en_title: $("#help_en_title"+i).val(),
                    no_title: $("#help_no_title"+i).val(),
                    en_des: $("#help_en_des"+i).val(),
                    no_des: $("#help_no_des"+i).val(),
                    button_link: $("#help_button_link"+i).val(),
                    en_button_title: $("#help_en_btn_title"+i).val(),
                    no_button_title: $("#help_no_btn_title"+i).val()
                });
            }
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
        $('.help-group').on('click', '.remove_help_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "help_list",
                page_body: []
            };
            var key = $(this).data('key');
            $('#home_help_panel'+key).remove();
            var count = $(".help-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#help_path"+i).val(), 
                    en_title: $("#help_en_title"+i).val(),
                    no_title: $("#help_no_title"+i).val(),
                    en_des: $("#help_en_des"+i).val(),
                    no_des: $("#help_no_des"+i).val(),
                    button_link: $("#help_button_link"+i).val(),
                    en_button_title: $("#help_en_btn_title"+i).val(),
                    no_button_title: $("#help_no_btn_title"+i).val()
                });
            }
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
        $(".benefit_title_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "benefit_title",
                page_body: {
                    en: $("#en_benefit_title").val(),
                    no: $("#no_benefit_title").val()
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
                    alert("Consult Available part is updated successfully");
                }
            });
        });
        $(".icon_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/admin_home_benefit_image_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    if (e.status) {
                        $("#benefit_icon"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#home_benefit_add").click(function() {
            var key = $(".benefit-group .panel").length;
            var new_item = "<div class='panel panel-default' id='home_benefit_panel"+key+"'><a class='remove_benefit_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#benefit_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span></div></div>";
            new_item +="<div id='benefit_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='icon_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='benefit_icon"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='benefit_en_des"+key+"'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='benefit_no_des"+key+"'></textarea></div></div></div>";
            $(".benefit-group").append(new_item);
        });
        $("#home_benefit_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "benefit_arr",
                page_body: []
            };
            var count = $(".benefit-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#benefit_icon"+i).val(),
                    en_des: $("#benefit_en_des"+i).val(),
                    no_des: $("#benefit_no_des"+i).val()
                });
            }
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
        $('.benefit-group').on('click', '.remove_benefit_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "benefit_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#home_benefit_panel'+key).remove();
            var count = $(".benefit-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#benefit_icon"+i).val(),
                    en_des: $("#benefit_en_des"+i).val(),
                    no_des: $("#benefit_no_des"+i).val()
                });
            }
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
        $("#home_benefit_btn_add").click(function() {
            var key = $(".benefit-btn-group .panel").length;
            var new_item = "<div class='panel panel-default' id='home_benefit_btn_panel"+key+"'><a class='remove_benefit_btn_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#benefit_btn_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='benefit_btn_en_title"+key+"' ><br></div></div>";
            new_item +="<div id='benefit_btn_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><label>Button Link</label><input type='text' id='benefit_btn_link"+key+"'><br><label>Button Title (Norwegian)</label><input type='text' id='benefit_btn_no_title"+key+"'></div></div></div>";
            $(".benefit-btn-group").append(new_item);
        });
        $("#home_benefit_btn_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "benefit_button",
                page_body: []
            };
            var count = $(".benefit-btn-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    link: $("#benefit_btn_link"+i).val(),
                    en_title: $("#benefit_btn_en_title"+i).val(),
                    no_title: $("#benefit_btn_no_title"+i).val()
                });
            }
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
        $('.benefit-btn-group').on('click', '.remove_benefit_btn_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "benefit_button",
                page_body: []
            };
            var key = $(this).data('key');
            $('#home_benefit_btn_panel'+key).remove();
            var count = $(".benefit-btn-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    link: $("#benefit_btn_link"+i).val(),
                    en_title: $("#benefit_btn_en_title"+i).val(),
                    no_title: $("#benefit_btn_no_title"+i).val()
                });
            }
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
        $(".review_title_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_title",
                page_body: {
                    en: $("#en_review_title").val(),
                    no: $("#no_review_title").val()
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
                    alert("Review Title is updated successfully");
                }
            });
        });
        $(".user_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/admin_home_review_image_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    if (e.status) {
                        $("#review_path"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#home_review_add").click(function() {
            var key = $(".review-group .panel").length;
            var new_item = "<div class='panel panel-default' id='home_review_panel"+key+"'><a class='remove_review_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#review_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='author"+key+"'></div></div>";
            new_item +="<div id='review_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='user_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='review_path"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='review_en_des"+key+"'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='review_no_des"+key+"'></textarea></div></div></div>";
            $(".review-group").append(new_item);
        });
        $("#home_review_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_arr",
                page_body: []
            };
            var count = $(".review-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#review_path"+i).val(),
                    en_des: $("#review_en_des"+i).val(),
                    no_des: $("#review_no_des"+i).val(),
                    name: $("#author"+i).val()
                });
            }
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
        $('.review-group').on('click', '.remove_review_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#home_review_panel'+key).remove();
            var count = $(".review-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#review_path"+i).val(),
                    en_des: $("#review_en_des"+i).val(),
                    no_des: $("#review_no_des"+i).val(),
                    name: $("#author"+i).val()
                });
            }
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
        // Category single page functions
        $(".category_title_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "category_title",
                page_body: {
                    "en": $("#en_category_title").val(),
                    "no": $("#no_category_title").val()
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
                    alert("Explore category title is updated successfully");
                }
            });
        });
        $(".cat_review_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/admin_home_review_image_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    if (e.status) {
                        $("#cat_review_path"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#cat_review_add").click(function() {
            var key = $(".cat-review-group .panel").length;
            var new_item = "<div class='panel panel-default' id='cat_review_panel"+key+"'><a class='remove_review_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#cat_review_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='cat_author"+key+"'></div></div>";
            new_item +="<div id='cat_review_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='cat_review_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='cat_review_path"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='cat_review_en_des"+key+"'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='cat_review_no_des"+key+"'></textarea></div></div></div>";
            $(".cat-review-group").append(new_item);
        });
        $("#cat_review_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_arr",
                page_body: []
            };
            var count = $(".cat-review-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#cat_review_path"+i).val(),
                    en_des: $("#cat_review_en_des"+i).val(),
                    no_des: $("#cat_review_no_des"+i).val(),
                    name: $("#cat_author"+i).val()
                });
            }
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
        $('.cat-review-group').on('click', '.remove_review_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#cat_review_panel'+key).remove();
            var count = $(".cat-review-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#cat_review_path"+i).val(),
                    en_des: $("#cat_review_en_des"+i).val(),
                    no_des: $("#cat_review_no_des"+i).val(),
                    name: $("#cat_author"+i).val()
                });
            }
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
        // Become consultant page functions
        $(".main_file").on('change', function() {
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
                        $("#platform_main_image").val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $(".consultant_platform_title_save").click(function(){
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "platform_title",
                page_body: {
                    "en": $("#en_platform_title").val(),
                    "no": $("#no_platform_title").val(),
                    "plat_img": $("#platform_main_image").val()
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
                    alert("Explore category title is updated successfully");
                }
            });
        });
        $(".become_consult_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
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
                        $("#become_consult_icon"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#platform_add").click(function() {
            var key = $(".platform-group .panel").length;
            var new_item = "<div class='panel panel-default' id='platform_panel"+key+"'><a class='remove_plat_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#plat_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='en_platform_item_title"+key+"'></div></div>";
            new_item +="<div id='plat_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='become_consult_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='become_consult_icon"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='en_platform_des"+key+"'></textarea><br><label>Title (Norwegian)</label><input type='text' id='no_platform_item_title"+key+"'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_platform_des"+key+"'></textarea></div></div></div>";
            $(".platform-group").append(new_item);
        });
        $("#become_plat_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "become_consult_arr",
                page_body: []
            };
            var count = $(".platform-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    icon: $("#become_consult_icon"+i).val(),
                    en_des: $("#en_platform_des"+i).val(),
                    no_des: $("#no_platform_des"+i).val(),
                    en_title: $("#en_platform_item_title"+i).val(),
                    no_title: $("#no_platform_item_title"+i).val(),
                });
            }
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
        $('.platform-group').on('click', '.remove_plat_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "become_consult_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#platform_panel'+key).remove();
            var count = $(".platform-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    icon: $("#become_consult_icon"+i).val(),
                    en_des: $("#en_platform_des"+i).val(),
                    no_des: $("#no_platform_des"+i).val(),
                    en_title: $("#en_platform_item_title"+i).val(),
                    no_title: $("#no_platform_item_title"+i).val(),
                });
            }
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
        $(".become_review_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/admin_home_review_image_upload',
                data: formdata,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (e) {
                    if (e.status) {
                        $("#become_review_path"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#become_review_add").click(function() {
            var key = $(".become-review-group .panel").length;
            var new_item = "<div class='panel panel-default' id='become_review_panel"+key+"'><a class='remove_review_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#become_review_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='become_author"+key+"'></div></div>";
            new_item +="<div id='become_review_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='become_review_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='become_review_path"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='become_review_en_des"+key+"'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='become_review_no_des"+key+"'></textarea></div></div></div>";
            $(".become-review-group").append(new_item);
        });
        $("#become_review_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_arr",
                page_body: []
            };
            var count = $(".become-review-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#become_review_path"+i).val(),
                    en_des: $("#become_review_en_des"+i).val(),
                    no_des: $("#become_review_no_des"+i).val(),
                    name: $("#become_author"+i).val()
                });
            }
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
        $('.become-review-group').on('click', '.remove_review_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "review_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#become_review_panel'+key).remove();
            var count = $(".become-review-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#become_review_path"+i).val(),
                    en_des: $("#become_review_en_des"+i).val(),
                    no_des: $("#become_review_no_des"+i).val(),
                    name: $("#become_author"+i).val()
                });
            }
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
        $(".become_register_title_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "register_title",
                page_body: {
                    "en": $("#en_become_register_title").val(),
                    "no": $("#no_become_register_title").val(),
                    "en_des": $("#en_become_register_des_title").val(),
                    "no_des": $("#no_become_register_des_title").val()
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
                    alert("Explore category title is updated successfully");
                }
            });
        });
        $("#become_register_add").click(function() {
            var key = $(".become-register-group .panel").length;
            var new_item = "<div class='panel panel-default' id='become_register_panel"+key+"'><a class='remove_register_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#become_register_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span></div></div>";
            new_item +="<div id='become_register_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='en_become_register_des"+key+"'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_become_register_des"+key+"'></textarea></div></div></div>";
            $(".become-register-group").append(new_item);
        });
        $("#become_register_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "register_arr",
                page_body: []
            };
            var count = $(".become-register-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_des: $("#en_become_register_des"+i).val(),
                    no_des: $("#no_become_register_des"+i).val()
                });
            }
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
        $('.become-register-group').on('click', '.remove_register_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "register_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#become_register_panel'+key).remove();
            var count = $(".become-register-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_des: $("#en_become_register_des"+i).val(),
                    no_des: $("#no_become_register_des"+i).val()
                });
            }
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
        // About us page functions
        $(".article_title_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "article_title",
                page_body: {
                    "en": $("#en_article_title").val(),
                    "no": $("#no_article_title").val()
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
                    alert("Explore category title is updated successfully");
                }
            });
        });
        $(".article_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
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
                        $("#article_icon"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#about_article_add").click(function() {
            var key = $(".article-group .panel").length;
            var new_item = "<div class='panel panel-default' id='about_article_panel"+key+"'><a class='remove_article_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#article_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='article_en_title"+key+"'></div></div>";
            new_item +="<div id='article_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='article_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='article_icon"+key+"'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='article_en_des"+key+"'></textarea><br><label>Title (Norwegian)</label><input type='text' id='article_no_title"+key+"'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='article_no_des"+key+"'></textarea></div></div></div>";
            $(".article-group").append(new_item);
        });
        $("#about_article_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "article_arr",
                page_body: []
            };
            var count = $(".article-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    icon: $("#article_icon"+i).val(), 
                    en_title: $("#article_en_title"+i).val(),
                    no_title: $("#article_no_title"+i).val(),
                    en_des: $("#article_en_des"+i).val(),
                    no_des: $("#article_no_des"+i).val()
                });
            }
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
        $('.article-group').on('click', '.remove_article_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "article_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#about_article_panel'+key).remove();
            var count = $(".article-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    icon: $("#article_icon"+i).val(), 
                    en_title: $("#article_en_title"+i).val(),
                    no_title: $("#article_no_title"+i).val(),
                    en_des: $("#article_en_des"+i).val(),
                    no_des: $("#article_no_des"+i).val()
                });
            }
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
        $(".story_file").on('change', function() {
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
                        $("#story_path").val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#about_story_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "story",
                page_body: {
                    "en_part_title": $("#en_part_title").val(),
                    "no_part_title": $("#no_part_title").val(),
                    "en_title": $("#en_story_title").val(),
                    "no_title": $("#no_story_title").val(),
                    "en_des": $("#en_story_des").val(),
                    "no_des": $("#no_story_des").val(),
                    "path": $("#story_path").val()
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
                    alert("Story part is updated successfully");
                }
            });
        });
        $(".team_member_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
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
                        $("#team_member_avatar"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $(".about_team_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "team_title",
                page_body: {
                    "en_part_title": $("#en_team_part_title").val(),
                    "no_part_title": $("#no_team_part_title").val(),
                    "en_title": $("#en_team_title").val(),
                    "no_title": $("#no_team_title").val()
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
                    alert("Team header is updated successfully");
                }
            });
        });
        $("#about_team_add").click(function() {
            var key = $(".team-group .panel").length;
            var new_item = "<div class='panel panel-default' id='about_team_panel"+key+"'><a class='remove_team_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#team_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='team_name"+key+"'></div></div>";
            new_item +="<div id='team_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='team_member_file' data-id='"+key+"' accept='image/*'><br><input type='hidden' id='team_member_avatar"+key+"'><label>Job (English)</label><input type='text' id='en_team_job"+key+"'><br><label>Job (Norwegian)</label><input type='text' id='no_team_job"+key+"'><br><label>Bio (English)</label><textarea rows='5' cols='150' class='form-control' id='en_team_bio"+key+"'></textarea><br><label>Bio (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_team_bio"+key+"'></textarea></div></div></div>";
            $(".team-group").append(new_item);
        });
        $("#about_team_member_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "team_arr",
                page_body: []
            };
            var count = $(".team-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    avatar: $("#team_member_avatar"+i).val(),
                    name: $("#team_member_name"+i).val(),
                    en_bio: $("#en_team_bio"+i).val(),
                    no_bio: $("#no_team_bio"+i).val(),
                    en_job: $("#en_team_job"+i).val(),
                    no_job: $("#no_team_job"+i).val(),
                });
            }
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
        $('.team-group').on('click', '.remove_team_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "team_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#about_team_panel'+key).remove();
            var count = $(".team-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    avatar: $("#team_member_avatar"+i).val(),
                    name: $("#team_member_name"+i).val(),
                    en_bio: $("#en_team_bio"+i).val(),
                    no_bio: $("#no_team_bio"+i).val(),
                    en_job: $("#en_team_job"+i).val(),
                    no_job: $("#no_team_job"+i).val(),
                });
            }
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
        $(".about_get_started_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "get_started_title",
                page_body: {
                    en: $("#en_get_started_title").val(),
                    no: $("#no_get_started_title").val()
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
                    alert("Get started part is updated successfully");
                }
            });
        });
        $("#about_started_add").click(function() {
            var key = $(".started-group .panel").length;
            var new_item = "<div class='panel panel-default' id='about_started_panel"+key+"'><a class='remove_started_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#started_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='started_en_title"+key+"'></div></div>";
            new_item +="<div id='started_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='started_en_des"+key+"'></textarea><br><label>Title (Norwegian)</label><input type='text' id='started_no_title"+key+"'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='started_no_des"+key+"'></textarea></div></div></div>";
            $(".started-group").append(new_item);
        });
        $("#about_started_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "get_started_arr",
                page_body: []
            };
            var count = $(".started-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_title: $("#started_en_title"+i).val(),
                    no_title: $("#started_no_title"+i).val(),
                    en_des: $("#started_en_des"+i).val(),
                    no_des: $("#started_no_des"+i).val()
                });
            }
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
        $('.started-group').on('click', '.remove_started_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "get_started_arr",
                page_body: []
            };
            var key = $(this).data('key');
            $('#about_started_panel'+key).remove();
            var count = $(".started-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_title: $("#started_en_title"+i).val(),
                    no_title: $("#started_no_title"+i).val(),
                    en_des: $("#started_en_des"+i).val(),
                    no_des: $("#started_no_des"+i).val()
                });
            }
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
        //FAQ page functions
        $(".faq_file").on('change', function() {
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
                        $("#faq_path").val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#faq_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "header",
                page_body: {
                    "path": $("#faq_path").val(),
                    "en_des": $("#faq_header_en_des").val(),
                    "no_des": $("#faq_header_no_des").val(),
                    "en_title": $("#faq_header_en_title").val(),
                    "no_title": $("#faq_header_no_title").val()
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
                    alert("FAQ header part is updated successfully");
                }
            });
        });
        $("#faq_question_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "question_header",
                page_body: {
                    "en_msg_title": $("#faq_question_message_en_title").val(),
                    "no_msg_title": $("#faq_question_message_no_title").val(),
                    "en_title": $("#faq_question_header_en_title").val(),
                    "no_title": $("#faq_question_header_no_title").val()
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
                    alert("Question header part is updated successfully");
                }
            });
        });
        $("#faq_question_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "questions",
                page_body: []
            };
            var count = $(".question-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_que: $("#faq_question_en_que"+i).val(),
                    no_que: $("#faq_question_no_que"+i).val(),
                    en_asw: $("#faq_question_en_asw"+i).val(),
                    no_asw: $("#faq_question_no_asw"+i).val()
                });
            }
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
                    alert("Question is updated successfully");
                }
            });
        });
        $('.question-group').on('click', '.remove_question_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "questions",
                page_body: []
            };
            var key = $(this).data('key');
            $('#faq_panel'+key).remove();
            var count = $(".question-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    en_que: $("#faq_question_en_que"+i).val(),
                    no_que: $("#faq_question_no_que"+i).val(),
                    en_asw: $("#faq_question_en_asw"+i).val(),
                    no_asw: $("#faq_question_no_asw"+i).val()
                });
            }
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
                    alert("Question is updated successfully");
                }
            });
        });
        $("#faq_question_add").click(function() {
            var key = $(".question-group .panel").length;
            var new_item = "<div class='panel panel-default' id='faq_panel"+key+"'><a class='remove_question_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='faq_question_en_que"+key+"'></div></div>";
            new_item +="<div id='collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><label>Answer (English)</label><textarea rows='5' cols='150' class='form-control' id='faq_question_en_asw"+key+"'></textarea><br><label>Question (Norwegian)</label><input type='text' id='faq_question_no_que"+key+"'><br><label>Answer (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='faq_question_no_asw"+key+"'></textarea></div></div></div>";
            $(".question-group").append(new_item);
        });
        // Register page functions
        $(".register_file").on('change', function() {
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
                        $("#register_path").val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#register_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "header",
                page_body: {
                    "path": $("#register_path").val(),
                    "en_des": $("#register_header_en_des").val(),
                    "no_des": $("#register_header_no_des").val(),
                    "en_title": $("#register_header_en_title").val(),
                    "no_title": $("#register_header_no_title").val(),
                    "en_list_title": $("#register_header_en_list_title").val(),
                    "no_list_title": $("#register_header_no_list_title").val(),
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
                    alert("Register header part is updated successfully");
                }
            });
        });
        $(".register_item_file").on('change', function() {
            var formdata = new FormData();
            formdata.append('file', this.files[0]);
            var key = $(this).data('key');
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
                        $("#register_item_path"+key).val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#register_list_add").click(function() {
            var key = $(".register-item-group .panel").length;
            var new_item = "<div class='panel panel-default' id='register_panel"+key+"'><a class='remove_register_item remove_btn' data-key="+key+"><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' data-parent='#accordion' href='#reg_collapse"+key+"'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='register_item_en_text"+key+"'></div></div>";
            new_item +="<div id='reg_collapse"+key+"' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='register_item_file' data-key='"+key+"' accept='image/*'><br><input type='hidden' id='register_item_path"+key+"'><label>Text (Norwegian)</label><input type='text' id='register_item_no_text"+key+"'></div></div></div>";                                                                    
            $(".register-item-group").append(new_item);
        });
        $('.register-item-group').on('click', '.remove_register_item', function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "list",
                page_body: []
            };
            var key = $(this).data('key');
            $('#register_panel'+key).remove();
            var count = $(".register-item-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#register_item_path"+i).val(),
                    en_txt: $("#register_item_en_text"+i).val(),
                    no_txt: $("#register_item_no_text"+i).val()
                });
            }
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
                    alert("List item is updated successfully");
                }
            });
        });
        $("#register_item_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "list",
                page_body: []
            };
            var count = $(".register-item-group .panel").length;
            for (let i = 0; i < count; i ++) {
                body_info.page_body.push({
                    path: $("#register_item_path"+i).val(),
                    en_txt: $("#register_item_en_text"+i).val(),
                    no_txt: $("#register_item_no_text"+i).val()
                });
            }
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
                    alert("List item is updated successfully");
                }
            });
        });
        //Login page functions
        $(".login_file").on('change', function() {
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
                        $("#login_path").val(e.url);
                    } else {
                        alert("Error occured in uploading the image.");
                    }
                }
            });
        });
        $("#login_header_save").click(function() {
            var body_info = {
                type: "page_body",
                hidden_id: $("#hidden_id").val(),
                detail_type: "header",
                page_body: {
                    "path": $("#login_path").val(),
                    "en_des": $("#login_header_en_des").val(),
                    "no_des": $("#login_header_no_des").val(),
                    "en_title": $("#login_header_en_title").val(),
                    "no_title": $("#login_header_no_title").val()
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
                    alert("Login part is updated successfully");
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