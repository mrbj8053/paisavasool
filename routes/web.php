<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
  //  return redirect()->route('login');
    return view('welcome');
})->name('welcome');
Route::get('/zoom_meeting', function () {
    return view('zoom_meeting');
})->name('zoom_meeting');


Auth::routes();

Route::get('/test', 'ajaxController@test');
Route::get('register/success/{id}', 'ajaxController@registerSuccess')->name('register.success');


Route::get('income/send/teleearningshop', 'ajaxController@sendCroneIncomes')->name('sendcroneincomes');

/*----------Admin Routes --------------------*/
//admin home
Route::get('/admin', 'adminController@index')->name('admin.dashboard.home');

//manage amount deduction and cash
Route::get('/admin/amount/manage', 'adminController@showManageAmount')->name('admin.user.amount');
Route::post('/admin/amount/manage', 'adminController@manageAmountApply')->name('admin.user.amount');

//firm details
Route::get('/admin/firmdetails', 'adminController@showFirmDetails')->name('admin.firmdetails');
Route::post('/admin/firmdetails', 'adminController@updateFirmDetails')->name('admin.firmdetails');

//delete kyc
Route::get('/admin/kyc/delete/{id}', 'adminController@deleteKyc')->name('admin.kyc.delete');


//gallery
Route::get('/admin/gallery', 'adminController@showGallery')->name('admin.gallery.show');
Route::post('/admin/gallery', 'adminController@uploadGallery')->name('admin.gallery.upload');
Route::get('/admin/gallery/delete/{id}', 'adminController@deleteGallery')->name('admin.gallery.delete');

//Achievers
Route::get('/admin/achievers', 'adminController@showAchievers')->name('admin.achievers.show');
Route::post('/admin/achievers', 'adminController@uploadAchievers')->name('admin.achievers.upload');
Route::get('/admin/achievers/delete/{id}', 'adminController@deleteAchievers')->name('admin.achievers.delete');

//Achievers
Route::get('/admin/zoom/{id?}', 'adminController@show_zoom_meeting')->name('admin.zoom_meeting.show');
Route::post('/admin/zoom', 'adminController@add_zoom_meeting')->name('admin.zoom.meeting.add');
Route::get('/admin/zoom/delete/{id}', 'adminController@delete_zoom_meeting')->name('admin.zoom_meeting.delete');

//Achievers
Route::get('/admin/video/', 'adminController@show_video')->name('admin.video');
Route::post('/admin/video/add', 'adminController@add_video')->name('admin.video.add');
Route::get('/admin/video/delete/{id}', 'adminController@delete_video')->name('admin.video.delete');
//admin login and logout
Route::get('/admin/login', 'Auth\AdminController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminController@login')->name('admin.login.submit');
Route::post('/admin/logout', 'adminController@logout')->name('admin.logout');

/*Admin user login start*/
Route::get('admin/user/login/{id}/{pass}','adminController@userLogin')->name("admin.user.login");
/*Admin user login end*/


//apply withdraw
Route::get('/admin/withdraw/apply', 'adminController@applyWithdraw')->name('admin.withdraw.apply');


//epin
Route::get('admin/epin/pending/', 'adminController@showEpinPending')->name('admin.epin.pending');
Route::post('admin/epin/generate/', 'adminController@generateEpin')->name('admin.epin.generate');
Route::post('admin/epin/transfer/', 'adminController@epinTransfer')->name('admin.epin.transfer');
Route::get('admin/epin/transfered/', 'adminController@showPinTransferred')->name('admin.epin.transferred');
Route::get('admin/epin/used/', 'adminController@showEpinUsed')->name('admin.epin.used');


//give reward
Route::get('admin/reward/give/show/', 'adminController@addRewardManual')->name('admin.reward.manual.show');
Route::post('admin/reward/give/add/', 'adminController@addRewardFinal')->name('admin.reward.manual.add');




