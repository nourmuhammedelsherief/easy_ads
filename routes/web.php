<?php

use Illuminate\Support\Facades\Route;

use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

// restaurant uses
use \App\Http\Controllers\RestaurantController\BranchController;
use \App\Http\Controllers\RestaurantController\AZOrderController;
use \App\Http\Controllers\RestaurantController\RestaurantController as UserRestaurant;
use \App\Http\Controllers\RestaurantController\Restaurant\LoginController as ResLogin;
use \App\Http\Controllers\RestaurantController\Restaurant\ForgotPasswordController as ResForgetPassword;
use \App\Http\Controllers\RestaurantController\Restaurant\ResetPasswordController as ResResetPassword;
use \App\Http\Controllers\RestaurantController\HomeController as ResHome;
use \App\Http\Controllers\RestaurantController\TableController;
use \App\Http\Controllers\RestaurantController\MenuCategoryController;
use \App\Http\Controllers\RestaurantController\ModifierController;
use \App\Http\Controllers\RestaurantController\OptionController;
use \App\Http\Controllers\RestaurantController\EmployeeController;
use \App\Http\Controllers\RestaurantController\ProductController;
use \App\Http\Controllers\RestaurantController\ProductOptionController;
use \App\Http\Controllers\RestaurantController\SocialController;
use \App\Http\Controllers\RestaurantController\DeliveryController;
use \App\Http\Controllers\RestaurantController\SensitivityController;
use \App\Http\Controllers\RestaurantController\OfferController;
use \App\Http\Controllers\RestaurantController\SliderController;
use \App\Http\Controllers\RestaurantController\SubCategoryController;
use \App\Http\Controllers\RestaurantController\PosterController;
use \App\Http\Controllers\RestaurantController\ResBranchesController;
use \App\Http\Controllers\RestaurantController\ProductSizeController;
use \App\Http\Controllers\RestaurantController\ProductPhotoController;
use \App\Http\Controllers\RestaurantController\RestaurantSettingController;
use \App\Http\Controllers\RestaurantController\OrderSettingDaysController;
use \App\Http\Controllers\RestaurantController\IntegrationController;
use \App\Http\Controllers\RestaurantController\RestaurantOrderSellerCodeController;
use \App\Http\Controllers\RestaurantController\OrderFoodicsDaysController;
use App\Http\Controllers\RestaurantController\PeriodController;
use App\Http\Controllers\RestaurantController\RestaurantEmployeeController;
use App\Http\Controllers\RestaurantController\RestaurantRateUsController;
use App\Http\Controllers\RestaurantController\RestaurantOrderSettingRangeController;


use App\Http\Controllers\RestaurantController\AdsController;
use App\Http\Controllers\RestaurantController\BackupController;
use App\Http\Controllers\RestaurantController\BankController as RestaurantControllerBankController;
use App\Http\Controllers\RestaurantController\RestaurantContactUsController;
use App\Http\Controllers\RestaurantController\RestaurantContactUsLinkController;
use App\Http\Controllers\RestaurantController\RestaurantOrderSellerCodeWhatsappController;
use App\Http\Controllers\RestaurantController\ServiceProviderController as RestaurantControllerServiceProviderController;
use App\Http\Controllers\RestaurantController\ServiceStoreController;
use App\Http\Controllers\RestaurantController\SmsController;
use App\Http\Controllers\RestaurantController\TermsConditionController;
use App\Http\Controllers\RestaurantController\EasyAdsSubscriptionController;
use App\Http\Controllers\RestaurantController\RestaurantAZCommissionController;
use App\Http\Controllers\RestaurantController\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;


////////////////////////////////////////////////////////////    site controllers //////////
use App\Http\Controllers\WebsiteController\HomeController as AZHome;
use App\Http\Controllers\WebsiteController\ContactUsController;
use App\Http\Controllers\WebsiteController\UserController;
use App\Http\Controllers\WebsiteController\CartController;
use App\Http\Controllers\WebsiteController\OrderController;

