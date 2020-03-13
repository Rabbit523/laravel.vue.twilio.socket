<?php $lang = app()->getLocale();?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li id="customer_menu" class="{{ $active == '0' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/customers') : url('/no/kunder') }}">
                    <i class="fa fa-users"></i>
                    <span>@lang('admin_sidebar.customers')</span>
                </a>
            </li>
            <li class="{{ $active == '1' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/consultants') : url('/no/konsulenter') }}">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    <span>@lang('admin_sidebar.consultants')</span>
                </a>
            </li>
            <li class="{{ $active == '2' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/categories') : url('/no/kategorier') }}">
                    <i class="fa fa-server" aria-hidden="true"></i>
                    <span>@lang('admin_sidebar.categories')</span>
                </a>
            </li>
            <li class="{{ $active == '3' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/pages') : url('/no/sider') }}">
                    <i class="fa fa-book" aria-hidden="true"></i>
                    <span>@lang('admin_sidebar.pages')</span>
                </a>
            </li>
            <li class="{{ $active == '4' ? 'active' : '' }}">
                <a href="{{ $lang == 'en' ? url('/settings') : url('/no/innstillinger') }}">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    <span>@lang('admin_sidebar.settings')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
