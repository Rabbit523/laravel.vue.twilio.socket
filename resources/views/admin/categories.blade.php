@extends('layout.private')
@section('title', 'GoToConsult - Categories')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion">
		    <div class="page-list">
                <div class="pages-heading category-heading">
                    <h2 class="mr-auto mt-auto mb-auto">@lang('admin.categories')</h2>
                    <a href="{{ $lang == 'en' ? url('/create-category') : url('/no/opprett-kategori') }}"><button class="btn">@lang('admin.create_category')</button></a>
                </div>
		    </div>
			<div class="status-section consult-table cust-table table-responsive">
				<table class="table table-borderless" id="example">
                    <thead>
                        <tr class="top">
                            <th>@lang('admin.category')</th>
							<th>@lang('admin.description')</th>
							<th>@lang('admin.slug')</th>
							<th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $data)
							<tr>
                                <td>{{$data->category_url}}</td>
                                <td>{{$data->category_description}}</td>
                                <td>{{$data->category_name}}</td>
                                <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-category/'.$data->id) : url('/no/rediger-kategori/'.$data->id) }}">@lang('admin.details') </a></td>
						    </tr>
                        @endforeach
                    </tbody>
				</table>
			</div>
		</div>
    </div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
		new gotoconsult.Controllers.categories();
	});
</script>
@endsection
