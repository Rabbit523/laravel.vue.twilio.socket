<div class="d-flex flex-column info-footer">
    <div class="container">
        <div class="col-12">
            <div class="d-flex justify-content-between px-3 footer">
                <div class="foot-start d-flex flex-column">
                    <a href="{{ $lang == 'en' ? url('/') : url('/no') }}" target="_blank"><img src="{{ asset('images/color-full-logo.svg')}}" alt="logo"/></a>
                    <p class="my-3">Lorem Ipsum er rett og slett dummytekst fra og
                    for trykkeindustrien. Lorem Ipsum har vært bransjens 
                    standard for dummytekst helt siden 1500-tallet, da en 
                    ukjent boktrykker stokket en mengde bokstaver for å lage 
                    et prøveeksemplar av en bok.</p>
                    <p>Lorem Ipsum har tålt tidens tann!</p>
                </div>
                <div class="d-flex flex-column footer-item">
                    <label class="mb-3">GoToConsult</label>
                    <ul>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/about') : url('/no/om-oss') }}">@lang('footer.about_us')</a></li>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/login') : url('/no/logg-inn') }}">@lang('footer.login')</a></li>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/register') : url('/no/registrer') }}">@lang('footer.create_account')</a></li>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/terms-customer') : url('/no/vilkar-kunde') }}">@lang('footer.terms_customer')</a></li>
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/privacy') : url('/no/personvern') }}">@lang('footer.privacy_policy')</a></li>
                    </ul>
                </div>
                <div class="d-flex flex-column footer-item">
                    <label class="mb-3">@lang('footer.consultants')</label>
                    <ul>
                        @foreach ($categories as $key => $category)
                        <?php $route = $category->category_url; ?>
                        @if($lang == 'en')
                        <li class="py-2"><a class="text-capitalize" href="{{url('/category/').'/'.$route}}">{{$category->category_name}}</a></li>
                        @else
                        <li class="py-2"><a class="text-capitalize" href="{{url('/no/kategori/').'/'.$route}}">{{$category->category_name_no}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex flex-column footer-item">
                    <label class="mb-3">@lang('footer.become_consultant')</label>
                    <ul>
                        @if(!auth()->user())
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/become-consultant') : url('/no/bli-konsulent') }}">@lang('footer.become_consultant')</a></li>
                        @endif
                        <li class="py-2"><a href="{{ $lang == 'en' ? url('/terms-consultant') : url('/no/vilkar-konsulent') }}">@lang('footer.terms_consultant')</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    <?php $year = date("Y"); ?>
                    ©{{$year}}&nbsp;@lang('footer.description') 
                </div>
                <div class="d-flex">
                    <img src="{{ asset('images/facebook.svg')}}">
                    <img src="{{ asset('images/instagram.svg')}}">
                </div>
            </div>
        </div>
    </div>
</div>
