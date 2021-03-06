<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/auth/login', 'AuthControler@login');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::resource('/departments', 'DepartmentController')
            ->except(['edit', 'create']);

        Route::post('/departments/{department}/logo', 'DepartmentController@logo');

        Route::resource('/departments/{department}/programs', 'ProgramController')
            ->except(['edit', 'create']);

        Route::resource('/programs/{program}/curricula', 'CurriculumController')
            ->except(['edit', 'create']);


        Route::resource('/semesters/{semester}/courses', 'SemesterCourseController');
    });
});