//user
Route::get('admin/allusers', 'adminController@showUsers')->name('admin.alluser');
Route::get('admin/allusers/inactive', 'adminController@showUsersInactive')->name('admin.alluser.inactive');
//club members
Route::get('admin/royaltymembers', 'adminController@showRoyaltyMembers')->name('admin.royaltymembers');

//reward members
Route::get('admin/reward', 'adminController@showRewardMembers')->name('admin.reward');

//user status
Route::get('admin/user/status/{id}', 'adminController@changeUserStatus')->name('admin.user.status');
//user profile
Route::get('admin/user/profile/{id}', 'adminController@showEditProfile')->name('admin.user.profile');
Route::post('admin/user/profile/{id}', 'adminController@editUserProfile')->name('admin.user.profile');
Route::get('admin/user/leveldetails/{id}', 'adminController@showLevelDetails')->name('admin.user.leveldetails');
//user kyc
Route::get('admin/user/kyc/cnf', 'adminController@showKycPendingCnf')->name('admin.user.kyc.pending.cnf');
Route::get('admin/user/kyc/pending', 'adminController@showKyc')->name('admin.user.kyc.pending');
Route::get('admin/user/kyc/done', 'adminController@showKycDone')->name('admin.user.kyc.done');
Route::get('admin/user/kyc/edit/{id}', 'adminController@showEditKyc')->name('admin.user.kyc.edit');
Route::post('admin/user/kyc/edit/{id}', 'adminController@updateEditKyc')->name('admin.user.kyc.edit');
//kyc status
Route::get('admin/user/kyc/status/{id}', 'adminController@changeKycStatus')->name('admin.user.kyc.status');

//directIincome
Route::get('admin/income/{type}/', 'adminController@showIncome')->name('admin.income');
Route::get('admin/income/{type}/detail/{id}', 'adminController@showIncomeDetail')->name('admin.income.detail');

//Downline
Route::post('/admin/showtree/', 'adminController@showTreePost')->name('admin.showtree');

//Packages request
Route::get('/admin/packages/{type?}', 'adminController@packageRequest')->name('admin.package.request');//for pending send 0 else 1
Route::get("/admin/package/delete/{id}",'adminController@deletePackage')->name("admin.package.delete");
Route::get("/admin/package/apply/{id}",'adminController@activatePackage')->name("admin.package.apply");



//Sale Packages request
Route::get('/admin/sale/packages/{type?}', 'adminController@salePackageRequest')->name('admin.salepackage.request');//for pending send 0 else 1
Route::get("/admin/sale/package/delete/{id}",'adminController@deleteSalePackage')->name("admin.salepackage.delete");
Route::get("/admin/sale/package/apply/{id}",'adminController@activateSalePackage')->name("admin.salepackage.apply");





//Withdraw
Route::get('/admin/withdraw/apply', 'adminController@showWithdrawApply')->name('admin.withdraw.apply');
Route::get('/admin/withdraw/change/{id}/{status}', 'adminController@showWithdrawApplyFinal')->name('admin.withdraw.change');
Route::get('/admin/withdraw/paid', 'adminController@showWithdrawPaid')->name('admin.withdraw.paid');
Route::get('/admin/withdraw/pending', 'adminController@showWithdrawPending')->name('admin.withdraw.pending');

//appy withdraw pending using ajax call
Route::post('/admin/goPayment', 'adminController@doPayment')->name('doPayment');

//change passsword
Route::get('/admin/password', 'adminController@showPasswordForm')->name('admin.password');
Route::post('/admin/change', 'adminController@changePassword')->name('admin.password.change');


//company wallet
Route::get('/admin/companywallet', 'adminController@showCompanyWallet')->name('admin.companywallet');

//filter by date
Route::post('/admin/filter', 'adminController@filterApply')->name('admin.filter');
Route::get('/admin/filter/clear', 'adminController@clearFilter')->name('admin.filter.clear');


