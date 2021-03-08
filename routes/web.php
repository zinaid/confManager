<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TopicAreasController;
use App\Http\Controllers\MailSettingsController;
use App\Http\Controllers\PaperFileController;



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
    $paper_counter = DB::table('papers')->where('author', Auth::id())->count();
    return view('dashboard',  ['paper_counter' => $paper_counter]);
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', function () {
    $paper_counter = DB::table('papers')->where('author', Auth::id())->count();
    return view('dashboard',  ['paper_counter' => $paper_counter]);
})->middleware(['auth'])->name('dashboard');

Route::get('/submit', function () {
    $paper_counter = DB::table('papers')->where('author', Auth::id())->count();
    $conference = 1;
    $sections = DB::table('sections')->where('conference', $conference)->get();
    return view('submit', ['paper_counter' => $paper_counter, 'sections' => $sections, 'conference'=>$conference]);
})->middleware(['auth'])->name('submit');

# PROFILE ROUTES
Route::get('profile', [Profile::class, 'index'])->middleware('auth')->name('profile');

Route::post('/finish_registration', [Profile::class, 'finish_registration']);

Route::post('/update_profile', [Profile::class, 'update_profile'])->name('update_profile');

# PAPER ROUTES
Route::post('/paper_submission', [PaperController::class, 'store']);

Route::get('papers', [PaperController::class, 'index'])->middleware('auth')->name('papers');

Route::get('/papers/{id}', [PaperController::class, 'show'])->middleware('auth');

Route::post('/paper_upload', [PaperController::class, 'paper_upload'])->middleware('auth')->name('paper_upload');

Route::post('/add_paper_file_submit', [PaperController::class, 'add_paper_file']);

Route::post('/assign_editor', [PaperController::class, 'assign_editor']);

Route::post('/assign_editor_submit', [PaperController::class, 'assign_editor_submit']);

Route::post('/assign_reviewer', [PaperController::class, 'assign_reviewer']);

Route::post('/assign_reviewer_submit', [PaperController::class, 'assign_reviewer_submit']);

Route::post('/accept_review', [PaperController::class, 'accept_review']);

Route::post('/review', [PaperController::class, 'review']);

Route::post('/review_submission', [PaperController::class, 'review_submission']);

Route::post('/editor_decision', [PaperController::class, 'editor_decision']);

Route::post('/editor_decision_submit', [PaperController::class, 'editor_decision_submit']);

Route::get('/reviewer_response/{id}', [PaperController::class, 'reviewer_response']);


# SETTINGS ROUTES
Route::get('settings', [ConferenceController::class, 'index'])->middleware('auth')->name('settings');
Route::get('/conferences/{id}', [ConferenceController::class, 'show'])->middleware('auth');
Route::get('/deactivate_conference/{id}', [ConferenceController::class, 'deactivate_conference'])->middleware('auth');
Route::get('/activate_conference/{id}', [ConferenceController::class, 'activate_conference'])->middleware('auth');
Route::get('/add_conference', function () {
    return view('settings.add_conference');
})->middleware(['auth'])->name('add_conference');
Route::post('/add_conference_submit', [ConferenceController::class, 'store']);
Route::post('/update_conference/{id}', [ConferenceController::class, 'edit'])->middleware('auth');
#SECTIONS ROUTE
Route::get('/add_section/{id}', [SectionController::class, 'add_section'])->middleware('auth');
Route::post('/add_section_submit', [SectionController::class, 'store'])->middleware('auth');
Route::get('/view_sections/{id}', [SectionController::class, 'view_section'])->middleware('auth');
# TOPICS ROUTE
Route::get('/add_topic/{id}', [TopicAreasController::class, 'add_topic'])->middleware('auth');
Route::post('/add_topic_submit', [TopicAreasController::class, 'store'])->middleware('auth');
Route::get('/view_topics/{id}', [TopicAreasController::class, 'view_topic'])->middleware('auth');
# ADMINISTRATION ROUTES
Route::get('administration', [ConferenceController::class, 'index'])->middleware('auth')->name('administration');
Route::get('view_administration/{id}', [Profile::class, 'view_administration'])->middleware('auth')->name('view_administration');
Route::post('add_administration', [Profile::class, 'add_administration'])->middleware('auth')->name('add_administration');
Route::post('add_administration_submit', [Profile::class, 'add_administration_submit'])->middleware('auth')->name('add_administration_submit');
# MAIL ROUTES
Route::get('mail_settings', [ConferenceController::class, 'index'])->middleware('auth')->name('mail_settings');
Route::get('view_mail_settings/{id}', [MailSettingsController::class, 'view_mail_settings'])->middleware('auth')->name('view_mail_settings');
Route::post('add_mail_settings', [MailSettingsController::class, 'add_mail_settings'])->middleware('auth')->name('add_mail_settings');
Route::post('add_mail_settings_submit', [MailSettingsController::class, 'add_mail_settings_submit'])->middleware('auth')->name('add_mail_settings_submit');

#AJAX REQUESTS
Route::post('ajax/topics', [TopicAreasController::class, 'ajax_topics'])->name('ajax.topics');

#DOWNLOAD PDF
Route::post('download_pdf', [PaperFileController::class, 'download_pdf'])->middleware('auth')->name('download_pdf');

#DATATABLE ROUTE
Route::get('papers_list', [PaperController::class, 'getPapers'])->name('papers_list');

require __DIR__.'/auth.php';
