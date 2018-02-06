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

//Route::group(['prefix' => 'v4'], function (){
//    Route::resource('lesson', 'LessonController');
//});

//dingo api router
$api = app('Dingo\Api\Routing\Router');

$api->version('v4', function($api){
    $api->group(['namespace' => 'App\Api\Controllers'], function ($api){
        //auth
        $api->post('/user/login', 'AuthController@authenticate');
        $api->post('/user/register', 'AuthController@register');

        //api base need jwt auth
        $api->group(['middleware' => 'jwt.auth'], function($api){
            $api->get('lesson', 'LessonController@index');
            $api->get('lesson/{lesson}', 'LessonController@show');
            $api->get('/user/me', 'AuthController@getAuthenticatedUser');
        });

    });
});


$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array',
], function ($api) {
    // 获取 token
    $api->post('authorizations', 'AuthorizationController@store')
        ->name('api.authorizations.store');
    // 刷新 token
    $api->put('authorizations/current', 'AuthorizationController@update')
        ->name('api.authorizations.update');
    // 注销token
    $api->delete('authorizations/current', 'AuthorizationController@destroy')
        ->name('api.authorizations.destroy');
    $api->group(['middleware' => 'api.auth'], function ($api) {
        //  当前用户信息
        $api->get('user', 'UserController@userShow')->name('api.user.show');
        $api->get('users', 'UserController@index')->name('api.users.index');
        $api->get('users/{id}', 'UserController@show')->name('api.users.show');
    });
});