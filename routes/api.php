<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function(){

    //*** Resources
    Route::resources([
        'category'  => 'CategoryController',
        'author'    => 'AuthorController',
        'book'      => 'BookController',
        'student'   => 'StudentController',
        'publishing-company' => 'PublishingCompanyController',
    ]);

    //*** Datatables
    Route::post('author-datatables', 'AuthorController@datatables');
    Route::post('publishing-company-datatables', 'PublishingCompanyController@datatables');
    Route::post('category-datatables', 'CategoryController@datatables');
    Route::post('student-datatables', 'StudentController@datatables');

});