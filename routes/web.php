<?php

use App\Http\Controllers\Test;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\ControllerClearCache;
use App\Http\Middleware\SharedView\SharedViewLanguagesMiddleware;
use App\Http\Middleware\SharedView\SharedViewModuleMiddleware;
use App\Http\Middleware\SharedView\SharedViewModulesMiddleware;


use Modules\Activities\Http\Controllers\ActivitiesController;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Middleware\AuthMiddleware;

use Modules\Calendar\Http\Controllers\CalendarController;
use Modules\Countries\Http\Controllers\CountriesController;
use Modules\Languages\Http\Middleware\LanguageMiddleware;

use Modules\Main\Http\Controllers\MainController;

use Modules\Modules\Http\Middleware\ModulesPrivilegesMiddleware;
use Modules\Projects\Http\Controllers\ProjectsController;
use Modules\Public\Http\Controllers\PublicController;

use Modules\Record\Http\Controllers\RecordController;
use Modules\Record\Http\Middleware\RecordRerouteMiddleware;
use Modules\Record\Http\Middleware\RecordUnauthorizedMiddleware;

use Modules\Records\Http\Controllers\RecordsController;
use Modules\Records\Http\Middleware\RecordsRerouteMiddleware;
use Modules\Records\Http\Middleware\RecordsUnauthorizedMiddleware;
use Modules\Reports\Http\Controllers\ReportsController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Middleware\UserRerouteMiddleware;
use Modules\User\Http\Middleware\UserUnauthorizedMiddleware;

use Modules\Users\Http\Controllers\UsersController;

//Route::get('/test', [Test::class, 'test']);
///////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/clear', [ControllerClearCache::class, 'clear']);
Route::get('/cache', [ControllerClearCache::class, 'cache']);
///////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    $lang = App::getLocale();
    //dd('public/'.$lang);
    return redirect('/admin');
});
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Route::get('index', [PublicController::class, 'index']);
//Route::post('register', [PublicController::class, 'register']);
//Route::get('records/{id_menu}/{slug_menu}', [PublicController::class, 'records']);
//Route::get('{lang}/record/{id_menu}/{slug_menu}', [PublicController::class, 'record']);
Route::get('test', [PublicController::class, 'test']);
///////////////////////////////////////////////////////////////////////////////////////////////////////

