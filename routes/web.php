<?php

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

//主页
route::any('/',"IndexController@index");
//路由组
Route::prefix('/')->group(function(){
    route::any('userpage','IndexController@userpage')->middleware('logs');
    route::any('shopcart','IndexController@shopcart')->middleware('logs');
    route::any('indexshop/{id?}','IndexController@indexshop');
    route::any('allshops','IndexController@allshops');
    route::any('shopcontent/{id?}','IndexController@shopcontent');
    route::post('cateshop','IndexController@cateshop');
    route::post('priceadd','IndexController@priceadd');
    route::post('sortshop','IndexController@sortshop');
    route::post('cartdel','IndexController@cartdel');
    route::any('addCart','IndexController@addCart');
    route::post('cartdels','IndexController@cartdels');
    
});
/**登陆注册路由 */
Route::prefix('/')->group(function(){
    route::any('login','UserController@login');
    route::any('register','UserController@register');
    route::any('resetpassword','UserController@resetpassword');
    route::post('login_do','UserController@login_do');
    route::any('create','UserController@create');
    route::post('registerDo','UserController@registerDo');
    route::post('sendMobile','UserController@sendMobile');
 
});

