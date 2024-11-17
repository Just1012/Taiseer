<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('auth:sanctum')->group(function () {
    // General
    Route::get('/', 'APIsController@api')->name('apiURL');
    Route::get('/website/status', 'APIsController@website_status');
    Route::get('/website/info/{lang?}', 'APIsController@website_info');
    Route::get('/website/contacts/{lang?}', 'APIsController@website_contacts');
    Route::get('/website/style/{lang?}', 'APIsController@website_style');
    Route::get('/website/social', 'APIsController@website_social');
    Route::get('/website/settings', 'APIsController@website_settings');
    Route::get('/menu/{menu_id}/{lang?}', 'APIsController@menu');
    Route::get('/banners/{group_id}/{lang?}', 'APIsController@banners');

    // Section & Topics
    Route::get('/section/{section_id}/{lang?}', 'APIsController@section');
    Route::get('/categories/{section_id}/{lang?}', 'APIsController@categories');
    Route::get('/topics/{section_id}/page/{page_number?}/count/{topics_count?}/{lang?}', 'APIsController@topics');
    Route::get('/category/{cat_id}/page/{page_number?}/count/{topics_count?}/{lang?}', 'APIsController@category');

    // Topic Sub Details
    Route::get('/topic/fields/{topic_id}/{lang?}', 'APIsController@topic_fields');
    Route::get('/topic/photos/{topic_id}/{lang?}', 'APIsController@topic_photos');
    Route::get('/topic/photo/{photo_id}/{lang?}', 'APIsController@topic_photo');
    Route::get('/topic/maps/{topic_id}/{lang?}', 'APIsController@topic_maps');
    Route::get('/topic/map/{map_id}/{lang?}', 'APIsController@topic_map');
    Route::get('/topic/files/{topic_id}/{lang?}', 'APIsController@topic_files');
    Route::get('/topic/file/{file_id}/{lang?}', 'APIsController@topic_file');
    Route::get('/topic/comments/{topic_id}/{lang?}', 'APIsController@topic_comments');
    Route::get('/topic/comment/{comment_id}/{lang?}', 'APIsController@topic_comment');
    Route::get('/topic/related/{topic_id}/{lang?}', 'APIsController@topic_related');

    // Topic Page
    Route::get('/topic/{topic_id}/{lang?}', 'APIsController@topic');

    // User Topics
    Route::get('/user/{user_id}/topics/page/{page_number?}/count/{topics_count?}/{lang?}', 'APIsController@user_topics');

    // Forms Submit
    Route::post('/subscribe', 'APIsController@subscribeSubmit');
    Route::post('/comment', 'APIsController@commentSubmit');
    Route::post('/order', 'APIsController@orderSubmit');
    Route::post('/contact', 'APIsController@ContactPageSubmit');

    // Company
    Route::post('/getCompanies', 'CompanyController@getCompanies');
    Route::get('/getCompaniesDetails/{id}', 'CompanyController@getCompaniesDetails');
    // Companies Shipments
    Route::get('/getShipmentForCompanies','ShipmentController@getShipmentForCompanies');
    Route::get('/shipmentDetails/{id}','ShipmentController@shipmentDetails');
    Route::post('/companySearch','ShipmentController@companySearch');
    // getCountryWithCity
    Route::get('/getCountryWithCity', 'CompanyController@getCountryWithCity');

    // Shipment
    Route::post('/storeShipment', 'ShipmentController@storeShipment');
    Route::get('/getShipments', 'ShipmentController@getShipments');

    //Chat
    Route::get('/getMessages/{id}', 'ChatController@index');
    Route::post('/storeMessage', 'ChatController@storeMessage');
    Route::get('/getChats', 'ChatController@getChats');

    // Rating
    Route::post('/storeRating', 'RatingController@storeRating');
    Route::post('/getRating', 'RatingController@getRating');

    // Follower
    Route::post('/storeFollower', 'FollowerController@storeFollower');
    Route::get('/getFollower/{companyId}', 'FollowerController@getFollower');

    // Profile
    Route::get('/userProfile/{id}', 'AuthController@userProfile');
    Route::post('/updateProfile', 'AuthController@updateProfile');
});


Route::post('/login', 'AuthController@login');
// Company Register
Route::post('/companyRegister', 'CompanyController@companyRegister');

// User Register
Route::post('/otpCreate', [RegisterController::class, 'createOtp']);
Route::post('/resendOtp', [RegisterController::class, 'createOtp']);
Route::post('/register', [RegisterController::class, 'registerUser']);




