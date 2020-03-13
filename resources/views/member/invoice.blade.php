@extends('layout.member')
@section('title', $title)
@section('description', $description)
@section('content')

<div class="wrapper member-sidebar">
    @include('elements.member_sidebar')
    <div class="content-wrapper adminprof">
        <div class="content_holesecion invoices">
            <div class="page-list d-flex flex-column">
                <div class="pages-heading d-flex">
                    <h2>@lang('member.invoices')</h2>
                </div>
                <div class="pages-top-sec d-flex">
                    <form class="form">
                        <input type="text" name="search" placeholder="Search invoice number"/>
                    </form>
                    <div class="sort-section d-flex">
                        <label>@lang('member.consultant'):</label>
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-user" data-toggle="dropdown">Arman Elaoui</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">1</a>
                                <a class="dropdown-item" href="#">2</a>
                                <a class="dropdown-item" href="#">3</a>
                            </div>
                        </div>
                        <label>@lang('member.status'):</label>
                        <div class="dropdown ">
                            <button type="button" class="btn btn-primary dropdown-toggle btn-user" data-toggle="dropdown">All</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">1</a>
                                <a class="dropdown-item" href="#">2</a>
                                <a class="dropdown-item" href="#">3</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="status-section">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="top">
                                <th style="width:11%">@lang('member.number')</th>
                                <th style="width:43%">@lang('member.consultant')</th>
                                <th style="width:23%">@lang('member.price')</th>
                                <th style="width:14%">@lang('member.date')</th>
                                <th style="width:9%">@lang('member.status')</th>
                            </tr>				  												             																							 	       		     		     
                        </thead>
                        <tbody>
                            <tr>
                                <td>T001</td>
                                <td>Arman Elaoui</td>
                                <td>119,70 kr</td>
                                <td>28.01.19</td>
                                <td><small>Paid</small></td>
                            </tr>
                            <tr>
                                <td>T002</td>
                                <td>Arman Elaoui</td>
                                <td>439,70 kr</td>
                                <td>28.01.19</td>
                                <td><small class="skite">Open</small></td>
                            </tr>
                            <tr>
                                <td>T003</td>
                                <td>Arman Elaoui</td>
                                <td>322,85 kr</td>
                                <td>28.01.19</td>
                                <td><small>Paid</small></td>
                            </tr>
                            <tr>
                                <td>T004</td>
                                <td>Arman Elaoui</td>
                                <td>119,70 kr</td>
                                <td >28.01.19</td>
                                <td class=""><small class="strike">Overdue</small><i class="fas fa-edit"></i></td>
                            </tr>
                            <tr>
                                <td>T005</td>
                                <td>Arman Elaoui</td>
                                <td>1219,21 kr</td>
                                <td>28.01.19</td>
                                <td><small>Paid</small></td>
                            </tr>
                            <tr>
                                <td>T006</td>
                                <td>Arman Elaoui</td>
                                <td>3319,50 kr</td>
                                <td>28.01.19</td>
                                <td><small>Paid</small></td>
                            </tr>
                            <tr>
                                <td>T007</td>
                                <td>Arman Elaoui</td>
                                <td>549,30 kr</td>
                                <td>28.01.19</td>
                                <td><small class="skite">Open</small></td>
                            </tr>
                            <tr>
                                <td>T008</td>
                                <td>Arman Elaoui</td>
                                <td>729,76 kr</td>
                                <td>28.01.19</td>
                                <td><small class="skite">Open</small></td>
                            </tr>
                            <tr>
                                <td>T009</td>
                                <td>Arman Elaoui</td>
                                <td>432,00 kr</td>
                                <td>28.01.19</td>
                                <td><small class="skite">Open</small></td>
                            </tr>
                            <tr>
                                <td>T010</td>
                                <td>Arman Elaoui</td>
                                <td>119,70 kr</td>
                                <td>28.01.19</td>
                                <td><small>Paid</small></td>
                            </tr>
                            <tr>
                                <td>T011</td>
                                <td>Arman Elaoui</td>
                                <td>7432,00 kr</td>
                                <td>28.01.19</td>
                                <td><small class="strike">Overdue</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
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
    });
</script>
@endsection