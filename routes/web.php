<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/search', 'SearchController@getResults');
    Route::get('/profile/{username}', 'ProfileController@getProfile')->name('profile.show');
    Route::get('/profile/{username}/edit', 'ProfileController@editProfile')->name('profile.edit');
    Route::patch('/profile/{username}', 'ProfileController@updateProfile')->name('profile.update');
    Route::get('/friends', 'FriendController@getFriendIndex')->name('friend.index');
    Route::get('/friends/add/{username}', 'FriendController@getAddFriend')->name('friend.add');
    Route::get('/friends/accept/{username}', 'FriendController@getAcceptFriend')->name('friend.accept');
    Route::get('/friends/delete/{username}', 'FriendController@getDeleteFriend')->name('friend.delete');
    Route::post('/status', 'StatusController@postStatus')->name('status.post');
    Route::post('/status/{statusId}/reply', 'StatusController@postReply')->name('status.reply');
    Route::get('/status/{statusId}/like', 'StatusController@getLike')->name('status.like');
});
