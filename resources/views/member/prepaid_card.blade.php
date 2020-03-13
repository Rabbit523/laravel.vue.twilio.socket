@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')
<?php $lang = app()->getLocale();?>
<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof">
		<div class="content_holesecion">
		    <h2 class="pre-topic">@lang('member.prepaid_card')</h2>
			<div class="prepaid-card-full d-flex">
				<div class="prepaid-card-left">
                    <div class="pay-method choose-card d-flex flex-column">
                        <p>1/3. @lang('member.choose_card')</p>
                        <div class="choose-group d-flex">
                            <div class="choose-item active" id="card1">
                                <div class="img-item">
                                    <img src="{{asset('images/choose-card.png')}}" alt="no-image"/>
                                </div>
                                <div class="text-item">
                                    <p>@lang('member.prepaid_card')</p>
                                    <p class="cost">100 kr</p>
                                </div>
                            </div>
                            <div class="choose-item" id="card2">
                                <div class="img-item">
                                    <img src="{{asset('images/choose-card.png')}}" alt="no-image"/>
                                </div>
                                <div class="text-item">
                                    <p>@lang('member.prepaid_card')</p>
                                    <p class="cost">300 kr</p>
                                </div>
                            </div>
                            <div class="choose-item" id="card3">
                                <div class="img-item">
                                    <img src="{{asset('images/choose-card.png')}}" alt="no-image"/>
                                </div>
                                <div class="text-item">
                                    <p>@lang('member.enter_amount')</p>
                                    <input type="text" value="" id="custom_card" />
                                    <label>kr</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-method d-flex flex-column">
                        <p>2/3. @lang('member.payment_method')</p>
                        <div class="method-image d-flex">
                            <img src="{{asset('images/klarna.png')}}" alt="no-image" class="active" id="method-klarna"/>
                            <img src="{{asset('images/vpps.png')}}" alt="no-image" id="method-vipps"/>
                        </div>
                    </div>
				
                    <div class="pay-cust-klarna">
                        <p>3/3. @lang('member.pay_klarna')</p>
                        <div class="klarna-checkout"></div>
                    </div>
                    
                    <div class="pay-cust-vipps">
                        <p>3/3. @lang('member.pay_vipps')</p>
                        <div class="vipps-checkout"></div>
                    </div>

                    <div class="modal fade" id="payment-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <div class="step">
                                    <img src="{{asset('images/check-green.png')}}" alt="no-image"/>
                                    <h2>Thank you <br> for your purchase!</h2>
                                    <p><b>{{$amount}}kr</b> have been added to your balance.</p>
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
                <div class="prepaid-card-right">
                    <div class="current-bal d-flex flex-column">
                        <h3>@lang('member.current_balance')</h3>
                        <span>{{$balance}} kr</span>
                        <button class="btn ac-btn">@lang('member.add_card')</button>
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
        var is_popup = "{{$is_popup}}";
        var payment_info = { "price": 100, "name": '100KRCARD' };
        var selected_cost = 100;
        var app_env = '{{ env('APP_ENV') }}';
        var vipps_access_token = "";
        var token_request_header = {
            'client_id': '{{ env('VIPPS_CLIENT_ID') }}', 
            'client_secret': '{{ env('VIPPS_CLIENT_SECRET') }}',
            'Ocp-Apim-Subscription-Key': '{{ env('VIPPS_SUBSCRIPTION_KEY') }}'
        };
        // get vipps access token
        $.ajax({
            url: app_env=='local'?'https://apitest.vipps.no/accesstoken/get':'https://api.vipps.no/accesstoken/get',
            headers: token_request_header, 
            contentType: 'application/json',
            success: function (res) {
                vipps_access_token = res.access_token;
            }
        });
        // set user status
        if (user.status != 'Offline') {
            $.ajax({
                url: '/api/manage_status',
                headers:  {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: { id: user.id, status: 'Offline' },
                dataType: 'JSON',
                success: function (res) {
                    console.log("status updated");
                }
            });
        }
        // select cost box
        if($("#card1").hasClass("active")) {
            selected_cost = 100;
        } else if($("#card2").hasClass("active")) {
            selected_cost = 300;
        } else {
            selected_cost = parseInt($("#custom_card").val());
        }
        // show purchase complete popup
        if (is_popup == 'true') {
            $("#payment-confirmation").modal('show');
        }
        // show klarna step3 as default
        if ($("#method-klarna").hasClass("active")) {
            $(".pay-cust-vipps").attr('style', 'display: none');
            $.ajax({
                url: '/api/klarna_checkout',
                headers:  {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: payment_info,
                dataType: 'JSON',
                success: function (res) {
                    $(".pay-cust-klarna").attr('style', 'display: flex');
                    $(".klarna-checkout").html(res.html_snippet);
                }
            });
        }
        // choose card
        $("#card1").click(function () {
            selected_cost = 100;
            $("#selected-cost").html("100 NOK");
            if(!$("#card1").hasClass("active")) {
                $("#card1").addClass("active");
                $("#card2").removeClass("active");
                $("#card3").removeClass("active");
            }
            if ($("#method-klarna").hasClass("active")) {
                $(".pay-cust-vipps").attr('style', 'display: none');
                $.ajax({
                    url: '/api/klarna_checkout',
                    headers:  {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { "price": 100, "name": '100KRCARD' },
                    dataType: 'JSON',
                    success: function (res) {
                        $(".pay-cust-klarna").attr('style', 'display: flex');
                        $(".klarna-checkout").html(res.html_snippet);
                    }
                });
            }
        });
        $("#card2").click(function () {
            selected_cost = 300;
            $("#selected-cost").html("300 NOK");
            if(!$("#card2").hasClass("active")) {
                $("#card1").removeClass("active");
                $("#card2").addClass("active");
                $("#card3").removeClass("active");
            }
            if ($("#method-klarna").hasClass("active")) {
                $(".pay-cust-vipps").attr('style', 'display: none');
                $.ajax({
                    url: '/api/klarna_checkout',
                    headers:  {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { "price": 300, "name": '300KRCARD' },
                    dataType: 'JSON',
                    success: function (res) {
                        $(".pay-cust-klarna").attr('style', 'display: flex');
                        $(".klarna-checkout").html(res.html_snippet);
                    }
                });
            }
        });
        $("#card3").click(function () {
            selected_cost = $("#custom_card").val();
            if(!$("#card3").hasClass("active")) {
                $("#card1").removeClass("active");
                $("#card2").removeClass("active");
                $("#card3").addClass("active");
            }
        });
        $("#custom_card").on('change', function () {
            selected_cost = parseInt($(this).val());
            $("#selected-cost").html(selected_cost + " NOK");
            if ($("#method-klarna").hasClass("active")) {
                $(".pay-cust-vipps").attr('style', 'display: none');
                $.ajax({
                    url: '/api/klarna_checkout',
                    headers:  {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: { "price": $(this).val(), "name": 'CUSTOMCARD' },
                    dataType: 'JSON',
                    success: function (res) {
                        $(".pay-cust-klarna").attr('style', 'display: flex');
                        $(".klarna-checkout").html(res.html_snippet);
                    }
                });
            }
        });
        // choose method
        $("#method-vipps").click(function () {
            if(!$("#method-vipps").hasClass("active")) {
                $("#method-klarna").removeClass("active");
                $("#method-vipps").addClass("active");
            }
            $(".pay-cust-klarna").attr('style', 'display: none');
            var card_name = '100KRCARD';
            if (selected_cost == 100) {
                card_name = '100KRCARD';
            } else if (selected_cost == 300) {
                card_name = '300KRCARD';
            } else {
                card_name = 'CUSTOMCARD';
            }

            $.ajax({
                url: '/api/vipps_checkout',
                headers:  {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: { "price": selected_cost, "name": card_name, 'token': vipps_access_token },
                dataType: 'JSON',
                success: function (res) {
                    $(".pay-cust-vipps").attr('style', 'display: flex');
                    $(".vipps-checkout").html(res.html_snippet);
                }
            });
        });
        $("#method-klarna").click(function () {
            if(!$("#method-klarna").hasClass("active")) {
                $("#method-vipps").removeClass("active");
                $("#method-klarna").addClass("active");
            }
            $(".pay-cust-vipps").attr('style', 'display: none');
            var card_name = '100KRCARD';
            if (selected_cost == 100) {
                card_name = '100KRCARD';
            } else if (selected_cost == 300) {
                card_name = '300KRCARD';
            } else {
                card_name = 'CUSTOMCARD';
            }

            $.ajax({
                url: '/api/klarna_checkout',
                headers:  {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: { "price": selected_cost, "name": card_name },
                dataType: 'JSON',
                success: function (res) {
                    $(".pay-cust-klarna").attr('style', 'display: flex');
                    $(".klarna-checkout").html(res.html_snippet);
                }
            });
        });
    });
</script>
@endsection