//epin requests
Route::get('/admin/epin/requests', 'adminController@showEpinRequest')->name('admin.epin.requests');
Route::get('/admin/epin/requests/approove/{id}', 'adminController@approoveEpinRequest')->name('admin.epin.request.accept');
Route::get('/admin/epin/requests/decline/{id}', 'adminController@declineEpinRequest')->name('admin.epin.request.decline');


//activate User
Route::get('admin/activate/profile/{epin}/{type?}/{foradmin?}', 'ajaxController@activateUser')->name('admin.profile.activate');


Route::post('user/password/forgot', 'ajaxController@forgotPassword')->name('user.password.forgot');

//send repucrhase amount
Route::get('admin/apply/repurchase/show', 'adminController@showRepurchase')->name('admin.repurchase.show');
Route::post('admin/apply/repurchase/', 'adminController@applyRepurchase')->name('admin.repurchase.apply');
Route::post('admin/apply/repurchase/delete', 'v@deleteRepurchase')->name('admin.repurchase.delete');



Route::get('admin/closing/details/{id}', 'adminController@showClosingDetails')->name('admin.closing.details');


Route::post('admin/closing/post', 'adminController@postClosing')->name('admin.closing.post');


/*Change User Password*/
Route::get('admin/user/password', 'adminController@userPassword')->name('admin.user.password');
Route::post('admin/user/password', 'adminController@userPasswordUpdate')->name('admin.user.password');
/*Slider*/
Route::get('admin/slider', 'adminController@show_slider')->name('admin.slider');
Route::post('admin/slider/add', 'adminController@add_slider')->name('admin.slider.add');
Route::get('admin/slider/delete/{id}', 'adminController@delete_slider')->name('admin.slider.delete');

//show company business
Route::get('admin/user/company/business','adminController@showCompanyBusiness')->name('admin.company.business');
Route::get('admin/user/company/business/details/{jdate}','adminController@showCompanyBusinessDetails')->name('admin.company.business.details');



