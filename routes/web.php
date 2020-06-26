<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('web')->group(function () {
    Route::middleware('checkLocale')->group(function () {
        Route::get('/', function () {
            $lang = app()->getLocale();
            if ($lang == 'en') {
                return redirect('/');
            } else {
                return redirect('/no');
            }
        });
        Route::get('/', 'Client\PagesController@index');
        Route::get('/features', 'Client\PagesController@features');
        Route::get('/become-consultant', 'Client\PagesController@become_consultant');
        Route::get('/about', 'Client\PagesController@about_us');
        Route::get('/privacy', 'Client\PagesController@privacy');
        Route::get('/terms-customer', 'Client\PagesController@terms_customer');
        Route::get('/terms-consultant', 'Client\PagesController@terms_provider');
        Route::get('/category/{type}', 'Client\PagesController@category_info');
        Route::get('/category-search', 'Client\PagesController@categorySearch');
        
        Route::get('/no', 'Client\PagesController@index');
        Route::get('/no/funksjoner', 'Client\PagesController@noFeatures');
        Route::get('/no/bli-konsulent', 'Client\PagesController@become_consultant');
        Route::get('/no/om-oss', 'Client\PagesController@about_us');
        Route::get('/no/personvern', 'Client\PagesController@privacy');
        Route::get('/no/vilkar-kunde', 'Client\PagesController@terms_customer');
        Route::get('/no/vilkar-konsulent', 'Client\PagesController@terms_provider');
        Route::get('/no/kategori/{type}', 'Client\PagesController@category_info');
        Route::get('/no/kategori-sok', 'Client\PagesController@nocategorySearch');

        Route::post("/site-lang", 'Client\PagesController@updateLang');
        //authentication routers
        Route::get('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
        Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

        Route::get('/no/registrer', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
        Route::get('/no/logg-inn', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

        Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
        Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        //admin routers
        Route::get('/admin-dashboard', 'Server\PagesController@adminDashboard');
        Route::get('/dashboard-search', 'Server\PagesController@adminDashboardSearch');
        Route::get('/pages', 'Server\PagesController@pages');
        Route::get('/create-page', 'Server\PagesController@createPage');
        Route::get('/edit-page/{id}', 'Server\PagesController@editPage');
        Route::get('/customers', 'Server\PagesController@customers');
        Route::get('/create-customer', 'Server\PagesController@createCustomer');
        Route::get('/edit-customer/{id}', 'Server\PagesController@editCustomer');
        Route::get('/consultants', 'Server\PagesController@consultants');
        Route::get('/create-consultant', 'Server\PagesController@createConsultant');
        Route::get('/edit-consultant/{id}', 'Server\PagesController@editConsultant');
        Route::get('/categories', 'Server\PagesController@categories');
        Route::get('/create-category', 'Server\PagesController@createCategory');
        Route::get('/edit-category/{id}', 'Server\PagesController@editCategory');
        Route::get('/settings', 'Server\PagesController@settting');

        Route::get('/no/admin-dashbord', 'Server\PagesController@noAdminDashboard');
        Route::get('/no/dashboard-sok', 'Server\PagesController@noAdminDashboardSearch');
        Route::get('/no/sider', 'Server\PagesController@pages');
        Route::get('/no/opprett-side', 'Server\PagesController@createPage');
        Route::get('/no/rediger-side/{id}', 'Server\PagesController@editPage');
        Route::get('/no/kunder', 'Server\PagesController@customers');
        Route::get('/no/opprett-kunde', 'Server\PagesController@createCustomer');
        Route::get('/no/rediger-kunde/{id}', 'Server\PagesController@editCustomer');
        Route::get('/no/konsulenter', 'Server\PagesController@consultants');
        Route::get('/no/opprett-konsulent', 'Server\PagesController@createConsultant');
        Route::get('/no/rediger-konsulent/{id}', 'Server\PagesController@editConsultant');
        Route::get('/no/kategorier', 'Server\PagesController@categories');
        Route::get('/no/opprett-kategori', 'Server\PagesController@createCategory');
        Route::get('/no/rediger-kategori/{id}', 'Server\PagesController@editCategory');
        Route::get('/no/innstillinger', 'Server\PagesController@settting');
        
        //member routers
        Route::get('/find-consultant', 'Client\PagesController@findConsultant');
        Route::get('/find-consultant-search', 'Client\PagesController@findConsultantSearch');
        Route::get('/dashboard', 'Client\PagesController@dashboard');
        Route::get('/sessions', 'Client\PagesController@session');
        Route::get('/wallet', 'Client\PagesController@wallet');
        Route::get('/wallet-search', 'Client\PagesController@walletSearch');
        Route::get('/transactions ', 'Client\PagesController@transactions');
        Route::get('/transaction-search ', 'Client\PagesController@transactionSearch');
        Route::get('/profile', 'Client\PagesController@profile');
        Route::get('/profile/{id}', 'Client\PagesController@singleProfile');
        Route::get('/member-settings', 'Client\PagesController@settings');

        Route::get('/no/finn-konsulent', 'Client\PagesController@noFindConsultant');
        Route::get('/no/finn-konsulent-sok', 'Client\PagesController@noFindConsultantSearch');
        Route::get('/no/oversikt', 'Client\PagesController@noDashboard');
        Route::get('/no/moter', 'Client\PagesController@noSession');
        Route::get('/no/lommebok', 'Client\PagesController@noWallet');
        Route::get('/no/lommebok-sok', 'Client\PagesController@noWalletSearch');
        Route::get('/no/transaksjoner ', 'Client\PagesController@noTransactions');
        Route::get('/no/transaksjoner-sok ', 'Client\PagesController@noTransactionSearch');
        Route::get('/no/profil', 'Client\PagesController@noProfile');
        Route::get('/no/profil/{id}', 'Client\PagesController@noSingleProfile');
        Route::get('/no/kontoinnstillinger', 'Client\PagesController@noSettings');

        Route::post('/klarna_checkout', 'Client\PagesController@klarna_checkout');
        Route::get('/klarna_confirmation', 'Client\PagesController@klarna_confirmation');
        //API routes
        Route::post('/update_setting', 'Api\ApiController@updateSetting');
        Route::post('/update_category', 'Api\ApiController@updateCategory');

        Route::post('/update_page', 'Api\ApiController@updatePage');
        Route::post('/create_page', 'Api\ApiController@createPage');

        Route::post('/admin_home_help_image_upload', 'Api\ApiController@homeHelpImageUpload');
        Route::post('/admin_home_benefit_image_upload', 'Api\ApiController@homeBenefitImageUpload');
        Route::post('/admin_home_review_image_upload', 'Api\ApiController@homeReviewImageUpload');
        Route::post('/admin_become_consultant_platform_image_upload', 'Api\ApiController@becomeConsultantPlatformImageUpload');

        Route::post('/create_consultant', 'Api\ApiController@createConsultant');
        Route::post('/update_consultant', 'Api\ApiController@updateConsultant');
        Route::post('/create_customer', 'Api\ApiController@createCustomer');
        Route::post('/update_customer', 'Api\ApiController@updateCustomer');

        Route::post('/api/klarna_checkout', 'Api\Klarna@createCheckout');
        Route::get('/api/klarna/push/{checkout_uri}', 'Api\Klarna@push');
        
        Route::post('/api/brain_token', 'Api\BraintreeController@create_token');
        Route::post('/api/credit_checkout', 'Api\BraintreeController@createCheckout');
        Route::post('/api/balance_manage', 'Api\BraintreeController@balance_manage');

        Route::post('/support/call','Api\VoiceController@voiceHook');
    });
});