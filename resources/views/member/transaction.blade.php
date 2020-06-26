@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="wrapper member-sidebar">
  @include('elements.member_sidebar')
  <div class="content-wrapper member-content">
    <div class="content_holesecion invoices">
      <div class="page-list">
        <div class="pages-heading">
          <h2>@lang('member.my-transaction')</h2>
        </div>
        <div class="filter-tag transaction">
          <div class="form-group">
            <input type="text" class="search" name="search" placeholder="Search invoice number"/>
          </div>
          <div class="group-forms">
            <div class="form-group">
              <label for="consultant">@lang('member.consultant')</label>
              <select id="consultant" name="consultant" class="form-control">
                <option disabled selected>All</option>
                @foreach($consultants as $consultant)
                <option value="{{$consultant->id}}">{{$consultant->user->first_name}} {{$consultant->user->last_name}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="date">@lang('member.date')</label>
              <input type="text" class="form-control date-picker" id="date" name="date" readonly>
            </div>
            <button id="filter">@lang('member.filter')</button>
          </div>
        </div>
        <div class="status-section transaction desktop">
          <table class="table table-borderless" id="transactions">
            <thead class="table-header">
              <th>@lang('member.consultant')</th>
              <th>@lang('member.number')</th>
              <th>@lang('member.price')</th>
              <th>@lang('member.date-time')</th>
              <th>@lang('member.time-spent')</th>
            </thead>
            <tbody>
              @foreach ($transactions as $transaction)
              <tr>
                <td class="table-item avatar">
                  <img src="{{$transaction->consultant->profile->avatar}}" alt="">
                  {{$transaction->consultant->user->first_name}} {{$transaction->consultant->user->last_name}}
                </td>
                <td class="table-item">{{$transaction->transaction_id}}</td>
                <td class="table-item">{{$transaction->amount}} kr</td>
                <td class="table-item">{{$transaction->created_at}}</td>
                <td class="table-item">{{$transaction->time_spent}} @lang('member.minute')</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="status-section transaction mobile">
          @foreach($transactions as $transaction)
          <?php $date = explode(" ", $transaction->created_at)[0]; $time = explode(" ", $transaction->created_at)[1]; $min = (int)($transaction->time_spent / 60); $sec = ($transaction->time_spent) % 60;?>
          <div class="transaction-item">
            <div class="avatar-sec">
              @if($transaction->consultant->profile && $transaction->consultant->profile->avatar)
              <img src="{{$transaction->consultant->profile->avatar}}" alt="">
              @else
              <img src="{{asset('images/profile-icon.svg')}}" alt="">
              @endif
            </div>
            <div class="profile-detail">
              <p class="name">{{$transaction->consultant->user->first_name}} {{$transaction->consultant->user->last_name[0]}}.</p>
              <p>{{$time}}, {{$date}}</p>
            </div>
            <div class="transaction-detail">
              <p class="amount">{{$transaction->amount}} kr</p>
              <p>{{$min}}m {{$sec}}s</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
	jQuery(function(){
    var search = @json($search);
    var user = @json($auth_user);
    new gotoconsult.Controllers.public(user);
		new gotoconsult.Controllers.transaction(search);
	});
</script>
@endsection
