<div class="d-flex flex-column info-footer">
    <div class="d-flex info-footer-sec">
        <div class="foot-start d-flex flex-column">
            <img src="{{ asset('images/logo.png')}}" alt="logo"/>
            <p>Lorem Ipsum er rett og slett dummytekst fra og
            for trykkeindustrien. Lorem Ipsum har vært bransjens 
            standard for dummytekst helt siden 1500-tallet, da en 
            ukjent boktrykker stokket en mengde bokstaver for å lage 
            et prøveeksemplar av en bok.</p>
            <p>Lorem Ipsum har tålt tidens tann!</p>
        </div>
        
        <div class="info-consult d-flex flex-column">
            <label>GoToConsult</label>
            <ul>
                <li><a href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('footer.about_us')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('footer.become_consultant')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('footer.create_account')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/terms-customer') : url('/no/vilkar-kunde') }}">@lang('footer.terms_customer')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/terms-provider') : url('/no/vilkar-tilbyder') }}">@lang('footer.terms_provider')</a></li>
            </ul>
        </div>
        
        <div class="info-cate d-flex flex-column">
            <label>@lang('footer.categories')</label>
            <ul>
                @foreach ($categories as $key => $category)
                <?php $route = $category->category_url; ?>
                @if($lang == 'en')
                <li><a class="text-capitalize" href="{{url('/category/').'/'.$route}}">{{$category->category_name}}</a></li>
                @else
                <li><a class="text-capitalize" href="{{url('/no/kategori/').'/'.$route}}">{{$category->category_name_no}}</a></li>
                @endif
                @endforeach
            </ul>
        </div>
        
        <div class="info-cate d-flex flex-column">
            <label>@lang('footer.get_started')</label>
            <ul>
                <li><a href="{{ $lang == 'en' ? url('/find-consultant') : url('/no/finn-konsulent') }}">@lang('footer.find_consultant')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('footer.become_consultant')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('footer.login')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('footer.create_account')</a></li>
                <li><a href="{{ $lang == 'en' ? url('/faq') : url('/no/faq') }}">@lang('footer.faq')</a></li>
            </ul>
        </div>
        
        <div class="info-follow d-flex flex-column">
            <label>@lang('footer.follow_us')</label>
            <ul>
                <li><a href="#">@lang('footer.facebook')</a></li>
                <li><a href="#">@lang('footer.instagram')</a></li>
                <li><a href="#">@lang('footer.linkedin')</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="copyright">
            &copy; @lang('footer.copyright') 
            <ul>
                <li><a class="text-capitalize" href="{{ $lang == 'en' ? url('/privacy') : url('/no/personvern') }}">@lang('footer.privacy')</a></li>
            </ul>
        </div>
        <div class="design">
            @lang('footer.description')
        </div>
    </div>
</div>
