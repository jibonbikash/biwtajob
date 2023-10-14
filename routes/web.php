<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\ExamLevelController;
use App\Http\Controllers\Admin\ExamLevelGroupController;
use App\Http\Controllers\Admin\ExamLevelGroupSubjectController;
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
Route::get('applicant/edit/{uuid}', [HomeController::class, 'applicantPreviewEdit'])->name('applicantPreviewEdit');
Route::post('applicant/edit/{uuid}', [HomeController::class, 'applicantPreviewConfirm'])->name('applicantPreviewConfirm');
Route::post('applicantion/confirm/{uuid}', [HomeController::class, 'applicantConfirm'])->name('applicantConfirm');
Route::get('applicantion/{uuid}', [HomeController::class, 'applicationPrint'])->name('applicationPrint');
Route::get('/university', [HomeController::class, 'university'])->name('university');
Route::get('/printCopy', [HomeController::class, 'PrintCopy'])->name('PrintCopy');
Route::get('/writtenCopy', [HomeController::class, 'writtenCopy'])->name('writtenCopy');
Route::get('/vivaCopy', [HomeController::class, 'vivaCopy'])->name('vivaCopy');
Route::get('/practicalCopy', [HomeController::class, 'practicalCopy'])->name('practicalCopy');
Route::get('/medicalCopy', [HomeController::class, 'medicalCopy'])->name('medicalCopy');
Route::post('/ageCalculation', [HomeController::class, 'ageCalculation'])->name('ageCalculation');
Route::post('/applyAgeCalculation', [HomeController::class, 'applyAgeCalculation'])->name('applyAgeCalculation');
//Route::get('applicantion/printcopy', [HomeController::class, 'printcopy'])->name('printcopy');



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
    Route::get('/jobs/setting/{uuid}', [JobsController::class, 'setting'])->name('jobs.setting');
    Route::post('/jobs/setting/{uuid}', [JobsController::class, 'settingSave'])->name('jobs.settingsave');
    Route::post('ckeditor/upload', [JobsController::class, 'imageupload'])->name('ckeditor.upload');
    Route::get('/applicants', [JobsController::class, 'applicants'])->name('applicants');
    Route::get('/roll-setting', [JobsController::class, 'rollSetting'])->name('rollSetting');
    Route::post('/roll-setting', [JobsController::class, 'rollSettingconfigure'])->name('rollSettingconfigure');
    Route::get('/seat-plan', [JobsController::class, 'seatPlan'])->name('seatPlan');
    Route::post('/seat-plan', [JobsController::class, 'seatPlansetting'])->name('seatPlansetting');
    Route::post('/seat-planroll', [JobsController::class, 'seatPlansettingRoll'])->name('seatPlansettingRoll');

    Route::get('/education', [JobsController::class, 'educationtype'])->name('educationtype');
    Route::resource('examlevels', ExamLevelController::class);
    Route::get('examlevels/group/add/{id}', [ExamLevelController::class, 'groupadd'])->name('examlevels.groupadd');
    Route::post('examlevels/group/add/{id}', [ExamLevelController::class, 'groupaddsave'])->name('examlevels.groupaddsave');
    Route::resource('examlevelgroups', ExamLevelGroupController::class);
    Route::resource('examlevelgroupsubjects', ExamLevelGroupSubjectController::class);
    Route::get('examgroup', [ExamLevelGroupController::class,'examgroup'])->name('examgroup');
    Route::post('examsubject', [JobsController::class, 'examsubject'])->name('examlevels.examsubject');
    Route::get('print/{id}', [JobsController::class,'printCopy'])->name('print');
    Route::get('adminCard/{id}', [JobsController::class,'adminCard'])->name('adminCard');
    Route::get('certificateslist', [JobsController::class,'certificateslist'])->name('admin.certificateslist');


    Route::get('/file-import',[ExamLevelGroupController::class,'importView'])->name('import-view');
    Route::post('/importExamLevelGroup',[ExamLevelGroupController::class,'import'])->name('importExamLevelGroup');

    Route::get('/import-subject',[ExamLevelGroupSubjectController::class,'importView'])->name('import-subject');
    Route::post('/importsubject',[ExamLevelGroupSubjectController::class,'import'])->name('importsubject');
    Route::get('/applicants/export', [JobsController::class, 'exportApplicants'])->name('exportApplicants');

    Route::get('/applicants/viva', [\App\Http\Controllers\Admin\VivaController::class, 'index'])->name('ApplicantViva');
    Route::post('/applicants/viva/import', [\App\Http\Controllers\Admin\VivaController::class, 'import'])->name('ApplicantVivaimport');
    Route::get('/applicants/viva/export', [\App\Http\Controllers\Admin\VivaController::class, 'exportApplicants'])->name('ApplicantVivaexport');

    Route::get('/applicants/medical', [\App\Http\Controllers\Admin\MedicalsController::class, 'index'])->name('Applicantmedical');
    Route::post('/applicants/medical/import', [\App\Http\Controllers\Admin\MedicalsController::class, 'import'])->name('Applicantmedicalimport');
    Route::get('/applicants/medical/export', [\App\Http\Controllers\Admin\MedicalsController::class, 'export'])->name('Applicantmedicalexport');

    Route::get('/applicants/practical', [\App\Http\Controllers\Admin\PracticalController::class, 'index'])->name('Applicantpractical');
    Route::post('/applicants/practical/import', [\App\Http\Controllers\Admin\PracticalController::class, 'import'])->name('ApplicantpracticalImport');
    Route::get('/applicants/practical/export', [\App\Http\Controllers\Admin\PracticalController::class, 'export'])->name('Applicantpracticalexport');

});
