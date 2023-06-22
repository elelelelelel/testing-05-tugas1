<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

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

Route::get('/', [\App\Http\Controllers\HomeContoller::class, 'index']);
Route::get('/home', [\App\Http\Controllers\HomeContoller::class, 'index']);
Route::get('/sub-categories/{id}', [\App\Http\Controllers\HomeContoller::class, 'getSubCategories']);
Route::get('/confirm-email/{token}', [\App\Http\Controllers\HomeContoller::class, 'confirmEmail'])->name('confirm-email');

Route::group(['middleware' => ['role:admin'], 'namespace' => 'Dashboard/Admin', 'as' => 'dashboard.admin.', 'prefix' => '/dashboard/admin'], function () {
    Route::get('users', [\App\Http\Controllers\Dashboard\Admin\UserController::class, 'index'])->name('user.index');
    Route::post('users', [\App\Http\Controllers\Dashboard\Admin\UserController::class, 'store'])->name('user.store');
    Route::get('users/create', [\App\Http\Controllers\Dashboard\Admin\UserController::class, 'create'])->name('user.create');

    Route::get('categories', [\App\Http\Controllers\Dashboard\Admin\CategoryController::class, 'index'])->name('category.index');
    Route::post('categories', [\App\Http\Controllers\Dashboard\Admin\CategoryController::class, 'store'])->name('category.store');
    Route::get('categories/create', [\App\Http\Controllers\Dashboard\Admin\CategoryController::class, 'create'])->name('category.create');

    Route::get('sub-categories/create/{category_id}', [\App\Http\Controllers\Dashboard\Admin\SubCategoryController::class, 'create'])->name('sub-category.create');
    Route::get('sub-categories/{category_id}', [\App\Http\Controllers\Dashboard\Admin\SubCategoryController::class, 'index'])->name('sub-category.index');
    Route::post('sub-categories/{category_id}', [\App\Http\Controllers\Dashboard\Admin\SubCategoryController::class, 'store'])->name('sub-category.store');

    Route::get('price-list', [\App\Http\Controllers\Dashboard\Admin\PriceListController::class, 'index'])->name('price-list.index');
    Route::put('price-list/{id}/edit', [\App\Http\Controllers\Dashboard\Admin\PriceListController::class, 'update'])->name('price-list.update');

    //setting
    Route::get('settings', [\App\Http\Controllers\Dashboard\Admin\SettingController::class, 'index'])->name('setting.index');
    Route::get('settings/edit/{slug}', [\App\Http\Controllers\Dashboard\Admin\SettingController::class, 'edit'])->name('setting.edit');
    Route::put('settings/{slug}/edit', [\App\Http\Controllers\Dashboard\Admin\SettingController::class, 'update'])->name('setting.update');
});

Route::group(['middleware' => ['role:makelar'], 'namespace' => 'Dashboard/Makelar', 'as' => 'dashboard.makelar.', 'prefix' => '/dashboard/makelar'], function () {
    Route::get('orders', [\App\Http\Controllers\Dashboard\Makelar\OrderController::class, 'index'])->name('order.index');
    Route::post('orders/confirm', [\App\Http\Controllers\Dashboard\Makelar\OrderController::class, 'confirm'])->name('order.confirm');
    Route::post('orders/decline', [\App\Http\Controllers\Dashboard\Makelar\OrderController::class, 'decline'])->name('order.decline');
    Route::post('orders/refund', [\App\Http\Controllers\Dashboard\Makelar\OrderController::class, 'refund'])->name('order.refund');
    Route::get('orders/{invoice}', [\App\Http\Controllers\Dashboard\Makelar\OrderController::class, 'show'])->name('order.show');

    //auction
    Route::get('auctions', [\App\Http\Controllers\Dashboard\Makelar\AuctionController::class, 'index'])->name('auction.index');
    Route::post('auctions/{id}', [\App\Http\Controllers\Dashboard\Makelar\AuctionController::class, 'store'])->name('auction.store');
    Route::get('auctions/{id}', [\App\Http\Controllers\Dashboard\Makelar\AuctionController::class, 'show'])->name('auction.show');

    //withdraw
    Route::get('withdraw', [\App\Http\Controllers\Dashboard\Makelar\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('withdraw/confirm', [\App\Http\Controllers\Dashboard\Makelar\WithdrawController::class, 'confirm'])->name('withdraw.confirm');

    //user
    Route::get('users', [\App\Http\Controllers\Dashboard\Makelar\UserController::class, 'index'])->name('user.index');
    Route::post('users/approve/{id}', [\App\Http\Controllers\Dashboard\Makelar\UserController::class, 'approveUser'])->name('user.approve');
    Route::post('users/decline/{id}', [\App\Http\Controllers\Dashboard\Makelar\UserController::class, 'declineUser'])->name('user.decline');
});

Route::group(['middleware' => ['role:editor'], 'namespace' => 'Dashboard/Editor', 'as' => 'dashboard.editor.', 'prefix' => '/dashboard/editor'], function () {
    Route::get('reviewers', [\App\Http\Controllers\Dashboard\Editor\ReviewerController::class, 'index'])->name('reviewer.index');
    Route::get('reviewers/{slug}', [\App\Http\Controllers\Dashboard\Editor\ReviewerController::class, 'show'])->name('reviewer.show');

    Route::get('orders', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'index'])->name('order.index');
    Route::get('orders/create', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'create'])->name('order.create');
    Route::post('orders', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'store'])->name('order.store');
    Route::post('orders/confirm-payment', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'confirm'])->name('order.confirm-payment');
    Route::post('orders/finish', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'finish'])->name('order.finish');
    Route::get('orders/checkout/{invoice}', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('orders/detail/{invoice}', [\App\Http\Controllers\Dashboard\Editor\OrderController::class, 'show'])->name('order.show');
});

