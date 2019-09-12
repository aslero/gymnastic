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



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/posts/{slug}', 'Frontend\ArticlesController@post')->name('post');
Route::get('/posts/', 'Frontend\ArticlesController@posts')->name('posts');
Route::get('/tag/{slug}', 'Frontend\ArticlesController@tagsArticles')->name('tagsArticles');




Route::group(['namespace' => 'Frontend','middleware' => 'auth'], function () {
    /*
     * Articles
     */
    Route::get('/add-article', 'ArticlesController@add')->name('addArticle');
    Route::post('/add-article', 'ArticlesController@save');
});


Route::group(['namespace' => 'Cabinet','prefix' => 'cabinet','middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index')->name('profile');
    Route::get('/get-user', 'ProfileController@getUser');
    Route::get('/posts', 'ArticleController@articles')->name('cabinetArticles');
    Route::get('/posts-list', 'ArticleController@getArticles');
    Route::post('/edit/post', 'ArticleController@editArticle');
    Route::post('/delete/post', 'ArticleController@deleteArticle');
    Route::post('/edit/post/update', 'ArticleController@updateArticle');
    Route::post('/edit/post/delete/block', 'ArticleController@deleteArticleGallery');
    Route::get('/posts/{slug}', 'ArticleController@edit');
});

Route::post('/upload/article/images', 'Uploads\ArticleController@article')->middleware('auth');

/*
 * Get data
 */
Route::group(['namespace' => 'Other','middleware' => 'auth'], function () {
    Route::get('/tags/get-tags', 'TagsController@getTags');
});


Route::get('/{user}/request-confirmation','Mail\UserEmailConfirmation@request')->name('request-confirm-email')->middleware('auth');
Route::post('/{user}/send-confirmation-email','Mail\UserEmailConfirmation@sendEmail')->name('send-confirmation-email')->middleware('auth');
Route::get('/{user}/confirm-email/{token}','Mail\UserEmailConfirmation@confirmEmail')->name('confirm-email');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
