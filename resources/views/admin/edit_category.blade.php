@extends('layout.private')
@section('title', 'GoToConsult - Edit Category')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion">
		    <div class="single-page d-flex flex-column">
                <div class="single-page-heading single-page d-flex flex-column">
                    <h2>{{$category->category_name}}</h2>
                    <a href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}"><img src="{{ asset('images/back-icon.png')}}" alt="icon"/></a>
                </div>
                <form method="post" id="upload_form" enctype="multipart/form-data">
                    <input type="hidden" id="hidden_id" name="hidden_id" value="{{$category->id}}">
                    <input type="hidden" id="checkbox_value" name="checkbox_value" value="{{$category->image_access}}">
			        <div class="profile-uploader d-flex flex-column">
				        <h2>@lang('admin.category_icon')</h2>
				        <div class="profile-sec single-cate d-flex flex-column">
					        <div class="imageupload">
						        <div class="file-tab" {{$category->category_icon }} != null ? style="background: url(../{{ $category->category_icon }}) no-repeat scroll 0 0; background-size: contain;": ''>
                                    <label class="btn btn-default btn-file">
                                        <span>@lang('admin.browse_photo')</span>
                                        <input type="file" id="select_file" class="select_file" name="select_file">
						            </label>
        						</div>
					        </div>
					        <a class="remove-btn btn" id="remove_photo">@lang('admin.remove_image')</a>
					        <label class="switch">
                                <input type="checkbox" id="image_access" checked name="image_access" {{ $category->image_access == 1 ? 'checked' : '' }}>
                                <span class="slider"></span>
                                <span class="uncheck"></span>
                            </label>					
					        <input type="submit" name="upload" id="upload" class="sp-f cs btn save-btn" value="Upload">
                            <div class="alert" id="message" style="display: none"></div>
                        </div>
			        </div>
                </form>
                <input type="hidden" id="image_check" value="{{$category->category_icon}}">
                <div class="page-setting single-cate d-flex flex-column">
                    <h2>@lang('admin.category_settings')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.en_category_name')</label>
                        <input type="text" id="category_name" class="category_name" value="{{$category->category_name}}">
                        <label>@lang('admin.no_category_name')</label>
                        <input type="text" id="category_name_no" class="category_name" value="{{$category->category_name_no}}">
                        <label>@lang('admin.category_url')</label>
                        <div class="link-input d-flex">
                            <a href="#">https://gotoconsult.com/category/</a>
                            <input type="text" id="category_url" class="category_url" value="{{$category->category_url}}">
                        </div>
                        <label>@lang('admin.en_category_description')</label>
                        <textarea id="category_description" class="category_description">{{$category->category_description}} </textarea>
                        <label>@lang('admin.no_category_description')</label>
                        <textarea id="category_description_no" class="category_description">{{$category->category_description_no}} </textarea>
                        <button class="sp-f cs save-btn btn" id="profile_save">@lang('admin.save')</button>
                    </div>
                </div>
                <div class="page-setting meta-info d-flex flex-column">
                    <h2>@lang('admin.meta_information')</h2>
                    <div class="page-seting-content d-flex flex-column">
                        <label>@lang('admin.meta_title')</label>
                        <input type="text" id="meta_title" class="meta_title" value="{{$category->meta_title}}">
                        <div class="alert" id="meta_title_error"></div>
                        <label>@lang('admin.meta_description')</label>
                        <textarea rows="4" id="meta_description" class="meta_description" >{{$category->meta_description}}</textarea>
                        <div class="alert" id="meta_description_error"></div>
                        <button class="sp-f cs save-btn btn" id="meta_save">@lang('admin.save')</button>
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
		new gotoconsult.Controllers.editCategory();
	});
</script>
@endsection