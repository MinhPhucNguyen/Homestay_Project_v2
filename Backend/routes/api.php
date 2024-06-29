<?php

use App\Http\Controllers\Api\v2\RoomController;
use App\Http\Controllers\Api\v2\UserController as UserControllerApi;
use App\Http\Controllers\Api\v2\HomestayController;
use App\Http\Controllers\Api\v2\RoomTypeController;
use App\Http\Controllers\Api\v2\FacilityController;
use App\Http\Controllers\Api\v2\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PhoneVerificationController;
use App\Http\Controllers\Mail\MailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/login', 'login')->name('login');
    Route::middleware('auth:api')->get('/user', 'getUserInfo');
    Route::post('/auth/register', 'register');
    Route::middleware('auth:api')->post('/logout', 'logout');
});
Route::get('/email-verification', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::get('/phone-verification', [PhoneVerificationController::class, 'verify']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
Route::get('/authorize/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);


Route::prefix('v2')->group(function () {

    Route::post('users/{id}/change-password', [UserControllerApi::class, 'changePassword']);

    Route::prefix('admin')->group(function () {

        Route::controller(UserControllerApi::class)->group(function () {
            Route::get('users', 'index');
            Route::get('users/all', 'selectAllUser');
            Route::get('users/{id}', 'getUserById');
            Route::post('users/create', 'createUser');
            Route::put('users/{id}/edit', 'editUser');
            Route::delete('users/{id}/delete', 'deleteUser');
            Route::delete('users/delete-multi-user/{users}', 'deleteMultiUser');
        });

        Route::delete('users/{id}/remove-avatar', [ProfileController::class, 'removeAvatar']);

    });

    Route::controller(HomestayController::class)->group(function () {
        Route::get('homestays', 'index');
        Route::get('homestays/all', 'getAllHomestayToSelect');
        Route::get('homestays/getBySlug/{slug}', 'getHomestayBySlug');
        Route::get('homestays/{id}', 'show');
        Route::post('homestays/create', 'store');
        Route::get('homestays/{id}/edit', 'edit');
        Route::post('homestays/{id}/update', 'update');
        Route::delete('homestays/{id}/delete', 'destroy');
    });

    Route::controller(RoomController::class)->group(function () {
        Route::get('rooms', 'index');
        Route::get('rooms/getByHomestay/{homestayId}', 'getRoomsListByHomestayId');
        Route::post('rooms/create', 'store');
        Route::get('rooms/{id}/edit', 'edit');
        Route::post('rooms/{id}/update', 'update');
        Route::delete('rooms/{id}/delete', 'destroy');
        Route::delete('rooms/image/delete/{publicId}', 'deleteImageCloud');
    });

    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('room-types', 'index');
        Route::get('room-types/getByHomestay/{homeStayId}', 'getRoomTypeByHomestayId');
        Route::post('room-types/create', 'store');
        Route::put('room-types/{id}/edit', 'update');
        Route::delete('room-types/{id}/delete', 'destroy');
    });

    Route::controller(FacilityController::class)->group(function () {
        Route::get('facilities', 'index');
        Route::get('facilities/all', 'getAllFacilities');
        Route::post('facilities/create', 'store');
        Route::put('facilities/{id}/edit', 'update');
        Route::delete('facilities/{id}/delete', 'destroy');
    });

});