/*--------------- User Routes -------------------- */
Route::get('register/{ownid?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
//User home
Route::get('/home', 'HomeController@index')->name('home');

/*Epins */
Route::get('/epins/pending', 'userController@epinPending')->name('user.epin.pending');
Route::get('/epins/used', 'userController@epinUsed')->name('user.epin.used');
Route::post('/epins/transfer', 'userController@epinTransfer')->name('user.epin.transfer');
//User Available E-pins
Route::get('/admin/availablepin/', 'userController@availablepin')->name('user.availablepin');
//User Used E-pins
Route::get('/admin/usedepins/', 'userController@usedepins')->name('user.usedepins');
//User Transfer E-pins Detail
Route::get('/admin/transferepindet/', 'userController@transferepindet')->name('user.transferepindet');
Route::get('/admin/recievedEpin/', 'userController@recievedEpin')->name('user.epin.recieved');
//User Transfer E-pins
Route::get('/admin/transferepin/', 'userController@transferepin')->name('user.transferepin');

Route::get('/user/print/','userController@applyA4print')->name("user.A4print");



//Profile
Route::get('/show/profile', 'userController@showProfile')->name('user.profile');
Route::post('/profile/update', 'userController@updateProfile')->name('user.profile.update');
//All Directs
Route::get('/alldirects/', 'userController@alldirects')->name('user.alldirects');
//Active Directs
Route::get('/activedirects/', 'userController@activedirects')->name('user.activedirects');
//Inactive Directs
Route::get('/inactivedirects/', 'userController@inactivedirects')->name('user.inactivedirects');
//Check Laedership Directs
Route::get('/checkleadership/', 'userController@checkleadership')->name('user.checkleadership');
//User Registerpage Directs
Route::get('/register2/', 'userController@register2')->name('user.register2');
//User editprofile
Route::get('/editprofile/', 'userController@editprofile')->name('user.editprofile');
//User ChangePassword
Route::get('/changepass/',function(){
    return view('user.changePassword');
})->name('user.changepass');
Route::post('/changepass/', 'userController@changepass')->name('user.changepass');
//User Current Txn password
Route::get('/changetxnpass/',function(){
    return view('user.changetxnpassword');
})->name('user.changetxnpassword');
Route::post('/changetxnpass/', 'userController@changetxnpass')->name('user.changetxnpass');

//User Add Benificiary
Route::get('/addbeneficiary/', 'userController@addbeneficiary')->name('user.addbeneficiary');
//User Add Moneytransfer
Route::get('/moneytransfer/', 'userController@moneytransfer')->name('user.moneytransfer');
//User Add royaltyachive
Route::get('/royaltyachive/', 'userController@royaltyachive')->name('user.royaltyachive');
//User Add leadershipachivers
Route::get('/leadershipachivers/', 'userController@leadershipachivers')->name('user.leadershipachivers');

//share
Route::get('/share/', 'userController@sharePage')->name('user.share');


//kyc
Route::get('/kyc/show', function () {
    return view('user.kyc');
})->name('user.kyc');
Route::post('/kyc/show', 'userController@updateKyc')->name('user.kyc.update');
//changePassword
Route::get('/changepassword', function () {
    return view('user.changePassword');
})->name('user.password.change');
Route::post('/changepassword', 'userController@changePassword')->name('user.password.change');

//directIncome
Route::get('/income/{type}', 'userController@showUserIncome')->name('user.income');

//trading
Route::get('/trading/', 'userController@showUserTrading')->name('user.trading');


//tradingpackage
Route::get('/trading/package', function () {
    return view('user.tradingPakcage');
})->name('user.trading.packages');
Route::post('/trading/package','userController@requestTradingPackage')->name('user.trading.packages');



//salepackage
Route::get('/sale/package', function () {
    return view('user.salePackage');
})->name('user.sale.packages');
Route::post('/sale/package','userController@requestSalePackage')->name('user.sale.packages');


//my tree
Route::get('/mytree/{id}/{name}', 'userController@showTree')->name('user.mytree');
//downline
Route::get('/downline', 'userController@showDownline')->name('user.downline');

//withdraw
Route::get('/withdraw/paid', 'userController@withdrawPaid')->name('user.withdraw.paid');
Route::get('/withdraw/pending', 'userController@withdrawPending')->name('user.withdraw.pending');


Route::get('/withdraw/txnid','userController@checkTxn')->name("user.withdraw.txn");
Route::post('/withdraw/apply','userController@applyWithdraw')->name("user.withdraw.apply");




Route::get('/withdraw/details/{id}', 'userController@withdrawDetails')->name('user.withdraw.details');
Route::post('/register/details/', 'ajaxController@register')->name('user.register.submit');
Route::post('/sponsar/details/', 'ajaxController@getSponsar')->name('user.sponsar.external');



//upgrade plan
Route::get('/plan/upgrade', function () {
    return view('user.upgradeplan');
})->name('user.plan.upgrade');

Route::post('/plan/upgrade', 'userController@upgradePlan')->name('user.plan.upgrade');

//filter by date
Route::post('/user/filter', 'userController@filterApply')->name('user.filter');
Route::get('/user/filter/clear', 'userController@clearFilter')->name('user.filter.clear');

//epin request
Route::get('/admin/epin/request', 'userController@showEpinRequest')->name('user.epin.request');
Route::post('/admin/epin/request', 'userController@applyEpinRequest')->name('user.epin.request');

/*Show CLosing */
Route::get('/user/withdraw/apply/{type?}', 'userController@showWithdrawApply')->name('user.withdraw.apply');
Route::post('/user/withdraw/apply/final', 'userController@withdrawApplyFinal')->name('user.withdraw.apply.final');
Route::get('user/closing/details/{id}', 'userController@showClosingDetails')->name('user.closing.details');
