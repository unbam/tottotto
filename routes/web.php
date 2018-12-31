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

// 認証
// vendor/laravel/framework/src/Illuminate/Routing/Router.php
Auth::routes();

// メイン画面
Route::get('/', function () {

    // ログアウト時
    if(!isset(Auth::user()->id)) {
        return redirect()->route('login');
    }

    // 表示設定がカレンダーの場合
    if(isset(Auth::user()->personal) && Auth::user()->personal->view == 1) {
        return redirect()->route('post.calendar');
    }

    return redirect()->route('post.list');
})->name('post.index');

// 投稿画面
Route::group(['prefix' => 'post'], function () {
    Route::get('get-month-posts-json', 'PostController@getMonthPostsJson');
    Route::get('calendar', 'PostController@calendar')->name('post.calendar');
    Route::get('list', 'PostController@list')->name('post.list');
    Route::get('add', 'PostController@add')->name('post.add');
    Route::post('add', 'PostController@insert')->name('post.insert');
    Route::get('view/{id}', 'PostController@view')->name('post.view');
    Route::get('edit/{id}', 'PostController@edit')->name('post.edit');
    Route::post('edit/{id}', 'PostController@update')->name('post.update');
    Route::post('delete/{id}', 'PostController@delete')->name('post.delete');
});

// コメント投稿画面
Route::group(['prefix' => 'comment'], function () {
    Route::post('add/{id}', 'CommentController@insert')->name('comment.insert');
    Route::get('edit/{id}', 'CommentController@edit')->name('comment.edit');
    Route::post('edit/{id}', 'CommentController@update')->name('comment.update');
    Route::post('delete/{id}', 'CommentController@delete')->name('comment.delete');
});

// 個人設定画面
Route::group(['prefix' => 'personal'], function () {

    Route::get('/', function () {
        return redirect()->route('personal.user.edit', Auth::user()->id);
    })->name('personal.index');;

    // ユーザー設定画面
    Route::group(['prefix' => 'user'], function () {
        Route::get('edit/{id}', 'Settings\UserController@edit')->name('personal.user.edit');
        Route::post('edit/{id}', 'Settings\UserController@update')->name('personal.user.update');
        Route::get('edit/password/{id}', 'Settings\UserController@editPassword')->name('personal.user.editPassword');
        Route::post('edit/password/{id}', 'Settings\UserController@updatePassword')->name('personal.user.updatePassword');
        Route::post('delete/{id}', 'Settings\UserController@delete')->name('personal.user.delete');
    });

    // 言語設定
    Route::get('lang/{id}', 'Personal\PersonalController@editLang')->name('personal.lang.edit');
    Route::post('lang/{id}', 'Personal\PersonalController@updateLang')->name('personal.lang.update');

    // 表示設定
    Route::get('view/{id}', 'Personal\PersonalController@editView')->name('personal.view.edit');
    Route::post('view/{id}', 'Personal\PersonalController@updateView')->name('personal.view.update');
});

// 設定画面
Route::group(['prefix' => 'settings'], function () {

    Route::get('/', function () {
        return redirect()->route('settings.dashboard');
    })->name('settings.index');

    // ダッシュボード画面
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', 'Settings\DashboardController@index')->name('settings.dashboard');
        Route::get('get-month-total-json', 'Settings\DashboardController@getMonthTotalJson');
        Route::get('get-category-total-json', 'Settings\DashboardController@getCategoryTotalJson');
        Route::get('get-tag-total-json', 'Settings\DashboardController@getTagTotalJson');
    });

    // タグ設定画面
    Route::group(['prefix' => 'tag'], function () {
        Route::get('list', 'Settings\TagController@list')->name('settings.tag.list');
        Route::get('add', 'Settings\TagController@add')->name('settings.tag.add');
        Route::post('add', 'Settings\TagController@insert')->name('settings.tag.insert');
        Route::get('edit/{id}', 'Settings\TagController@edit')->name('settings.tag.edit');
        Route::post('edit/{id}', 'Settings\TagController@update')->name('settings.tag.update');
        Route::post('delete/{id}', 'Settings\TagController@delete')->name('settings.tag.delete');
    });

    // カテゴリ設定画面
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', 'Settings\CategoryController@list')->name('settings.category.list');
        Route::get('add', 'Settings\CategoryController@add')->name('settings.category.add');
        Route::post('add', 'Settings\CategoryController@insert')->name('settings.category.insert');
        Route::get('edit/{id}', 'Settings\CategoryController@edit')->name('settings.category.edit');
        Route::post('edit/{id}', 'Settings\CategoryController@update')->name('settings.category.update');
        Route::post('delete/{id}', 'Settings\CategoryController@delete')->name('settings.category.delete');
    });

    // ユーザー設定画面
    Route::group(['prefix' => 'user'], function () {
        Route::get('list', 'Settings\UserController@list')->name('settings.user.list');
        Route::get('add', 'Settings\UserController@add')->name('settings.user.add');
        Route::post('add', 'Settings\UserController@insert')->name('settings.user.insert');
        Route::get('edit/{id}', 'Settings\UserController@edit')->name('settings.user.edit');
        Route::post('edit/{id}', 'Settings\UserController@update')->name('settings.user.update');
        Route::get('edit/password/{id}', 'Settings\UserController@editPassword')->name('settings.user.editPassword');
        Route::post('edit/password/{id}', 'Settings\UserController@updatePassword')->name('settings.user.updatePassword');
        Route::post('delete/{id}', 'Settings\UserController@delete')->name('settings.user.delete');
        Route::get('import', 'Settings\UserController@import')->name('settings.user.import');
        Route::put('import', 'Settings\UserController@checkImport')->name('settings.user.checkImport');
        Route::post('import', 'Settings\UserController@insertImport')->name('settings.user.insertImport');
    });
});

// フロントエンド側言語設定取得URL
Route::get('get-locale', 'LocaleController@getLang');