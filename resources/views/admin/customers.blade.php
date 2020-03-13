@extends('layout.private')
@section('title', 'GoToConsult - Customers')
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper">
    @include('elements.admin_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion">
		    <div class="page-list d-flex flex-column">
                <div class="pages-heading category-heading d-flex">
                    <h2 class="mr-auto mt-auto mb-auto">@lang('admin.customers')</h2>
                    <a href="{{ $lang == 'en' ? url('/create-customer') : url('/no/opprett-kunde') }}"><button class="btn">@lang('admin.create_customer')</button></a>
                </div>
		    </div>
			<div class="status-section consult-table cust-table table-responsive">
				<table class="table table-borderless" id="example">
                    <thead>
                        <tr class="top">
                        <th>@lang('admin.number')</th>
                        <th>@lang('admin.customer')</th>
                        <th>@lang('admin.reg_date')</th>
                        <th>@lang('admin.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $data)
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
                            <td>{{$data->created_at->format('d.m.Y')}}</td>
                            <td><a style="display:block;line-height:22px;" href="{{ $lang == 'en' ? url('/edit-customer/'.$data->unique_id) : url('/no/rediger-kunde/'.$data->unique_id) }}" class="">@lang('admin.details') </a></td>
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
