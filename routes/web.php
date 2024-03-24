<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\StoreController;
use App\Http\Controllers\Frontend\GameController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\TicketController;
use App\Http\Controllers\Backend\VolumeController;
use App\Http\Controllers\Frontend\PayeerController;
use App\Http\Controllers\Frontend\PayPalController;
use App\Http\Controllers\Frontend\StripeController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\GiveAwayController;
use App\Http\Controllers\Backend\TemplateController;
use App\Http\Controllers\Backend\WithDrawController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\CoinbaseController;
use App\Http\Controllers\Frontend\ReferralController;
use App\Http\Controllers\Backend\LicenceKeyController;
use App\Http\Controllers\Backend\UserTicketController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\GamingAccountController;
use App\Http\Controllers\Frontend\PerfectMoneyController;
use App\Http\Controllers\Backend\CustomRefferalController;
use App\Http\Controllers\Backend\FeatureProductController;
use App\Http\Controllers\Backend\SubSubcategoryController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\LicenceKeyController as FrontendLicenceKeyController;
use App\Http\Controllers\Backend\ReviewController;
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
// FRONTEND ROUTES
// MAIN PAGES

Route::middleware(['ProxyUser'])->group(function () {
});



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sortby/{slug}', [HomeController::class, 'sort'])->name('sorthome');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/giveaway', [HomeController::class, 'giveAway'])->name('giveaway');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/policy', [HomeController::class, 'policy'])->name('policy');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/store-title-in-session/{title}', [HomeController::class, 'storeTitleInSession'])->name('store.title.in.session');
Route::post('/contact/store', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('/payment-and-delivery', [HomeController::class, 'paymentDelivery'])->name('payment.delivery');
Route::get('/cart/list',[HomeController::class,'cartList'])->name('cart.list');

// all stores
Route::get('admin/All-Stores', [StoreController::class, 'allStores'])->name('allStores');
Route::post('admin/store-update-profit', [StoreController::class, 'storeUpdateProfit'])->name('store-update-profit');

//Cart

Route::get('view-cart', [HomeController::class, 'cart'])->name('view.cart');

Route::get('add-to-cart/{id}', [HomeController::class, 'addToCart'])->name('add.to.cart');

Route::patch('update-cart', [HomeController::class, 'update'])->name('update.cart');

Route::delete('remove-from-cart', [HomeController::class, 'remove'])->name('remove.from.cart');

Route::get('/private-product/{random_string_for_private}', [HomeController::class, 'private_product_link'])->name('private.product.link');
//Excel export
Route::get('/export', [HomeController::class, 'export'])->name('export');

// GAMES
Route::get('/games', [GameController::class, 'index'])->name('games');
Route::get('/games/filter/{category}/{subcategory?}/{subsubcategory?}', [GameController::class, 'filter'])->name('games.filter');
Route::get('/games/category/{slug}', [GameController::class, 'category'])->name('games.category');
Route::get('/games/category/{slug}/{sortin}', [GameController::class, 'sorts'])->name('games.sorts');
Route::get('/games/subcategory/{slug}', [GameController::class, 'subcategory'])->name('games.subcategory');
Route::get('/games/subcategory/{slug}/{sortin}', [GameController::class, 'subsorts'])->name('games.subsorts');
Route::get('/games/details/{slug}', [GameController::class, 'details'])->name('games.details');
Route::post('/games/out_of_stock', [GameController::class, 'outOfStock'])->name('games.out_of_stock');
Route::post('/games/userticket', [GameController::class, 'userTicket'])->name('games.userticket');
Route::get('/games/showsubcategory/{id}', [GameController::class, 'showsubcategory'])->name('showsubcategoryclient');
Route::get('/games/showsubsubcategory/{id}', [GameController::class, 'showsub_subcategory'])->name('showsub_subcategoryclient');

Route::get('/cart_checkout', [GameController::class, 'cart_checkout'])->name('games.cart_checkout');
Route::get('/price/filter/{minimum}/{maximum?}', [GameController::class, 'pricefilter'])->name('games.pricefilter');

Route::post('/payment/cart', [paymentController::class, 'payment'])->name('payment.cart');

Route::post('/paymentManual/cart', [paymentController::class, 'paymentManual'])->name('paymentManual.cart');

Route::post('/paymentManualPayeer/cart', [paymentController::class, 'paymentManualPayeer'])->name('paymentManualPayeer.cart');


Route::post('/proxy-block', [OrderController::class, 'blockProxy'])->name('block.proxy');

// LICENCE KEYS
Route::get('/licence-keys', [FrontendLicenceKeyController::class, 'index'])->name('licence.keys');
Route::get('/licence-keys/{slug}', [FrontendLicenceKeyController::class, 'find'])->name('licence.keys.find');
Route::get('/licence-keys/details/{slug}', [FrontendLicenceKeyController::class, 'details'])->name('licence.keys.details');

// STRIPE
Route::get('/thanksPayment', [paymentController::class,'stripeThanks'])->name('stripe.thanksPayment');

Route::get('/thanks', [StripeController::class,'stripeThanks'])->name('stripe.thanks');
Route::get('/cancel', [StripeController::class,'stripeCancel'])->name('stripe.cancel');
Route::post('/stripe/pay', [StripeController::class, 'pay'])->name('stripe.pay');
Route::post('/stripe/addbalance', [StripeController::class, 'addBalance'])->name('stripe.addbalance');

//PERFECTMONEY
Route::post('/perfectmoney/pay', [PerfectMoneyController::class, 'pay'])->name('perfectmoney.pay');
Route::post('/perfectmoney/addbalance', [PerfectMoneyController::class, 'addBalance'])->name('perfectmoney.addbalance');
Route::post('/perfectmoney/thanks', [PerfectMoneyController::class,'success'])->name('perfectmoney.thanks');
Route::post('/perfectmoney/cancel', [PerfectMoneyController::class,'cancel'])->name('perfectmoney.cancel');

// PAYPAL
Route::get('/paypal/thanks', [PayPalController::class,'success'])->name('paypal.thanks');
Route::get('/paypal/cancel', [PayPalController::class,'cancel'])->name('paypal.cancel');
Route::post('/paypal/pay', [PayPalController::class, 'pay'])->name('paypal.pay');
Route::post('/paypal/addbalance', [PayPalController::class, 'addBalance'])->name('paypal.addbalance');

Route::get('/payeer/thanks', [PayeerController::class,'success'])->name('payeer.thanks');
Route::get('/payeer/cancel', [PayeerController::class,'cancel'])->name('payeer.cancel');
Route::post('/payeer/pay', [PayeerController::class, 'pay'])->name('payeer.pay');
Route::post('/payeer/addbalance', [PayeerController::class, 'addBalance'])->name('payeer.addbalance');

// COINBASE
Route::post('/coinbase/pay', [CoinbaseController::class, 'pay'])->name('coinbase.pay');
Route::post('/coinbase/addbalance', [CoinbaseController::class, 'addBalance'])->name('coinbase.addbalance');

// AUTH
Route::get('/signin', [FrontendAuthController::class, 'signin'])->name('signin');
Route::get('/signup/{slug?}', [FrontendAuthController::class, 'signup'])->name('signup');
Route::get('/logout', [FrontendAuthController::class, 'logout'])->name('logout');
Route::post('/signin/check', [FrontendAuthController::class, 'signinCheck'])->name('signin.check');
Route::post('/signup/check', [FrontendAuthController::class, 'signupCheck'])->name('signup.check');
Route::get('/forgot-password', [FrontendAuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/password/update', [FrontendAuthController::class, 'passwordUpdate'])->name('password.update');
Route::get('/password/reset/{token}/{email}', [FrontendAuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/forgot-password/check', [FrontendAuthController::class, 'forgotPasswordCheck'])->name('forgot.password.check');

// USER PROFILE
Route::group(
    [
        'prefix' => 'profile',
        'as' => 'profile.',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/tickets', [ProfileController::class, 'tickets'])->name('tickets');
        Route::get('/purchses', [ProfileController::class, 'purchses'])->name('purchses');
        Route::get('/referral', [ProfileController::class, 'referral'])->name('referral');
        Route::get('/viewaccount/{slug}', [ProfileController::class, 'viewAccount'])->name('viewaccount');
        Route::post('/downloadaccount', [ProfileController::class, 'downloadAccount'])->name('downloadaccount');
        Route::post('/showaccount', [ProfileController::class, 'showDetails'])->name('showaccount');
        Route::post('/withdraw', [ProfileController::class, 'withDraw'])->name('withdraw');
    }
);

// ADMIN PANEL ROUTES
// Main Page Route
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('admin/login/check', [AuthController::class, 'loginCheck'])->name('admin.login.check');
Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth','can:admin'],
    ],
    function () {
        // MAIN ADMIN ROUTES
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/password', [AuthController::class, 'password'])->name('password');
        Route::post('/password/update', [AuthController::class, 'passwordUpdate'])->name('password.update');

        // ADMIN STORE ROUTE
        Route::group(
            [
                'prefix' => 'store',
                'as' => 'store.',
            ],
            function () {
                Route::get('/', [StoreController::class, 'index']);
                Route::post('/update', [StoreController::class, 'update'])->name('update');
            }
        );

        // ADMIN FEATURED PRODUCTS ROUTE
        Route::group(
            [
                'prefix' => 'featureproducts',
                'as' => 'featureproducts.',
            ],
            function () {
                Route::get('/', [FeatureProductController::class, 'index']);
                Route::get('/list', [FeatureProductController::class, 'list'])->name('list');
                Route::post('/addKey', [FeatureProductController::class, 'addKey'])->name('addKey');
                Route::get('/delete/{id}', [FeatureProductController::class, 'delete'])->name('delete');
                Route::post('/addAccount', [FeatureProductController::class, 'addAccount'])->name('addAccount');
            }
        );

        // ADMIN USERS ROUTE
        Route::group(
            [
                'prefix' => 'users',
                'as' => 'users.',
            ],
            function () {
                Route::get('/', [UserController::class, 'index']);
                Route::post('/add', [UserController::class, 'add'])->name('add');
                Route::post('/update', [UserController::class, 'update'])->name('update');
                Route::get('/list', [UserController::class, 'list'])->name('list');
                Route::get('/status/{id}', [UserController::class, 'status'])->name('status');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
                Route::get('/details/{id}', [UserController::class, 'details'])->name('details');
                Route::get('/security/{id}', [UserController::class, 'security'])->name('security');
                Route::get('/orders/{id}', [UserController::class, 'orders'])->name('orders');
                Route::get('/orders/list/{id}', [UserController::class, 'ordersList'])->name('orders.list');
                Route::post('/security/update', [UserController::class, 'securityUpdate'])->name('security.update');
            }
        );

        // ADMIN ROLES ROUTE
        Route::group(
            [
                'prefix' => 'roles',
                'as' => 'roles.',
            ],
            function () {
                Route::get('/', [RoleController::class, 'index']);
                Route::post('/add', [RoleController::class, 'add'])->name('add');
                Route::get('/list', [RoleController::class, 'list'])->name('list');
                Route::post('/update', [RoleController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
            }
        );

        // ADMIN CATEGORIES ROUTE
        Route::group(
            [
                'prefix' => 'categories',
                'as' => 'categories.',
                'middleware' => 'checkRolePermissions:Categories,1,2',
            ],
            function () {
                Route::get('/', [CategoryController::class, 'index']);
                Route::post('/add', [CategoryController::class, 'add'])->name('add');
                Route::post('/update', [CategoryController::class, 'update'])->name('update');
                Route::get('/list', [CategoryController::class, 'list'])->name('list');
                Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
            }
        );

        // ADMIN SUBCATEGORIES ROUTE
        Route::group(
            [
                'prefix' => 'subcategories',
                'as' => 'subcategories.',
                'middleware' => 'checkRolePermissions:SubCategories,1,2',
            ],
            function () {
                Route::get('/', [SubCategoryController::class, 'index']);
                Route::post('/add', [SubCategoryController::class, 'add'])->name('add');
                Route::post('/update', [SubCategoryController::class, 'update'])->name('update');
                Route::get('/list', [SubCategoryController::class, 'list'])->name('list');
                Route::get('/delete/{id}', [SubCategoryController::class, 'delete'])->name('delete');
            }
        );

        // ADMIN SUB SUBCATEGORIES ROUTE
        Route::group(
            [
                'prefix' => 'sub_subcategories',
                'as' => 'sub_subcategories.',
                'middleware' => 'checkRolePermissions:Sub SubCategories,1,2',
            ],
            function () {
                Route::get('/', [SubSubcategoryController::class, 'index']);
                Route::post('/add', [SubSubcategoryController::class, 'add'])->name('add');
                Route::post('/update', [SubSubcategoryController::class, 'update'])->name('update');
                Route::get('/list', [SubSubcategoryController::class, 'list'])->name('list');
                Route::get('/delete/{id}', [SubSubcategoryController::class, 'delete'])->name('delete');
            }
        );

        // ADMIN TICKETS ROUTE
        Route::group(
            [
                'prefix' => 'tickets',
                'as' => 'tickets.',
                'middleware' => 'checkRolePermissions:Tickets,1,2',
            ],
            function () {
                Route::get('/', [TicketController::class, 'index']);
                Route::get('/list', [TicketController::class, 'list'])->name('list');
                Route::post('/answer', [TicketController::class, 'answer'])->name('answer');
                Route::get('/delete/{id}', [TicketController::class, 'delete'])->name('delete');
                Route::get('/details/{id}', [TicketController::class, 'details'])->name('details');
            }
        );

        // ADMIN USER TICKETS ROUTE
        Route::group(
            [
                'prefix' => 'usertickets',
                'as' => 'usertickets.',
                'middleware' => 'checkRolePermissions:User Tickets,1,2',
            ],
            function () {
                Route::get('/', [UserTicketController::class, 'index']);
                Route::get('/list', [UserTicketController::class, 'list'])->name('list');
                Route::post('/answer', [UserTicketController::class, 'answer'])->name('answer');
                Route::get('/delete/{id}', [UserTicketController::class, 'delete'])->name('delete');
                Route::get('/details/{id}', [UserTicketController::class, 'details'])->name('details');
            }
        );

        Route::group(
          [
              'prefix' => 'customrefferal',
              'as' => 'customrefferal.',
          ],
          function () {
              Route::get('/', [CustomRefferalController::class, 'index']);
              Route::get('/new', [CustomRefferalController::class, 'create'])->name('create');
              Route::post('/refferal-add', [CustomRefferalController::class, 'add'])->name('refferal.store');
              Route::get('/list', [CustomRefferalController::class, 'list'])->name('list');
              Route::get('/edit/{id}', [CustomRefferalController::class, 'edit'])->name('refferal.edit');
              Route::post('/update', [CustomRefferalController::class, 'update'])->name('update');
              Route::get('/delete/{id}', [CustomRefferalController::class, 'delete'])->name('customrefferal.delete');
              Route::get('/user-detail/{refferal_name}', [CustomRefferalController::class, 'user_detail'])->name('user.detail');

          }
      );


        // ADMIN With Draw ROUTE
        Route::group(
            [
                'prefix' => 'withdraw',
                'as' => 'withdraw.',
            ],
            function () {
                Route::get('/', [WithDrawController::class, 'index']);
                Route::get('/list', [WithDrawController::class, 'list'])->name('list');
                Route::post('/answer', [WithDrawController::class, 'answer'])->name('answer');
            }
        );
        Route::group(
            [
                'prefix' => 'review',
                'as' => 'review.',
            ],
            function () {
                Route::get('/', [ReviewController::class, 'index']);
                Route::post('/store', [ReviewController::class, 'store'])->name('store');
                Route::get('/list', [ReviewController::class, 'list'])->name('list');
                Route::post('/answer', [ReviewController::class, 'answer'])->name('answer');
            }
        );

        // ADMIN GIVEAWAY ROUTE
        Route::group(
            [
                'prefix' => 'giveaway',
                'as' => 'giveaway.',
                'middleware' => 'checkRolePermissions:Giveaways,1,2',
            ],
            function () {
                Route::get('/', [GiveAwayController::class, 'index']);
                Route::post('/sendbalance', [GiveAwayController::class, 'sendBalance'])->name('sendbalance');
                Route::get('/new', [GiveAwayController::class, 'new'])->name('new');
                Route::post('/add', [GiveAwayController::class, 'add'])->name('add');
                Route::get('/list', [GiveAwayController::class, 'list'])->name('list');
                Route::get('/edit/{id}', [GiveAwayController::class, 'edit'])->name('edit');
                Route::post('/update', [GiveAwayController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [GiveAwayController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [GiveAwayController::class, 'status'])->name('status');
            }
        );


        // ADMIN GAMINGACCOUNTS ROUTE
        Route::group(
            [
                'prefix' => 'gamingaccounts',
                'as' => 'gamingaccounts.',
                'middleware' => 'checkRolePermissions:Accounts,1,2',
            ],
            function () {
                Route::get('/', [GamingAccountController::class, 'index']);
                Route::get('/new', [GamingAccountController::class, 'new'])->name('new');
                Route::post('/add', [GamingAccountController::class, 'add'])->name('add');
                Route::get('/list', [GamingAccountController::class, 'list'])->name('list');
                Route::get('/edit/{id}', [GamingAccountController::class, 'edit'])->name('edit');
                Route::post('/update', [GamingAccountController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [GamingAccountController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [GamingAccountController::class, 'status'])->name('status');
                Route::get('/details/{id}', [GamingAccountController::class, 'details'])->name('details');
                Route::post('/restock', [GamingAccountController::class, 'restock'])->name('restock');

            }
        );
        Route::group(
            [
                'prefix' => 'templates',
                'as' => 'templates.',
                'middleware' => 'checkRolePermissions:templates,1,2',
            ],
            function () {
                Route::get('/', [TemplateController::class, 'index']);
                Route::get('/new', [TemplateController::class, 'new'])->name('new');
                Route::post('/add', [TemplateController::class, 'add'])->name('add');
                Route::get('/list', [TemplateController::class, 'list'])->name('list');
                Route::get('/edit/{id}', [TemplateController::class, 'edit'])->name('edit');
                Route::post('/update', [TemplateController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [TemplateController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [TemplateController::class, 'status'])->name('status');
                Route::get('/details/{id}', [TemplateController::class, 'details'])->name('details');
            }
        );

        Route::group(
            [
                'prefix' => 'coupon',
                'as' => 'coupon.',
                'middleware' => 'checkRolePermissions:Coupon,1,2',
            ],
            function () {
                Route::get('/', [CouponController::class, 'index']);
                Route::post('coupon-add',[CouponController::class, 'add'])->name('add');
                Route::get('/list', [CouponController::class, 'list'])->name('list');
            }
        );

        Route::group(
            [
                'prefix' => 'volume',
                'as' => 'volume.',
                'middleware' => 'checkRolePermissions:Volume Discount,1,2',
            ],
            function () {
                Route::get('/', [VolumeController::class, 'index']);
                Route::post('volume-add',[VolumeController::class, 'add'])->name('add');
                Route::get('/list', [VolumeController::class, 'list'])->name('list');
            }
        );

        // ADMIN LICENCEKEYS ROUTE
        Route::group(
            [
                'prefix' => 'licencekeys',
                'as' => 'licencekeys.',
            ],
            function () {
                Route::get('/', [LicenceKeyController::class, 'index']);
                Route::get('/new', [LicenceKeyController::class, 'new'])->name('new');
                Route::post('/add', [LicenceKeyController::class, 'add'])->name('add');
                Route::get('/list', [LicenceKeyController::class, 'list'])->name('list');
                Route::get('/edit/{id}', [LicenceKeyController::class, 'edit'])->name('edit');
                Route::post('/update', [LicenceKeyController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [LicenceKeyController::class, 'delete'])->name('delete');
                Route::get('/status/{id}', [LicenceKeyController::class, 'status'])->name('status');
                Route::get('/details/{id}', [LicenceKeyController::class, 'details'])->name('details');
            }
        );

        // ADMIN ORDERS ROUTE
        Route::group(
            [
                'prefix' => 'orders',
                'as' => 'orders.',
                'middleware' => 'checkRolePermissions:Orders,1,2',
            ],
            function () {
                Route::get('/', [OrderController::class, 'index']);
                Route::get('/list', [OrderController::class, 'list'])->name('list');
                Route::get('/account-details/{user_id}', [OrderController::class, 'accountdetails'])->name('accountdetails');
                Route::post('/update-account-status', [OrderController::class, 'updateAccountStatus'])->name('updateAccountStatus');
              }
        );

        // ADMIN ORDERS ROUTE
        Route::group(
            [
                'prefix' => 'manualorders',
                'as' => 'manualorders.',
                'middleware' => 'checkRolePermissions:Manual Orders,1,2',
            ],
            function () {
                Route::get('/', [OrderController::class, 'manualIndex']);
                Route::get('/manuallist', [OrderController::class, 'manuallist'])->name('manuallist');
                Route::get('/details/{id}', [OrderController::class, 'details'])->name('details');
                Route::post('/update', [OrderController::class, 'update'])->name('update');
            }
        );

        // ADMIN TRANSACTIONS ROUTE
        Route::group(
            [
                'prefix' => 'transactions',
                'as' => 'transactions.',
                'middleware' => 'checkRolePermissions:Transactions,1,2',
            ],
            function () {
                Route::get('/', [TransactionController::class, 'index']);
                Route::get('/list', [TransactionController::class, 'list'])->name('list');
            }
        );
    }
);

