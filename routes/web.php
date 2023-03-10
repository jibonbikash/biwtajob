<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\HomeController;

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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('jobs/{uuid}', [HomeController::class, 'details'])->name('details');
Route::get('jobs/apply/{uuid}', [HomeController::class, 'applyform'])->name('applyform');
Route::get('exam/subject', [HomeController::class, 'examSubject'])->name('examSubject');
Route::post('jobApply', [HomeController::class, 'jobApply'])->name('jobApply');
Route::get('applicant/preview/{uuid}', [HomeController::class, 'applicantPreview'])->name('applicantPreview');


Auth::routes([
    'register' => false, // Registration Routes...
  //  'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);


Route::group(['middleware' => ['auth'], "prefix" => "admin"], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/password-change', [DashboardController::class, 'password'])->name('password_change');
    Route::post('/password-change', [DashboardController::class, 'passwordchange'])->name('admin.changeed_password');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('jobs', JobsController::class);
    Route::post('ckeditor/upload', [JobsController::class, 'imageupload'])->name('ckeditor.upload');
    Route::get('/applicants', [JobsController::class, 'applicants'])->name('applicants');
    Route::get('/roll-setting', [JobsController::class, 'rollSetting'])->name('rollSetting');
    Route::get('/seat-plan', [JobsController::class, 'seatPlan'])->name('seatPlan');
    Route::get('/education', [JobsController::class, 'educationtype'])->name('educationtype');

});
