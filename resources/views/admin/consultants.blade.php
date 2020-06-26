@extends('layout.private')
@section('title', 'GoToConsult - Consultants')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion">
		    <div class="page-list">
                <div class="pages-heading category-heading">
                    <h2 class="mr-auto mt-auto mb-auto">@lang('admin.consultants')</h2>
                    <a href="{{ $lang == 'en' ? url('/create-consultant') : url('/no/opprett-konsulent') }}"><button class="btn">@lang('admin.create_consultant')</button></a>
                </div>
		    </div>
			<div class="status-section consult-table cust-table table-responsive">
				<table class="table table-borderless" id="example">
                    <thead>
                        <tr class="top">
                            <th>@lang('admin.number')</th>
                            <th>@lang('admin.consultant')</th>
                            <th>@lang('admin.industry')</th>
                            <th>@lang('admin.reg_date')</th>
                            <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultants as $key => $data)
                        <tr>
                            <td>{{$data->unique_id}}</td>
                            <td>
                                @if($data->prof_image != '')
                                    <img src="{{asset($data->prof_image)}}"/>
                                @else
                                <b>{{$data->user->first_name[0]}}{{$data->user->last_name[0]}}</b>
                                @endif
                                {{$data->user->first_name}} {{$data->user->last_name}}
                            </td>
                            <td>{{$data->industry_expertise}}</td>
                            <td>{{$data->created_at->format('d.m.Y')}}</td>
                            <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-consultant/'.$data->user_id) : url('/no/rediger-konsulent/'.$data->user_id) }}" class="">@lang('admin.details') </a></td>
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
		new gotoconsult.Controllers.consultants();
	});
</script>
@endsection