// admin uses
use \App\Http\Controllers\AdminController\RegisterQuestionController;
use \App\Http\Controllers\AdminController\AdminController;
use \App\Http\Controllers\AdminController\SettingController;
use \App\Http\Controllers\AdminController\BankController;
use \App\Http\Controllers\AdminController\MarketerController;
use \App\Http\Controllers\AdminController\SellerCodeController;
use \App\Http\Controllers\AdminController\Admin\LoginController;
use \App\Http\Controllers\AdminController\Admin\ForgotPasswordController;
use \App\Http\Controllers\AdminController\Admin\ResetPasswordController;
use App\Http\Controllers\AdminController\AdminDetailController;
use \App\Http\Controllers\AdminController\HomeController;
use \App\Http\Controllers\AdminController\EasyAdsRestaurantController;
use \App\Http\Controllers\AdminController\AZCommissionController;
use \App\Http\Controllers\AdminController\BankTransferController;
use \App\Http\Controllers\AdminController\ReportController;
use \App\Http\Controllers\AdminController\OccasionController;

// Employees EmployeeHome
use \App\Http\Controllers\EmployeeController\Employee\LoginController as EmployeeLogin;
use \App\Http\Controllers\EmployeeController\HomeController as EmployeeHome;
use \App\Http\Controllers\EmployeeController\UserController as UserEmployee;
use \App\Http\Controllers\EmployeeController\Order\OrderController as EmployeeOrder;
use App\Http\Controllers\EmployeeController\Order\OrderController as OrderOrderController;
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
Route::get('/payLinkSuccess' , function (){
    echo "success payLink Payment";
});
Route::get('/payLinkError' , function (){
    echo "error payLink Payment";
});


Route::get('locale/{locale}', function (Request $request, $locale) {
    session()->put('locale', $locale);
    App::setLocale($locale);
    return redirect()->back();
})->name('language');
Route::get('console/locale/{locale}', function (Request $request, $locale) {
    session()->put('lang_restaurant', $locale);
    App::setLocale($locale);
    return redirect()->back();
})->name('restaurant.language');

/**
 *  Start @user routes
 */

Route::get('/shop/{res_name}', [AZHome::class, 'index']);
Route::match(['get', 'post'], '/restaurants/branch/{branch_name?}', [AZHome::class, 'home'])->name('homeBranch');
Route::get('/shop/{res}/{branch_name}/{cat?}', [AZHome::class, 'homeBranch'])->name('homeBranchIndex');
Route::get('/shop_az/{res_name}/terms&conditions/{branch?}', [AZHome::class, 'terms'])->name('restaurantTerms');
Route::get('/shop_az/{res_name}/about_us/{branch?}', [AZHome::class, 'about'])->name('restaurantAboutAzmak');
Route::get('/shop_contact_us/{res_name}/{branch?}', [ContactUsController::class, 'index'])->name('restaurantVisitorContactUs');
Route::post('/shop_contact_us/{res_name}/send', [ContactUsController::class, 'contact_us'])->name('restaurantVisitorContactUsSend');
Route::get('/shop_az/products/{id}', [AZHome::class, 'product_details'])->name('product_details');
Route::get('/share/shop_az/products/{id}', [AZHome::class, 'share_product'])->name('product_details_share');

// user routes
Route::controller(UserController::class)->group(function () {
    Route::get('user/shop/{res}/join_us/{branch?}', 'join_us')->name('AZUserRegister');
    Route::post('user/shop/{res}/join_us/{branch?}', 'register')->name('AZUserRegisterSubmit');
    Route::get('user/login/{res?}/{branch?}', 'show_login')->name('AZUserLogin');
    Route::post('user/shop/{res}/login/{branch?}', 'login')->name('AZUserLoginSubmit');

});

Route::controller(CartController::class)->group(function () {
    Route::post('user/shop/add_to_cart', 'add_to_cart')->name('addToAZCart');
    Route::get('user_orders/azmak/orders/{order_id}', 'order_details')->name('AZOrderDetails');
    Route::get('user/orders/{order_id}/barcode', 'barcode')->name('AZOrderBarcode');
    Route::get('user/my_orders/{branch_id}/{status?}', 'my_orders')->name('AZUserOrders');
});

