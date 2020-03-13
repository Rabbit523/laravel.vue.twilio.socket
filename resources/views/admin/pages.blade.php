@extends('layout.private')
@section('title', 'GoToConsult - Pages')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
	    <div class="content_holesecion">
		    <div class="page-list d-flex flex-column">
                <div class="pages-heading d-flex">
                    <h2 class="mr-auto mt-auto mb-auto">@lang('admin.pages')</h2>
                    <a href="{{ $lang == 'en' ? url('/create-page') : url('/no/opprett-side') }}"><button class="btn">@lang('admin.create_page')</button></a>
                </div>
		    </div>
			<div class="status-section">
				<table class="table table-borderless" id="example">
                    <thead>
                        <tr class="top">
                        <th>@lang('admin.page_name')</th>
                        <th>@lang('admin.status')</th>
                        <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $key => $data)
                        <tr>
                            <td>{{$data->page_name}}</td>
                            <td><small>@lang('admin.published')</small></td>
                            <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-page/'.$data->id) : url('/no/rediger-side/'.$data->id) }}">@lang('admin.details') </a></td>
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
    $(document).ready(function() {
		$('#example').DataTable();
    });
</script>
@endsection
