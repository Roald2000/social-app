<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\PostModel;
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

Route::get('/', function () {

    $posts = PostModel::orderBy('created_at', 'desc')->get();
    return view('welcome', compact('posts'));
})->name('welcome');


Route::get('/login', [UserController::class, 'viewLogin'])->name('view.login');
Route::get('/register', [UserController::class, 'viewRegister'])->name('view.register');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/login', [UserController::class, 'login'])->name('post.login');
Route::post('/register', [UserController::class, 'register'])->name('post.register');


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::get('/profile/{id}', [ProfileController::class, 'seeProfile'])->name('user.see-profile');
    Route::post('/profile', [ProfileController::class, 'saveProfile'])->name('user.save-profile');
    Route::get('/delete/profile/{profile_id}', [ProfileController::class, 'deleteProfile'])->name('user.delete-profile');


    Route::post('/create-post', [PostController::class, 'create_post'])->name('create.post');
});