Route::group(['middleware' => 'auth:web'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('logout/{res?}/{branch?}', 'logout')->name('azUser.logout');
        Route::get('user/restaurants/{res}/profile/{branch?}', 'profile')->name('AZUserProfile');
        Route::post('user/restaurants/{res}/profile/{branch?}', 'edit_profile')->name('AZUserProfileUpdate');
    });
    Route::controller(CartController::class)->group(function () {
        Route::get('user/shop/cart/{branch?}', 'cart_details')->name('AZUserCart');
        Route::get('user/delete/cart/{order_id}', 'emptyCart')->name('emptyCart');
        Route::get('user/delete/cart/items/{item_id}', 'deleteCartItem')->name('deleteCartItem');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('user/cart/orders/{order_id}', 'order_info')->name('AZOrderInfo');
        Route::post('user/cart/orders/{order_id}', 'submit_order_info')->name('AZOrderInfoSubmit');
        Route::get('user/orders/{order_id}/payment', 'payment')->name('AZOrderPayment');
        Route::get('user/orders/{order_id}/status/{id1?}/{id2?}', 'check_order_fatoourah_status')->name('AZOrderPaymentFatoourahStatus');
        Route::get('user/orders/{order_id}/tap_status', 'check_order_tap_status')->name('AZOrderPaymentTapStatus');
        Route::get('user/orders/{order_id}/edfa_status', 'edfa_status')->name('AZOrderPaymentEdfa_status');
        Route::get('user/orders/{order_id}/paylink_status', 'check_order_payLink_status')->name('check_order_payLink_status');
    });
});

/**
 *  End @user routes
 */


/**
 * Start @restaurant Routes
 */

Route::match(['get', 'post'], 'restaurants-registration/{code}', [ResHome::class, 'sellerRegisters'])->name('restaurant.seller.register');
Route::match(['post'], 'restaurants-registration/{code}/verification-code/{id}', [ResHome::class, 'sellerVerificationPhone'])->name('restaurant.seller.register.verification');
Route::match(['get', 'post'], 'restaurants-registration/{code}/payment/{id}', [ResHome::class, 'sellerRestaurantPayment'])->name('restaurant.seller.register.payment');

Route::get('/restaurants-registration/{id1?}/{id2?}', [ResHome::class, 'sellerCodeRestaurantMyFatoora'])->name('restaurant.seller.register.myfatoora');

