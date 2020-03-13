<?php $lang = app()->getLocale();?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="{{$active =='0'?'active':''}}">
                @if(Auth::user()->role=='customer')
                <a href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">
                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                    <span>@lang('member.my_consultants')</span>
                </a>
                @elseif(Auth::user()->role=='consultant')
                <a href="{{ $lang == 'en' ? url('/find-customer') : url('/no/finn-kunde') }}">
                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                    <span>@lang('member.my_customers')</span></a>
                @endif
            </li>
            <li class="{{$active =='1'?'active':''}}">
                <a href="{{ $lang == 'en' ? url('/prepaid-card') : url('/no/kontantkort') }}">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    <span>@lang('member.prepaid_card')</span>
                </a>
            </li>
            <li class="{{$active =='2'?'active':''}}">
                <a href="{{ $lang == 'en' ? url('/invoice') : url('/no/fakturaer') }}">
                    <i class="fa fa-stack-exchange" aria-hidden="true"></i>
                    <span>@lang('member.invoices')</span>
                </a>
            </li>
            <li class="{{$active =='3'?'active':''}}">
                <a href="{{ $lang == 'en' ? url('/member-settings') : url('/no/kontoinnstillinger') }}">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    <span>@lang('member.settings')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