Route::middleware([LanguageMiddleware::class])->group(function () {

    //Module AUTH
    Route::get('/admin', [AuthController::class, 'login'])->name('admin');
    Route::match(['get', 'post'],'login-post', [AuthController::class, 'loginPost']);
    Route::get('forgotten-email', [AuthController::class, 'forgottenEmail']);
    Route::post('forgotten-email-post', [AuthController::class, 'forgottenEmailPost']);
    Route::get('forgotten', [AuthController::class, 'forgotten']);
    Route::post('forgotten-post', [AuthController::class, 'forgottenPost']);
    Route::get('expired', [AuthController::class, 'expired'])->name('expired');
    Route::post('expired-post', [AuthController::class, 'expiredPost']);
    Route::get('registration', [AuthController::class, 'registration'])->name('registration');
    Route::post('registration-post', [AuthController::class, 'registrationPost']);
    Route::get('mfa-code', [AuthController::class, 'mfaCode'])->name('mfa-code');
    Route::post('mfa-code-post', [AuthController::class, 'mfaCodePost']);
    Route::get('mfa', [AuthController::class, 'mfa'])->name('mfa');
    Route::post('mfa-post', [AuthController::class, 'mfaPost']);


    Route::middleware([AuthMiddleware::class])->group(function () {

        //Module AUTH
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('browser', [RecordController::class, 'browser']);

        Route::middleware([SharedViewLanguagesMiddleware::class, SharedViewModulesMiddleware::class])->group(function () {
            Route::get('admin/{lang}/main', [MainController::class, 'index'])->name('main');

        });

        //CHECK IF USER HAVE PRIVILEGES TO MODULE
        //====================================================================================================
        Route::middleware([ModulesPrivilegesMiddleware::class])->group(function () {


            Route::middleware([SharedViewLanguagesMiddleware::class, SharedViewModulesMiddleware::class, SharedViewModuleMiddleware::class])
                ->prefix('admin/{lang}/{id_module}')
                ->group(function () {

                    //MODULE USERS
                    Route::prefix('users')
                        ->group(function () {
                            Route::get('/', [UsersController::class, 'index'])->name('users.index');
                            Route::get('edit/{id}', [UsersController::class, 'edit']);
                            Route::put('update/{id}', [UsersController::class, 'update']);
                            Route::get('create', [UsersController::class, 'create']);
                            Route::put('store', [UsersController::class, 'store']);
                            Route::get('show/{id}', [UsersController::class, 'show']);
                            Route::delete('delete/{id}', [UsersController::class, 'destroy']);
                            Route::post('send-email-reg/{id}', [UsersController::class, 'sendEmailReg']);

                            Route::get('index-records/{id}', [UsersController::class, 'indexRecords']);
                            Route::get('create-record/{year}/{id}', [UsersController::class, 'createRecord']);
                            Route::post('store-record/{id}', [UsersController::class, 'storeRecord']);
                            Route::get('edit-record/{year}/{id_record}/{id}', [UsersController::class, 'editRecord']);
                            Route::post('update-record/{id_record}/{id}', [UsersController::class, 'updateRecord']);
                            Route::get('show-record/{id_record}', [UsersController::class, 'showRecord']);
                            Route::delete('delete-record/{id_record}/{id}', [UsersController::class, 'deleteRecord']);

                            Route::post('lock-approve/{id}', [UsersController::class, 'lockApproveRecords']);
                            Route::get('get-activities/{id_project}/{id}', [UsersController::class, 'getActivities']);
                            Route::get('get-assignments/{id_project}/{id}', [UsersController::class, 'getAssignments']);

                            Route::post('add/{id_user}/{id_group}', [UsersController::class, 'addGroupToUser']);
                            Route::post('remove/{id_user}/{id_group}', [UsersController::class, 'removeGroupToUser']);
                        });

                    //MODULE USER
                    Route::prefix('user')
                        ->group(function () {
                            Route::middleware([UserRerouteMiddleware::class])->group(function () {
                                Route::get('edit')->name('edit');
                            });
                            Route::middleware([UserUnauthorizedMiddleware::class])->group(function () {
                                Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit.user');
                                Route::put('update/{id}', [UserController::class, 'update']);
                            });

                        });
                    //.MODULE USER

                    //MODULE RECORD
                    Route::prefix('record')
                        ->group(function () {
                            Route::middleware([RecordRerouteMiddleware::class])->group(function () {
                                Route::get('edit')->name('edit');
                            });
                            Route::middleware([RecordUnauthorizedMiddleware::class])->group(function () {
                                Route::get('edit/{id}', [RecordController::class, 'edit'])->name('edit.record');
                                Route::put('update/{id}', [RecordController::class, 'update']);
                                Route::put('store_doc/{id}', [RecordController::class, 'storeDoc']);
                                Route::put('update_doc/{id}/{id_doc}',  [RecordController::class, 'updateDoc']);
                                Route::get('show_doc/{id}/{id_doc}',  [RecordController::class, 'showDoc']);
                                Route::delete('delete_doc/{id}/{id_doc}',  [RecordController::class, 'deleteDoc']);
                            });
                        });
                    //.MODULE RECORD

                    //MODULE PROJECTS
                    Route::prefix('projects')
                        ->group(function () {
                            Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
                            Route::get('edit/{id}', [ProjectsController::class, 'edit']);
                            Route::put('update/{id}', [ProjectsController::class, 'update']);
                            Route::get('create', [ProjectsController::class, 'create']);
                            Route::put('store', [ProjectsController::class, 'store']);
                            Route::get('show/{id}', [ProjectsController::class, 'show']);
                            Route::delete('delete/{id}', [ProjectsController::class, 'destroy']);

                            Route::get('show_assign/{id}', [ProjectsController::class, 'showAssignment']);
                            Route::get('edit_assign/{id}/{id_assign}', [ProjectsController::class, 'editAssignment']);
                            Route::put('update_assign/{id}', [ProjectsController::class, 'updateAssignment']);
                            Route::get('create_assign/{id}', [ProjectsController::class, 'createAssignment']);
                            Route::put('store_assign/{id}', [ProjectsController::class, 'storeAssignment']);
                            Route::delete('delete_assign/{id}',  [ProjectsController::class, 'deleteAssignment']);
                        });
                    //.MODULE PROJECTS

                    //MODULE ACTIVITIES
                    Route::prefix('activities')
                        ->group(function () {
                            Route::get('/', [ActivitiesController::class, 'index'])->name('activities.index');
                            Route::get('edit/{id}', [ActivitiesController::class, 'edit']);
                            Route::put('update/{id}', [ActivitiesController::class, 'update']);
                            Route::get('create', [ActivitiesController::class, 'create']);
                            Route::put('store', [ActivitiesController::class, 'store']);
                            Route::get('show/{id}', [ActivitiesController::class, 'show']);
                            Route::delete('delete/{id}', [ActivitiesController::class, 'destroy']);
                        });
                    //.MODULE ACTIVITIES

                    //MODULE COUNTRIES
                    Route::prefix('countries')
                        ->group(function () {
                            Route::get('/', [CountriesController::class, 'index'])->name('countries.index');
                            Route::get('edit/{id}', [CountriesController::class, 'edit']);
                            Route::put('update/{id}', [CountriesController::class, 'update']);
                            Route::get('create', [CountriesController::class, 'create']);
                            Route::put('store', [CountriesController::class, 'store']);
                            Route::get('show/{id}', [CountriesController::class, 'show']);
                            Route::delete('delete/{id}', [CountriesController::class, 'destroy']);
                        });
                    //.MODULE COUNTRIES

                    //MODULE CALENDAR
                    Route::prefix('calendar')
                        ->group(function () {
                            Route::get('/', [CalendarController::class, 'index'])->name('calendar.index');
                            Route::post('new-year/{year}', [CalendarController::class, 'newYear']);
                            Route::post('insert-holiday', [CalendarController::class, 'insertHolidays']);
                            Route::delete('delete/{year}', [CalendarController::class, 'delete']);
                        });
                    //.MODULE CALENDAR

                    //MODULE RECORDS
                    Route::prefix('records')
                        ->group(function () {
                            Route::middleware([RecordsRerouteMiddleware::class])->group(function () {
                                Route::get('/');
                            });
                            Route::middleware([RecordsUnauthorizedMiddleware::class])->group(function () {

                                Route::get('{id}', [RecordsController::class, 'index'])->name('records');

                                Route::delete('delete-record/{id_record}/{id}', [RecordsController::class, 'deleteRecord']);
                                Route::match(['get', 'post'],'update-records-week/{id}', [RecordsController::class, 'updateRecordsWeek']);

                                Route::get('edit-record-day/{date}/{id_country}/{id}', [RecordsController::class, 'editRecordDay']);
                                Route::match(['get', 'post'],'store-record-day/{id}', [RecordsController::class, 'storeRecordDay']);
                                Route::match(['get', 'post'],'update-record-day/{id_record}/{id}', [RecordsController::class, 'updateRecordDay']);

                                Route::match(['get', 'post'],'refresh-index/{id}', [RecordsController::class, 'refreshIndex'])->name('refresh-index');

                                Route::match(['get', 'post'],'store-records-week/{id}', [RecordsController::class, 'storeRecordsWeek']);
                                Route::delete('delete-records-week/{id_record}/{id}', [RecordsController::class, 'deleteRecordsWeek']);
                                Route::get('edit-records-week/{date}/{id_country}/{id}', [RecordsController::class, 'editRecordsWeek']);
                                Route::delete('delete-records-day/{date}/{id_country}/{id}', [RecordsController::class, 'deleteRecordsDay']);
                                Route::delete('delete-records-week/{date}/{id_country}/{id}', [RecordsController::class, 'deleteRecordsWeek']);
                                Route::get('show-records-day/{date}/{id_country}/{id}', [RecordsController::class, 'showRecordsDay']);
                                Route::get('show-records-day-list/{date}/{id_country}/{id}', [RecordsController::class, 'showRecordsDayList']);
                                Route::get('show-records-week/{date}/{id_country}/{id}', [RecordsController::class, 'showRecordsWeek']);
                                Route::get('show-records-week-list/{date}/{id_country}/{id}', [RecordsController::class, 'showRecordsWeekList']);

                                Route::get('index-records-table/{id}', [RecordsController::class, 'indexRecordsTable']);
                                Route::get('create-record-table/{year}/{id}', [RecordsController::class, 'createRecordTable']);
                                Route::post('store-record-table/{id}', [RecordsController::class, 'storeRecordTable']);
                                Route::get('edit-record-table/{year}/{id_record}/{id}', [RecordsController::class, 'editRecordTable']);
                                Route::post('update-record-table/{id_record}/{id}', [RecordsController::class, 'updateRecordTable']);
                                Route::get('show-record-table/{id_record}/{id}', [RecordsController::class, 'showRecordTable']);
                                Route::delete('delete-record-table/{id_record}/{id}', [RecordsController::class, 'deleteRecordTable']);


                                Route::get('get-activities/{id_project}/{id}', [RecordsController::class, 'getActivities']);
                                Route::get('get-assignments/{id_project}/{id}', [RecordsController::class, 'getAssignments']);


                            });

                        });
                    //.MODULE RECORDS
                    //MODULE REPORTS
                    Route::prefix('reports')
                        ->group(function () {
                            Route::get('/', [ReportsController::class, 'index'])->name('reports.index');
                            Route::get('/export-excel-detail', [ReportsController::class, 'exportExcelDetail']);
                            Route::get('/export-excel-group', [ReportsController::class, 'exportExcelGroup']);
                            Route::get('/export-pdf-detail', [ReportsController::class, 'exportPdfDetail']);
                            Route::get('/export-pdf-group', [ReportsController::class, 'exportPdfGroup']);
                        });
                    //.MODULE REPORTS
                });
        });
        //====================================================================================================
    });
});