Route::prefix('console')->group(function () {

    Route::get('check-email-or-phone', [ResHome::class, 'checkEmailAndPhone'])->name('restaurant.check');
    Route::get('register/step1', [ResHome::class, 'show_register'])->name('restaurant.step1Register');
    Route::get('register-gold/step1', [ResHome::class, 'show_register'])->name('restaurant.step1Registergold');
    Route::post('store/step1', [ResHome::class, 'submit_step1'])->name('restaurant.submit_step1');
    Route::match(['get', 'post'], 'resend_code/{id}', [ResHome::class, 'resend_code'])->name('restaurant.resend_code');
    Route::get('phone_verification/{id}', [ResHome::class, 'phone_verification'])->name('restaurant.phone_verification');
    Route::post('phone_verification/{id}', [ResHome::class, 'code_verification'])->name('restaurant.code_verification');
    Route::get('register/step2/{id}', [ResHome::class, 'storeStep2'])->name('restaurant.step2Register');
    Route::post('store/step2/{id}', [ResHome::class, 'submitStep2'])->name('restaurant.submitStep2');
    Route::get('password/forget', [ResHome::class, 'forget_password'])->name('restaurant.password.phone');
    Route::post('password/forget/submit', [ResHome::class, 'forget_password_submit'])->name('forget_password_submit');
    Route::get('password/verification/{res}', [ResHome::class, 'password_verification'])->name('forget_password_verification');
    Route::post('password/verification/{res}/submit', [ResHome::class, 'password_verification_post'])->name('password_verification_post');
    Route::get('password/reset/{res}', [ResHome::class, 'reset_password'])->name('password_reset_restaurant');
    Route::post('password/reset/{res}', [ResHome::class, 'reset_password_post'])->name('password_reset_restaurant_post');
    Route::get('login', [ResLogin::class, 'showLoginForm'])->name('restaurant.login');
    Route::post('login', [ResLogin::class, 'login'])->name('restaurant.login.submit');
    Route::get('password/reset', [ResForgetPassword::class, 'showLinkRequestForm'])->name('restaurant.password.request');
    Route::post('password/email', [ResForgetPassword::class, 'sendResetLinkEmail'])->name('restaurant.password.email');
    Route::get('password/reset/{token}', [ResResetPassword::class, 'showResetForm'])->name('restaurant.password.reset');
    Route::post('password/reset', [ResResetPassword::class, 'reset'])->name('restaurant.password.update');
    Route::post('logout', [ResLogin::class, 'logout'])->name('restaurant.logout');

    Route::group(['middleware' => 'auth:restaurant'], function () {
        Route::get('/home', [ResHome::class, 'index'])->name('restaurant.home');
        Route::controller(EasyAdsSubscriptionController::class)->group(function () {
            Route::get('/easy_ads_subscription/{id}',  'show_subscription')->name('EasyAdsSubscription');
            Route::get('/easy_ads_subscription/payment_menthod/{id}','show_payment_methods')->name('EasyAdsPaymentMethod');
            Route::post('/easy_ads_subscription/bank_transfer/{id}','bank_transfer')->name('EasyAdsBankTransfer');
            Route::get('/easy_ads_subscription_stauts/{id1?}/{id2?}', 'subscription_status')->name('EasyAdsSubscriptionStatusF');
            Route::get('/easy_ads_subscriptionPayLinkStatus/{res_id}', 'payLink_status')->name('EasyAdsSubscriptionPayLinkStatus');
        });
    });

    Route::group(['middleware' => ['web']], function () {
        Route::controller(UserRestaurant::class)->group(function () {
            Route::get('/profile', 'my_profile')->name('RestaurantProfile');
            Route::get('/barcode', 'barcode')->name('RestaurantBarcode');
            Route::get('/pdf-barcode', 'barcodePDF')->name('RestaurantBarcodePDF');
            Route::get('/urgent-barcode', 'urgentBarcode')->name('RestauranturgentBarcode');
            Route::post('/profileEdit/{id?}', 'my_profile_edit')->name('RestaurantUpdateProfile');
            Route::post('/RestaurantUpdateLogo', 'update_logo')->name('RestaurantUpdateLogo');
            Route::post('/updateBarcode/{id?}', 'updateBarcode')->name('RestaurantUpdateBarcode');
            Route::post('/profileChangePass/{id?}', 'change_pass_update')->name('RestaurantChangePassword');
            Route::post('/RestaurantChangeExternal/{id?}', 'RestaurantChangeExternal')->name('RestaurantChangeExternal');
            Route::get('/reset_to_main/{id}', 'Reset_to_main')->name('Reset_to_main');
            Route::post('/RestaurantChangeColors/{id}', 'RestaurantChangeColors')->name('RestaurantChangeColors');
            // restaurant colors
        });
        //branches routes
        Route::resource('/branches', BranchController::class, []);
        Route::get('/branches/delete/{id}', [BranchController::class, 'destroy']);
        Route::get('/branches/get_branch_payment/{id}', [BranchController::class, 'get_branch_payment'])->name('get_branch_payment');
        Route::post('/branches/get_branch_payment/{id}', [BranchController::class, 'store_branch_payment'])->name('store_branch_payment');
        Route::get('/branches/subscription/{id}/{country}/{subscription}', [BranchController::class, 'renewSubscriptionBankGet'])->name('renewSubscriptionBankGet');
        Route::post('/branches/subscription/{id}', [BranchController::class, 'renewSubscriptionBank'])->name('renewBranchSubscriptionBank');
        Route::get('/branches/{id}/barcode', [BranchController::class, 'barcode'])->name('branchBarcode');
        Route::get('/branches/{id}/print-menu', [BranchController::class, 'printMenu'])->name('branchPrintMenu');
        Route::get('/branches/showBranchCart/{branch_id}/{state}', [BranchController::class, 'showBranchCart'])->name('showBranchCart');
        Route::get('/branches/stopBranchMenu/{branch_id}/{state}', [BranchController::class, 'stopBranchMenu'])->name('stopBranchMenu');

        Route::get('/copy_menu/branch', [BranchController::class, 'copy_menu'])->name('copyBranchMenu');
        Route::post('/copy_menu/branch', [BranchController::class, 'copy_menu_post'])->name('copyBranchMenuPost');
        Route::get('/print_invoice/{id}', [BranchController::class, 'print_invoice'])->name('print_invoice');

        Route::group(['middleware' => 'auth:restaurant'], function () {
            // MenuCategory Routes
            Route::resource('/menu_categories', MenuCategoryController::class, []);
            Route::get('/branch/menu_categories/{id}', [MenuCategoryController::class, 'branch_categories'])->name('BranchMenuCategory');

            Route::get('/menu_categories/delete/{id}', [MenuCategoryController::class, 'destroy']);
            Route::get('/menu_categories/deleteCategoryPhoto/{id}', [MenuCategoryController::class, 'deleteCategoryPhoto'])->name('deleteCategoryPhoto');

            Route::get('/menu_categories/active/{id}/{active}', [MenuCategoryController::class, 'activate'])->name('activeMenuCategory');
            Route::get('/menu_categories/arrange/{id}', [MenuCategoryController::class, 'arrange'])->name('arrangeMenuCategory');
            Route::post('/menu_categories/arrange/{id}', [MenuCategoryController::class, 'arrange_submit'])->name('arrangeSubmitMenuCategory');
            Route::get('/menu_categories/copy/{id}', [MenuCategoryController::class, 'copy_category'])->name('copyMenuCategory');
            Route::post('/menu_categories/copy', [MenuCategoryController::class, 'copy_category_post'])->name('copyMenuCategoryPost');
            // Modifiers Routes
            Route::resource('/modifiers', ModifierController::class, []);
            Route::get('/modifiers/delete/{id}', [ModifierController::class, 'destroy']);
            Route::get('/modifiers/active/{id}/{is_ready}', [ModifierController::class, 'active'])->name('activeModifier');
            // Options Routes
            Route::resource('/additions', OptionController::class, []);
            Route::get('/additions/delete/{id}', [OptionController::class, 'destroy']);
            Route::get('/additions/active/{id}/{is_active}', [OptionController::class, 'active'])->name('activeOption');
            // socials Routes
            Route::resource('/socials', SocialController::class, []);
            Route::get('/socials/delete/{id}', [SocialController::class, 'destroy']);

            // sensitivities Routes
            Route::resource('/sensitivities', SensitivityController::class, []);
            Route::get('/sensitivities/delete/{id}', [SensitivityController::class, 'destroy']);

            // sliders Routes
            Route::post('/sliders/slider-title', [SliderController::class, 'storeSliderTitle'])->name('sliders.title');
            Route::resource('/sliders', SliderController::class, []);
            Route::get('/sliders/delete/{id}', [SliderController::class, 'destroy']);
            Route::post('/sliders/upload-video', [SliderController::class, 'uploadVideo'])->name('sliders.uploadVideo');
            Route::get('/sliders/stopSlider/{id}/{status}', [SliderController::class, 'stopSlider'])->name('stopSlider');


            // sub_categories Routes
            Route::controller(SubCategoryController::class)->group(function () {
                Route::get('/sub_categories/{id}', 'index')->name('sub_categories.index');
                Route::get('/sub_categories/create/{id}', 'create')->name('sub_categories.create');
                Route::post('/sub_categories/store/{id}', 'store')->name('sub_categories.store');
                Route::get('/sub_categories/edit/{id}', 'edit')->name('sub_categories.edit');
                Route::post('/sub_categories/update/{id}', 'update')->name('sub_categories.update');
                Route::get('/sub_categories/delete/{id}', 'destroy');
            });

            // employees Routes
            Route::resource('/employees', EmployeeController::class, []);
            Route::get('/employees/delete/{id}', [EmployeeController::class, 'destroy']);

            // home_icons

            Route::resource('home_icons', IconController::class, ['as' => 'restaurant']);
            Route::get('/home_icons/{icon}/active/{status}', [IconController::class, 'changeStatus'])->name('restaurant.home_icons.change_status');
            Route::get('/home_icons/{icon}/contact-active/{status}', [IconController::class, 'changeContactStatus'])->name('restaurant.home_icons.change_contact_status');
            Route::get('/home_icons/delete/{id}', [IconController::class, 'destroy']);
            // posters Routes
            Route::resource('/posters', PosterController::class, []);
            Route::get('/posters/delete/{id}', [PosterController::class, 'destroy']);


            // Offer Routes
            Route::resource('/offers', OfferController::class, []);
            Route::get('/offers/delete/{id}', [OfferController::class, 'destroy']);
            Route::get('/offers/photo/{id}/remove', [OfferController::class, 'remove_photo'])->name('imageOfferRemove');

            Route::post('/sub_menu_category/update-image', [SubCategoryController::class, 'uploadImage'])->name('restaurant.sub_menu_category.update_image');
            Route::post('/menu_category/update-image', [MenuCategoryController::class, 'uploadImage'])->name('restaurant.menu_category.update_image');
            Route::post('/profile/update-image', [UserRestaurant::class, 'uploadImage'])->name('restaurant.profile.update_image');
            Route::post('/ads/update-image', [AdsController::class, 'uploadImage'])->name('restaurant.ads.update_image');
            Route::post('/ads/upload-video', [AdsController::class, 'uploadVideo'])->name('ads.uploadVideo');
            Route::post('/offer/update-image', [OfferController::class, 'uploadImage'])->name('restaurant.offer.update_image');
            // products Routes
            Route::resource('/products', ProductController::class, []);
            Route::get('/branch/products/{id}', [ProductController::class, 'branch_products'])->name('BranchProducts');
            Route::get('/get/branch_menu_categories/{id}', [ProductController::class, 'branch_menu_categories'])->name('branch_menu_categories');
            Route::get('/get_menu_sub_categories/{id}', [ProductController::class, 'get_menu_sub_categories'])->name('get_menu_sub_categories');

            Route::post('/products/update-image', [ProductController::class, 'updateProductImage'])->name('restaurant.product.update_image');
            Route::get('/products/arrange/{id}', [ProductController::class, 'arrange'])->name('arrangeProduct');
            Route::post('/products/arrange/{id}', [ProductController::class, 'arrange_submit'])->name('arrangeSubmitProduct');
            Route::get('/products/copy/{id}', [ProductController::class, 'copy_product'])->name('copyProduct');
            Route::post('/products/copy/{id}', [ProductController::class, 'copy_product_submit'])->name('submitCopyProduct');

            Route::get('/products/delete/{id}', [ProductController::class, 'destroy']);
            Route::get('/products/deleteProductPhoto/{id}', [ProductController::class, 'deleteProductPhoto'])->name('deleteProductPhoto');
            Route::get('/products/active/{id}/{active}', [ProductController::class, 'active'])->name('activeProduct');
            Route::get('/products/available/{id}/{available}', [ProductController::class, 'available'])->name('availableProduct');
            Route::post('/products/upload-video', [ProductController::class, 'uploadVideo'])->name('products.uploadVideo');


            // products options routes
            Route::controller(ProductOptionController::class)->group(function () {
                Route::get('/product_options/{id}', 'index')->name('productOption');
                Route::get('/product_options/{id}/create', 'create')->name('createProductOption');
                Route::post('/product_options/{id}/store', 'store')->name('storeProductOption');
                Route::get('/product_options/{id}/edit', 'edit')->name('editProductOption');
                Route::post('/product_options/{id}/update', 'update')->name('updateProductOption');
                Route::get('/product_options/delete/{id}', 'destroy')->name('deleteProductOption');
                Route::delete('/product_options/{product}/delete-all', 'deleteAll')->name('deleteAllProductOption');
            });

            // products sizes routes
            Route::controller(ProductSizeController::class)->group(function () {
                Route::get('/product_sizes/{id}', 'index')->name('productSize');
                Route::get('/product_sizes/{id}/active/{status}', 'changeStatus')->name('productSize.changeStatus');
                Route::get('/product_sizes/{id}/create', 'create')->name('createProductSize');
                Route::post('/product_sizes/{id}/store', 'store')->name('storeProductSize');
                Route::get('/product_sizes/{id}/edit', 'edit')->name('editProductSize');
                Route::post('/product_sizes/{id}/update', 'update')->name('updateProductSize');
                Route::get('/product_sizes/delete/{id}', 'destroy')->name('deleteProductSize');
            });

            Route::controller(AZOrderController::class)->group(function () {
                Route::get('/azmak_orders/{status}', 'index')->name('AzmakOrders');
                Route::get('/azmak_orders/delete/{id}', 'destroy')->name('DeleteAzmakOrder');
                Route::get('/show/azmak_orders/{order_id}', 'show')->name('AzmakOrderShowR');
                Route::post('/cancel/azmak_order/{order_id}', 'cancel')->name('cancelAzmakOrderR');
                Route::post('/complete/azmak_order/{order_id}', 'complete_order')->name('completeAzmakOrderR');

            });



            Route::get('/history/{id}', [SettingController::class, 'show_restaurant_history'])->name('show_restaurant_history');

            // terms and conditions routes
            Route::get('/terms/conditions', [TermsConditionController::class, 'index'])->name('restaurant.terms_conditions.index');
            Route::post('/terms/conditions/{id}', [TermsConditionController::class, 'update'])->name('restaurant.terms_conditions.update');

            // about azmak routes
            Route::get('/azmak_about', [TermsConditionController::class, 'azmak_about'])->name('restaurant.azmak_about.index');
            Route::post('/azmak_about/{id}', [TermsConditionController::class, 'azmak_about_update'])->name('restaurant.azmak_about.update');

            // about azmak routes
            Route::get('/az_contacts', [TermsConditionController::class, 'az_contacts'])->name('restaurant.az_contacts.index');
            Route::get('/az_contacts/delete/{id}', [TermsConditionController::class, 'delete_az_contact'])->name('restaurant.delete_az_contact');

            // copy menu from easymenu to azmak menu
            Route::controller(MenuController::class)->group(function () {
                Route::get('/integrations', 'integrations')->name('integrations');
                Route::get('/copy_menu_from_easymenu_to_azmak/{id}', 'copy_menu')->name('copyMenu');
            });
        });
    });
});
/**
 * End @restaurant Routes
 */
