@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
	@include('elements.member_sidebar')
	<div class="content-wrapper member-content">
		<h2 class="pre-topic">@lang('member.wallet')</h2>
		<div class="prepaid-card-full">
			<div class="prepaid-card-left">
				<div class="pay-method">
					<h3>@lang('member.choose_card')</h3>
					<?php $count = count($credits); $percent = $agent->isMobile() ? 2 : 4; ?>
					@foreach($credits as $key=>$item)
						@if($key == 0)
						<div class="choose-group d-flex">
						@elseif ($key % $percent ==0)
						</div><div class="choose-group d-flex">
						@endif
						@if($key != $count -1)
						<div class="choose-item">
							<div class="{{$key == 0 ? 'credit active': 'credit'}}" id="{{$item['id']}}">
								@if($currency == 'USD')
								<span class="symbol">$</span>
								@elseif($currency == 'EUR')
								<span class="symbol">€</span>
								@else
								<span class="symbol">kr</span>
								@endif
								<span class="cost">{{$item['amount']}}</span>
							</div>
						</div>
						@else
						<div class="choose-item custom">
							<div class="custom">
								<span class="cost">@lang('member.other')</span>
							</div>
							<div class="credit display-none" id="card8">
								@if($currency == 'USD')
								<span class="symbol">$</span>
								@elseif($currency == 'EUR')
								<span class="symbol">€</span>
								@else
								<span class="symbol">kr</span>
								@endif
								<input type="text" value="" id="custom_card" />
							</div>
						</div>
						@endif
						@if ($key == $count -1)
						</div>
						@endif
					@endforeach
				</div>
				<div class="pay-method">
					<h3>@lang('member.payment_method')</h3>
					<div class="payment-option">
						<div class="flex-row">
							<label class="container">
								<input type="radio" name="card_type" value="credit" checked/>
								<span class="checkmark"></span>
								<span class="text">@lang('member.debit_credit')</span>
								<div class="selected-card-type">
									<img src="{{asset('images/visa.svg')}}" alt="no-image"/>
									<img src="{{asset('images/mastercard.svg')}}" alt="no-image"/>
								</div>
							</label>
						</div>
						<div class="pay-cust-credit display-none">
							<div id="credit-form">
								<div class="bt-drop-in-wrapper">
									<div id="dropin-container">
									</div>
								</div>
								<div class="extra-form">
									<div class="check-form mt-3">
										<input type="checkbox" id="save-card" />
										<label for="save-card">@lang('member.save_payment')</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="payment-option-border"></div>
					<div class="payment-option">
						<div class="flex-row">
							<label class="container">
								<input type="radio" name="card_type" value="klarna" />
								<span class="checkmark"></span>
								<span class="text">Klarna</span>
								<div class="selected-card-type">
									<img src="{{asset('images/klarna-card.svg')}}" alt="no-image"/>
								</div>
							</label>
						</div>
						<div class="pay-cust-klarna display-none">
							<div class="klarna-checkout"></div>
						</div>
					</div>
				</div>
				<p>All currency conversion is an estimate and may vary. Your final payment will be made in NOK.<br/>
				All sales are final, purchases may be refunded for GotoConsult Credits only.</p>
				<div class="pay-method table">
					<div class="filter">
						<h3>@lang('member.payment_transactions')</h3>
						<div class="filter-box desktop">
							<img src="{{asset('images/filter.svg')}}" alt="no-image"/>
						</div>
					</div>
					<div class="filter-tag desktop">
						<div class="form-group">
							<label for="start_date">@lang('member.start_date')</label>
							<input type="text" class="form-control date-picker" id="start_date" name="start_date" readonly>
						</div>
						<div class="form-group">
							<label for="end_date">@lang('member.end_date')</label>
							<input type="text" class="form-control date-picker" id="end_date" name="end_date" readonly>
						</div>
						<div class="form-group">
							<label for="transaction_type">@lang('member.transaction_type')</label>
							<select id="transaction_type" name="transaction_type" class="form-control">
									<option value="Credit">Credit</option>
									<option value="Klarna">Klarna</option>
							</select>
						</div>
						<button id="go-search">@lang('member.filter')</button>
					</div>
					<div class="status-section">
						<table id="transaction-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Transaction ID</th>
									<th>Amount(NOK)</th>
									<th>Date</th>
									<th>Time</th>
									<th>Payment Type</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($transactions as $transaction)
								<?php $date = explode(" ", $transaction->created_at)[0]; $time = explode(" ", $transaction->created_at)[1]; ?>
								<tr>
									<td>{{$transaction->transaction_id}}</td>
									<td>{{$transaction->amount}}</td>
									<td>{{$date}}</td>
									<td>{{$time}}</td>
									<td>{{$transaction->type}}</td>
									<td>{{$transaction->status}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal fade" id="payment-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<div class="step">
								<img src="{{asset('images/check-green.png')}}" alt="no-image"/>
								<h2>Thank you <br> for your purchase!</h2>
								<p id="pay-modal-amount"></p>
								@if(auth()->user()->role =="consultant")
								<a class="btn btn-redirect" href="{{ $lang == 'en' ? url('/find-customer') : url('/no/finn-kunde') }}">@lang('member.get_started')</a>
								@else
								<a class="btn btn-redirect" href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('member.get_started')</a>
								@endif
								<a class="btn btn-close" data-dismiss="modal" aria-label="Close">@lang('member.close')</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mobile-step2">
				<div class="d-flex justify-content-center pb-3">
					<img src="images/earnings-icon.svg">
				</div>
				<div class="d-flex align-items-center flex-column">
					<h3>@lang('member.my_balance')</h3>
					<div class="underline-bar"></div>
					<span class="updated_balance">{{$balance}} NOK</span>
				</div>
				<button class="btn add-credit-btn">@lang('member.add-credits')</button>
			</div>
			<div class="prepaid-card-right">
				<div class="sticky">
					<div class="current-bal">
						<div class="icon-box pr-2">
							<img src="{{asset('images/money.svg')}}" alt="no-image"/>
						</div>
						<div class="balance-status">
							<h3>@lang('member.my_balance')</h3>
							<div class="underline-bar"></div>
							<span>{{$balance}} NOK</span>
						</div>
					</div>
					<div class="current-bal credit-box display-none">
						<div class="credit-section">
							<h3>@lang('member.gotoconsult-credit')</h3>
							<div class="underline-bar"></div>
							<span class="selected-credit"></span>
						</div>
						<div class="credit-section-border"></div>
						<div class="credit-section">
							<div class="credit-sub-section">
								<p>@lang('member.subtotal')</p>
								<p class="selected-credit"></p>
							</div>
							<div class="credit-sub-section">
								<p>@lang('member.processing-fee')</p>
								@if($currency == 'USD')
								<p>$0.00 {{$currency}}</p>
								@elseif($currency == 'EUR')
								<p>€0.00 {{$currency}}</p>
								@else
								<p>kr0.00 {{$currency}}</p>
								@endif
							</div>
						</div>
						<div class="credit-section-border"></div>
						<div class="credit-section">
							<div class="credit-sub-section">
								<p>@lang('member.total')</p>
								<p class="selected-credit"></p>
							</div>
							<button class="btn ac-btn pay-btn sumbit-total"></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobile-wallet-payment">
		<div class="d-flex justify-content-between">
			<p>@lang('member.subtotal')</p>
			<p class="selected-credit"></p>
		</div>
		<div class="d-flex justify-content-between">
			<p class="processing-question">@lang('member.processing-fee')<img src="images/question.svg"></p>
			@if($currency == 'USD')
			<p>$0.00 {{$currency}}</p>
			@elseif($currency == 'EUR')
			<p>€0.00 {{$currency}}</p>
			@else
			<p>kr0.00 {{$currency}}</p>
			@endif
		</div>
		<div class="d-flex justify-content-between">
			<p>@lang('member.total')</p>
			<p class="selected-credit"></p>
		</div>
		<button class="btn next-btn"></button>
	</div>
	<div class="mobile-wallet-transaction">
		<div class="filter">
			<h3>@lang('member.payment_transactions')</h3>
			<div class="filter-box mobile">
				<img src="{{asset('images/filter.svg')}}" alt="no-image"/>
			</div>
		</div>
		<div class="filter-tag mobile">
			<div class="form-group">
				<label for="mobile_start_date">@lang('member.start_date')</label>
				<input type="text" class="form-control date-picker" id="mobile_start_date" name="mobile_start_date" readonly>
			</div>
			<div class="form-group">
				<label for="mobile_end_date">@lang('member.end_date')</label>
				<input type="text" class="form-control date-picker" id="mobile_end_date" name="mobile_end_date" readonly>
			</div>
			<div class="form-group">
				<label for="mobile_transaction_type">@lang('member.transaction_type')</label>
				<select id="mobile_transaction_type" name="mobile_transaction_type" class="form-control">
					<option disabled selected>All</option>
					<option value="credit">Credit</option>
					<option value="klarna">Klarna</option>
				</select>
			</div>
			<button id="mobile-go-search">@lang('member.filter')</button>
		</div>
		<div class="mobile-transaction-table">
			@foreach($transactions as $transaction)
			<?php $date = explode(" ", $transaction->created_at)[0]; $time = explode(" ", $transaction->created_at)[1]; ?>
			<div class="table-item">
				<div class="pay-des">
					@if($transaction->type == 'Klarna')
					<div class="pay-img">
						<img src="{{asset('images/klarna-transaction.png')}}">
					</div>
					<div class="card-info">
						<p class="title">@lang('member.klarna')</p>
						<p>{{$time}}, {{$date}}</p>
					</div>
					@else
					<div class="pay-img">
						<img src="images/visa-transaction.png">
					</div>
					<div class="card-info">
						<p class="title">@lang('member.visa')</p>
						<p>{{$time}}, {{$date}}</p>
					</div>
					@endif
				</div>
				<div class="pay-result">
					<p class="amount">{{$transaction->amount}} kr</p>
					<p class="status">{{$transaction->status}}</p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	var amount = @json($amount);
	var is_popup = @json($is_popup);
	var currency = @json($currency);
	var search = @json($search);
	var user = @json($auth_user);
	jQuery(function(){
		new gotoconsult.Controllers.public(user);
		new gotoconsult.Controllers.wallet(amount, is_popup, currency, search);
	});
</script>
@endsection