<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\IntrestController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RattingController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ExamQuestionController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\MockupController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::fallback(function(){
    return response()->json([
        'ResponseCode'  => 404,
        'status'        => False,
        'message'       => 'URL not found as you looking']);
});

Route::get('language_list', [LanguageController::class, 'language_list']);
Route::get('profession_list', [ProfessionController::class, 'profession_list']);
Route::get('intrest_list', [IntrestController::class, 'intrest_list']);

Route::post('create_account', [AuthController::class, 'create_account']);
Route::post('validate_account', [AuthController::class, 'validate_account']);
Route::post('login_account', [AuthController::class, 'login_account']);

Route::post('resend_otp', [AuthController::class, 'resend_otp']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    // SUBJECT LIST
    Route::get('subject_list', [SubjectController::class, 'subject_list']);

    // PROFILE ROUTES
    Route::resource('profile', UserController::class);
    Route::get('user_profile/{user_id}', [UserController::class, 'user_profile']);

    // POST ROUTES
    Route::resource('post', PostController::class);
    Route::get('post_details/{post_id}', [PostController::class, 'post_details']);
    Route::put('change_status_post/{post_id}', [PostController::class,'change_status']);

    // VIDEO ROUTES
    Route::resource('video', VideoController::class);
    Route::get('video_details/{video_id}', [VideoController::class,'video_details']);
    Route::put('change_status_video/{video_id}', [VideoController::class,'change_status']);

    // LIKE & DISLIKE ROUTES
    Route::resource('like', LikeController::class);
    Route::get('like_user/{post_id}/{post_type}', [LikeController::class, 'like_user_list']);

    // COMMENT ROUTES
    Route::resource('comment', CommentController::class);

    // RATTING ROUTES
    Route::resource('ratting', RattingController::class);

    // WALLET ROUTES
    Route::resource('wallet', WalletController::class);
    Route::post('wallet/send_gift', [WalletController::class, 'send_gift']);
    Route::post('withdraw_request', [WalletController::class, 'request_withdraw']);
    Route::get('transaction_history', [WalletController::class, 'transaction_history']);

    // EXAM ROUTE
    Route::get('exam_list', [ExamQuestionController::class, 'exam_list']);
    Route::post('save_result', [ExamQuestionController::class, 'insert_result']);

    // MOCKUP ROUTE
    Route::get('mockup_list', [MockupController::class, 'mockups_list']);

    // SCHOLARSHIP ROUTES
    Route::resource('scholarship', ScholarshipController::class)->only(['store']);

    // SUBSCRIPTION ROUTES
    Route::resource('subscription', SubscriptionController::class)->only(['store']);
    Route::post('payment_intent', [SubscriptionController::class, 'payment_intent']);

    // NOTIFICATION ROUTES
    Route::resource('notification', NotificationController::class)->only(['index','destroy']);

    // CONTACT ROUTES
    Route::resource('contact', ContactController::class)->only(['store']);
});