/**
 * Start @admin Routes
 */
Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
Route::prefix('admin')->group(function () {

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => ['web', 'auth:admin']], function () {
        Route::controller(EasyAdsRestaurantController::class)->group(function () {
            Route::get('/restaurants/{restaurant}/login', 'loginToRestaurant')->name('admin.restaurant.login');
            Route::get('/restaurants/{status}', 'index')->name('restaurants');
            Route::get('/restaurant_gold/{status}', 'index_gold')->name('restaurants_gold');
            Route::get('/restaurant_family/{status}', 'index_family')->name('restaurants_family');
            Route::get('/branches/{status}', 'branches')->name('branches');
            Route::get('/branches/{id}/edit', 'edit_branch')->name('editRestaurantBranch');
            Route::post('/branches/{id}/update', 'update_branch')->name('updateRestaurantBranch');
            Route::get('/branches/delete/{id}', 'delete_branches')->name('delete_branches')->middleware('admin');
            Route::get('/create/restaurants', 'create')->name('createRestaurant');
            Route::post('/restaurants/store', 'store')->name('storeRestaurant');
            Route::get('/restaurants/{id}/show', 'show')->name('showRestaurant');
            Route::get('/restaurants/{id}/edit', 'edit')->name('editRestaurant');
            Route::post('/restaurants/{id}/update', 'update')->name('updateRestaurant');


            Route::get('/restaurants/delete/{id}', 'destroy')->name('deleteRestaurant')->middleware('admin');
            Route::get('/restaurants/subscription/{id}/control', 'control_subscription')->name('ControlRestaurantSubscription');
            Route::post('/restaurants/subscription/{id}/control', 'controlChanges')->name('controlChanges');
            Route::get('/restaurants/service/{id}/control', 'control_service_subscription')->name('ControlServiceSubscription');
            Route::post('/restaurants/service/{id}/control', 'controlServiceChanges')->name('controlServiceChanges');
            Route::post('/restaurants/controlPackage/{id}/control', 'controlPackage')->name('controlPackage');
            Route::get('/restaurants/archive/{id}/{state}', 'ArchiveRestaurant')->name('ArchiveRestaurant')->middleware('auth:admin');
            Route::get('/branches/archive/{id}/{state}', 'ArchiveBranch')->name('ArchiveBranch')->middleware('admin');
            Route::get('/restaurants/ActiveRestaurant/{id}', 'ActiveRestaurant')->name('ActiveRestaurant');
            Route::get('/branches/subscription/{id}/control', 'control_branch_subscription')->name('ControlBranchSubscription');
            Route::post('/branches/subscription/{id}/control', 'controlBranchChanges')->name('controlBranchChanges');
        });
        Route::controller(SettingController::class)->group(function () {
            Route::get('/easy_ads_setting', 'setting')->name('easyAdsSetting');
            Route::post('/easy_ads_setting', 'setting_update')->name('easyAdsSettingUpdate');
            Route::get('/histories', 'histories')->name('admin.histories');
            Route::get('/month_histories', 'report_histories')->name('admin.month_histories');
            Route::get('/histories/delete/{id}', 'delete_histories')->name('admin.delete_histories');
            //commission_histories
            Route::get('/commission_histories', 'commission_histories')->name('admin.commission_histories');
            Route::get('/commission_histories/delete/{id}', 'delete_commission_history')->name('admin.delete_commission_history');
        });
        // reports controller
        Route::controller(ReportController::class)->group(function () {
            Route::get('/reports', 'index')->name('reports.index');
            Route::get('/reports/restaurants/{year}/{month}/{type}', 'restaurants')->name('reports.restaurants');
            Route::get('/month_reports', 'month_reports')->name('admin.month_reports');
            Route::get('/month_histories', 'report_histories')->name('admin.month_histories');
            Route::get('/payable_commissions_restaurants/{year}/{month}', 'payable_commissions_restaurants')->name('commission_report.restaurants');
            Route::get('/report_orders/{year}/{month}', 'report_orders')->name('reports.orders');
            Route::get('/report_commissions/{year}/{month}', 'report_commissions')->name('reports.commissions');
        });

        Route::resource('/occasions',OccasionController::class);
        Route::get('/occasions/delete/{id}', [OccasionController::class, 'destroy'])->name('deleteOccasion');

        Route::controller(BankTransferController::class)->group(function () {
            Route::get('/easy_ads_bank_transfers', 'transfers')->name('easyAdsBankTransfer');
            Route::get('/commission_bank_transfers', 'commission_bank_transfers')->name('commission_bank_transfers');
            Route::get('/easy_ads_bank_transfer/{id}/{status}', 'transfer_status')->name('subscription.confirm_status');
        });


        // seller codes
        Route::resource('/seller_codes', SellerCodeController::class);
        Route::get('/seller_codes/delete/{id}', [SellerCodeController::class, 'destroy'])->name('deleteSellerCode');
        Route::get('/seller_codes/{id}/active/{status}', [SellerCodeController::class, 'activate'])->name('activateSellerCode');
        // restaurants
    });
});
/**
 * End @admin Routes
 */
