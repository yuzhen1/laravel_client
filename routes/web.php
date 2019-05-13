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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/md/curl','MdController@curl');
Route::post('/md/kai_encode','MdController@kai_encode');//凯撒加密
Route::post('/md/opssl_encode','MdController@opssl_encode');//openssl加密
Route::post('/md/private_encode','MdController@private_encode');//非对称性加密    私钥加密
Route::post('/md/male_encode','MdController@male_encode');//非对称性加密    公钥加密
Route::post('/md/signature','MdController@signature');   //验签