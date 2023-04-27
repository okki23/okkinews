<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
 
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/details/{id}',[HomeController::class,'details'])->name('detail');
Route::get('/signin',[HomeController::class,'signin'])->name('signin');
Route::post('/regis_new',[HomeController::class,'regis_new'])->name('regis_new');
Route::post('/authentication',[HomeController::class,'authentication'])->name('authentication');
Route::get('/keluar',[HomeController::class,'keluar'])->name('keluar');

Route::get('/mypost',[PostController::class,'mypost'])->name('mypost')->middleware('auth');
Route::post('/savepost',[PostController::class,'savepost'])->name('savepost');
Route::post('/post_destroy',[PostController::class,'destroy'])->name('post_destroy');
Route::get('/post_list',[PostController::class,'datalist'])->name('post_list');
Route::post('/post_get_data',[PostController::class,'get_data'])->name('post_get_data');
Route::post('/comment',[PostController::class,'comment'])->name('comment');
Route::post('/get_comment',[PostController::class,'get_comment'])->name('get_comment');
Route::post('/update_comment',[PostController::class,'update_comment'])->name('update_comment');
Route::get('/delete_comment/{id}',[PostController::class,'delete_comment'])->name('delete_comment');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