/**
 * Start @Employees Routes
 */
Route::get('/casher/home', [EmployeeHome::class, 'index'])->name('employee.home');
Route::prefix('casher')->group(function () {

    Route::get('login', [EmployeeLogin::class, 'showLoginForm'])->name('employee.login');
    Route::post('login', [EmployeeLogin::class, 'login'])->name('employee.login.submit');
    Route::post('logout', [EmployeeLogin::class, 'logout'])->name('employee.logout');

    Route::group(['middleware' => ['web', 'auth:employee']], function () {
        Route::controller(UserEmployee::class)->group(function () {
            Route::get('/profile', 'my_profile')->name('employeeProfile');
            Route::post('/profileEdit/{id?}', 'my_profile_edit')->name('employeeUpdateProfile');
        });

        Route::controller(EmployeeOrder::class)->group(function () {
            Route::get('/azmak_orders/{status}', 'index')->name('AzmakOrders');
            Route::get('/azmak_orders/delete/{id}', 'destroy')->name('DeleteAzmakOrder');
            Route::get('/show/azmak_orders/{order_id}', 'show')->name('AzmakOrderShow');
            Route::post('/cancel/azmak_order/{order_id}', 'cancel')->name('cancelAzmakOrder');
            Route::post('/complete/azmak_order/{order_id}', 'complete_order')->name('completeAzmakOrder');

            Route::get('order/{bbid}/print', 'printOrder')->name('casher.orders.print');
            Route::get('/show_audios', 'show_audios')->name('show_audios');
            Route::post('/store_audios', 'store_audios')->name('store_audios');
        });
        Route::match( ['get' , 'post'] , 'order/report' , [OrderOrderController::class , 'report'])->name('casher.order.report');
    });
});
/**
 * End @Employees Routes
 */
