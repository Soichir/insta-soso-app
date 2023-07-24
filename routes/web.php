<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\BlockController;
use Illuminate\Support\Facades\Auth;

#Admin
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;



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

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index'); //homepage
    Route::get('people', [HomeController::class, 'search'])->name('search');

    //post
    Route::group(['prefix' => 'post', 'as' => 'post.'], function(){
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');

    });

    //comment
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function(){
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });

    //profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('{id}/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update',[ProfileController::class, 'update'])->name('update');
        Route::get('/{id}/followers',[ProfileController::class, 'followers'])->name('followers');
        Route::get('/{id}/following',[ProfileController::class, 'following'])->name('following');
    });
    //like
    Route::group(['prefix' => 'like', 'as' => 'like.'], function(){
        Route::post('/{post_id}/store', [LikeController::class, 'store'])->name('store');
        Route::delete('/{post_id}/destroy', [LikeController::class, 'destroy'])->name('destroy');
    });
    //follow
    Route::group(['prefix' => 'follow', 'as' => 'follow.'], function(){
        Route::post('/{user_id}/store', [FollowController::class, 'store'])->name('store');
        Route::delete('/{user_id}/destroy', [FollowController::class, 'destroy'])->name('destroy');
        
    });
    //block
    Route::group(['prefix' => 'block', 'as' => 'block.'], function(){
        Route::post('/{user_id}/store', [BlockController::class, 'store'])->name('store');
        Route::delete('/{user_id}/destroy', [BlockController::class, 'destroy'])->name('destroy');
    });

    //Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        #Admin Users
        Route::get('/users', [UsersController::class, 'index'])->name('users'); //admin.users
        Route::get('/posts', [PostsController::class, 'index'])->name('posts');
        Route::delete('/{id}/destroy', [PostsController::class, 'destroy'])->name('posts.destroy');
        Route::patch('/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');
        Route::delete('user/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('user/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/create', [CategoriesController::class, 'create'])->name('create');
        Route::delete('{id}/destroy',[CategoriesController::class, 'destroy'])->name('categories.destroy');
    });



});

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
