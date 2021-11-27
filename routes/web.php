<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamQuestionController;
use App\Http\Controllers\IntrestController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MockupController;
use App\Http\Controllers\MockupExamQuestionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostAdController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WalletController;

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

/*Route::get('/', function () {
	return view('welcome');
});*/
// ADMIN LOGIN, FORGOT PASSWORD ROUTE
Route::get('control_panel', [AuthController::class, 'login_index'])->name('control_panel');
Route::post('login', [AuthController::class, 'login_user'])->name('admin.login');

Route::group(['middleware' => 'prevent-back-history'], function() {

	Route::group(['prefix' => 'control_panel'], function () {

		// DASHBOARD & LOGOUT ROUTES
		Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['admin']);
		Route::get('logout', [DashboardController::class, 'logout_admin'])->name('admin.logout')->middleware(['admin']);

		// USERS ROUTES
		Route::resource('users', UserController::class)->middleware(['admin']);
		Route::get('users/profile/{user_id}', [UserController::class, 'profileView'])->name('users.profile')->middleware(['admin']);
		Route::get('admin/{admin_id}/edit', [AuthController::class, 'admin_edit'])->name('admin.edit')->middleware(['admin']);
		Route::any('admin/update/{admin_id}', [AuthController::class, 'admin_update'])->name('admin.update')->middleware(['admin']);
		
		// POSTS & VIDEOS & COMMENTS ROUTES
		Route::get('users/post_edit/{post_id}', [PostController::class, 'postEdit'])->name('posts.edit')->middleware(['admin']);
		Route::get('post_list/{user_id?}', [PostController::class, 'getPostsList'])->name('posts.list')->middleware(['admin']);
		Route::get('post_view/{post_id}', [PostController::class, 'postView'])->name('posts.view')->middleware(['admin']);
		Route::post('post_admin_status_update', [PostController::class, 'postAdminStatusUpdate'])->name('posts.admin_status_update')->middleware(['admin']);
		Route::post('post_comment_update/{comment_id}', [CommentController::class, 'commentUpdate'])->name('posts.comment_update')->middleware(['admin']);
		Route::get('post_comment_delete/{comment_id}', [CommentController::class, 'commentDelete'])->name('posts.comment_delete')->middleware(['admin']);
		Route::get('video_list/{user_id?}', [VideoController::class, 'getVideosList'])->name('videos.list')->middleware(['admin']);
		Route::get('video_post_view/{video_id}', [VideoController::class, 'videoPostView'])->name('videos.view')->middleware(['admin']);
		Route::post('video_post_admin_status_update', [VideoController::class, 'videoPostAdminStatusUpdate'])->name('videos.admin_status_update')->middleware(['admin']);
		
		// POST ADS ROUTES
		Route::resource('post_ads', PostAdController::class)->middleware(['admin']);

		// EXAM QUESTIONS ROUTES
		Route::resource('exam_questions', ExamQuestionController::class)->middleware(['admin']);
		Route::get('exam_questions_result/{exam_head_id}', [ExamQuestionController::class, 'getResultList'])->name('exam_questions.result')->middleware(['admin']);
		Route::post('delete', [ExamQuestionController::class, 'delete'])->name('exam_questions.delete')->middleware(['admin']);
		Route::get('exam_questions_bulk_upload', [ExamQuestionController::class, 'getBulkUpload'])->name('exam_questions.getBulkUpload')->middleware(['admin']);
		Route::post('exam_questions_bulk_upload', [ExamQuestionController::class, 'bulkUpload'])->name('exam_questions.bulkUpload')->middleware(['admin']);
		
		// MOCKUP EXAMS ROUTES
		Route::resource('mockup', MockupController::class)->middleware(['admin']);
		Route::resource('mockup_exam_questions', MockupExamQuestionController::class)->middleware(['admin']);
		Route::post('mockup_exam_questions_delete', [MockupExamQuestionController::class, 'delete'])->name('mockup_exam_questions.delete')->middleware(['admin']);
		Route::get('mockup_exam_questions_bulk_upload', [MockupExamQuestionController::class, 'getBulkUpload'])->name('mockup_exam_questions.getBulkUpload')->middleware(['admin']);
		Route::post('mockup_exam_questions_bulk_upload', [MockupExamQuestionController::class, 'bulkUpload'])->name('mockup_exam_questions.bulkUpload')->middleware(['admin']);

		// SUBSCRIPTION ROUTES
		Route::resource('subscription', SubscriptionController::class)->middleware(['admin']);

		// SCHOLARSHIP ROUTES
		Route::resource('scholarship', ScholarshipController::class)->middleware(['admin']);
		Route::post('scholarship_admin_status_update', [ScholarshipController::class, 'scholarshipAdminStatusUpdate'])->name('scholarship.admin_status_update')->middleware(['admin']);
		
		// WALLET & WITHDRAW ROUTES
		Route::resource('wallet', WalletController::class)->middleware(['admin']);
		Route::get('withdraw', [WalletController::class, 'withdraw_list'])->name('withdraw.list')->middleware(['admin']);
		Route::post('withdraw_admin_status_update', [WalletController::class, 'withdrawAdminStatusUpdate'])->name('withdraw.admin_status_update')->middleware(['admin']);

		// CONTACT ROUTES
		Route::resource('contact', ContactController::class)->middleware(['admin']);

		// INTREST ROUTES
		Route::resource('intrest', IntrestController::class)->middleware(['admin']);

		// LANGUAGE ROUTES
		Route::resource('language', LanguageController::class)->middleware(['admin']);

		// SUBJECT ROUTES
		Route::resource('subject', SubjectController::class)->middleware(['admin']);

		// PROFESSION ROUTES
		Route::resource('profession', ProfessionController::class)->middleware(['admin']);

		// PAGES ROUTES
		Route::resource('pages', PageController::class)->middleware(['admin']);

	});
});

Route::get('/', [DashboardController::class, 'homePage'])->name('home');
//front static page route
Route::get('{slug_url}', [PageController::class, 'staticPage'])->name('staticPage');