Route::group(['middleware' => ['role:reviewer'], 'namespace' => 'Dashboard/Reviewer', 'as' => 'dashboard.reviewer.', 'prefix' => '/dashboard/reviewer'], function () {
    Route::get('reviews', [\App\Http\Controllers\Dashboard\Reviewer\ReviewController::class, 'index'])->name('review.index');
    Route::post('reviews/upload-doc', [\App\Http\Controllers\Dashboard\Reviewer\ReviewController::class, 'uploadDoc'])->name('review.upload-doc');
    Route::get('reviews/{invoice}', [\App\Http\Controllers\Dashboard\Reviewer\ReviewController::class, 'show'])->name('review.show');

    //auction
    Route::get('auctions', [\App\Http\Controllers\Dashboard\Reviewer\AuctionController::class, 'index'])->name('auction.index');
    Route::post('auctions', [\App\Http\Controllers\Dashboard\Reviewer\AuctionController::class, 'store'])->name('auction.store');
    Route::get('auctions/{id}', [\App\Http\Controllers\Dashboard\Reviewer\AuctionController::class, 'show'])->name('auction.show');
    Route::get('auctions-history', [\App\Http\Controllers\Dashboard\Reviewer\AuctionController::class, 'history'])->name('auction.history');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard/profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'index'])->name('profile.index');
    Route::post('dashboard/profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'update'])->name('profile.update');

    Route::get('dashboard/withdraw', [\App\Http\Controllers\Dashboard\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('dashboard/withdraw', [\App\Http\Controllers\Dashboard\WithdrawController::class, 'store'])->name('withdraw.store');
});

Route::group(['namespace' => 'Ajax', 'as' => 'ajax.dashboard.', 'prefix' => '/ajax/dashboard'], function () {
    //admin
    Route::get('/admin/users', [\App\Http\Controllers\Ajax\AdminController::class, 'getUsers'])->name('admin.user.index');
    Route::get('/admin/settings', [\App\Http\Controllers\Ajax\AdminController::class, 'getSettings'])->name('admin.setting.index');
    Route::get('/admin/categories', [\App\Http\Controllers\Ajax\AdminController::class, 'getCategories'])->name('admin.category.index');
    Route::get('/admin/price-list', [\App\Http\Controllers\Ajax\AdminController::class, 'getPriceList'])->name('admin.price-list.index');
    Route::get('/admin/price-list/edit/{id}', [\App\Http\Controllers\Ajax\AdminController::class, 'getModalPriceList'])->name('admin.price-list.edit');
    Route::get('/admin/sub-categories/{category_id}', [\App\Http\Controllers\Ajax\AdminController::class, 'getSubCategories'])->name('admin.sub-category.index');

    //editor
    Route::get('/editor/reviewers', [\App\Http\Controllers\Ajax\EditorController::class, 'getReviewers'])->name('editor.reviewer.index');

    Route::get('/editor/orders', [\App\Http\Controllers\Ajax\EditorController::class, 'getOrders'])->name('editor.order.index');

    //reviewer
    Route::get('/reviewer/reviews', [\App\Http\Controllers\Ajax\ReviewerController::class, 'getReviews'])->name('reviewer.reviews.index');
    Route::get('/reviewer/auctions', [\App\Http\Controllers\Ajax\ReviewerController::class, 'getAuctions'])->name('reviewer.auction.index');
    Route::get('/reviewer/auctions-history', [\App\Http\Controllers\Ajax\ReviewerController::class, 'getAuctionHistories'])->name('reviewer.auction.history');

    //makelar
    Route::get('/makelar/users', [\App\Http\Controllers\Ajax\MakelarController::class, 'getUsers'])->name('makelar.user.index');
    Route::get('/makelar/orders', [\App\Http\Controllers\Ajax\MakelarController::class, 'getOrders'])->name('makelar.order.index');
    Route::get('/makelar/auctions', [\App\Http\Controllers\Ajax\MakelarController::class, 'getAuctions'])->name('makelar.auction.index');
    Route::get('/makelar/auctions/{id}', [\App\Http\Controllers\Ajax\MakelarController::class, 'getAuctionDetails'])->name('makelar.auction.show');
    Route::get('/makelar/withdraw', [\App\Http\Controllers\Ajax\MakelarController::class, 'getWithdraw'])->name('makelar.withdraw.index');

    //withdraw
    Route::get('/withdraw', [\App\Http\Controllers\Dashboard\WithdrawController::class, 'getWithdraw'])->name('withdraw.index');
});

Route::get('test', [\App\Http\Controllers\TestController::class, 'index']);
Route::get('test/scrap', [\App\Http\Controllers\TestController::class, 'scrap']);

Route::get('test/orcid', function () {
    $orcid_id = '0000-0001-6560-2975';
    $inputName = 'Daniel Oranova Siahaan';
    $similarity = check_orcid_id($orcid_id, $inputName);
    return $similarity;
    return $similarity > 70 ? 'Cocok' : 'Tidak Cocok';
});

Route::get('test/sinta', function () {
    $sinta_url = 'https://sinta.ristekbrin.go.id/authors/detail?id=5987242&view=overview';
    $inputName = 'Daniel Oranova Siahaan';
    $similarity = check_sinta_url($sinta_url, $inputName);
    return $similarity > 70 ? 'Cocok' : 'Tidak Cocok';
});
