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

// Public Sites
Route::get('/', 'PublicController@home');
Route::get('/cms', 'PublicController@login');
Route::get('/contact', 'PublicController@contact');
Route::get('/page/{slug}', 'PublicController@page');
Route::get('/article/{slug}', 'PublicController@project');

Route::get('/public/api/project/{slug}', 'PublicController@getProject');
Route::get('/public/api/menu', 'PublicController@getMenu');
Route::get('/public/api/page/{slug}', 'PublicController@getPage');
Route::get('/public/api/page/{slug}/projects', 'PublicController@getPageProjects');
Route::get('/public/api/settings/', 'PublicController@getSettings');

//Project Comments
Route::get('/public/api/comments/{slug}', 'CommentsController@show');
Route::post('/public/api/comments/{project}', 'CommentsController@store');
Route::post('/public/api/comments/{project}/{comment}', 'CommentsController@reply');
Route::patch('/public/api/comments/{comment}/like', 'CommentsController@like');
Route::delete('/public/api/comments/{comment}', 'CommentsController@delete');

Route::patch('/api/comments/approve/{comment}', 'CommentsController@approve');

// Route::get('/login}', 'PublicController@login');
Route::get('/set', 'PublicController@settings');

// Intern
Route::get('/cms/page/{slug}', 'app\PagesController@page');
Route::get('/cms/project/{slug}', 'app\PagesController@project');
Route::get('/cms/settings', 'app\PagesController@settings');
Route::get('/cms/profile', 'app\PagesController@profile');
Route::get('/cms/dashboard', 'app\PagesController@dashboard');

//Settings
Route::get('/api/settings', 'app\Settingscontroller@show');
Route::get('/api/settings/landing', 'app\Settingscontroller@landing');
Route::patch('/api/settings/{setting}/landing/update', 'app\Settingscontroller@updateLanding');
Route::patch('/api/settings/{setting}', 'app\Settingscontroller@update');
Route::post('/api/settings/register', 'Auth\RegisterController@register');

//Profile
Route::get('/api/profile', 'app\ProfileController@show');
Route::patch('/api/profile/{user}', 'app\ProfileController@update');
Route::post('/api/profile/{user}', 'app\ProfileController@password');

//Users
Route::get('/api/users', 'app\UsersController@show');
Route::patch('/api/users/{user}', 'app\UsersController@update');
Route::delete('/api/users/{user}', 'app\UsersController@delete');

// //landing
// Route::get('/api/landing/project/{project}', 'LandingController@project');

//Projects
Route::get('/api/projects/limit/{limit}', 'app\Projects\ProjectsController@show');
Route::get('/api/projects/{slug}', 'app\Projects\ProjectsController@edit');
Route::post('/api/projects', 'app\Projects\ProjectsController@create');
Route::patch('/api/projects/{project}', 'app\Projects\ProjectsController@update');
Route::patch('/api/projects/{project}/type', 'app\Projects\ProjectsController@updateType');
Route::delete('/api/projects/{project}', 'app\Projects\ProjectsController@delete');
Route::get('/api/projects/search/{query}/', 'app\Projects\ProjectsController@search');


//Project Users
Route::get('/api/project/users', 'app\Projects\ProjectUsersController@show');
Route::post('/api/project/users/{project}', 'app\Projects\ProjectUsersController@store');
Route::delete('/api/project/users/{project}/{user}', 'app\Projects\ProjectUsersController@delete');
Route::get('/api/project/users/search/{query}/', 'app\Projects\ProjectUsersController@search');

//Project Pages
Route::get('/api/pages', 'app\PagesController@show');
Route::post('/api/pages', 'app\PagesController@create');
Route::get('/api/pages/{slug}', 'app\PagesController@edit');
// Route::get('/api/pages/{slug}/{projects}', 'PagesController@projects');
Route::post('/api/pages/{slug}', 'app\PagesController@getProjects');
Route::patch('/api/pages/{page}', 'app\PagesController@update');
Route::delete('/api/pages/{page}', 'app\PagesController@delete');

//Project Tasks
Route::get('/api/tasks/{slug}', 'app\Projects\ProjectTasksController@show');
Route::post('/api/tasks/{project}', 'app\Projects\ProjectTasksController@store');
Route::post('/api/tasks/{project}/{task}', 'app\Projects\ProjectTasksController@reply');
Route::patch('/api/tasks/{task}', 'app\Projects\ProjectTasksController@update');
Route::delete('/api/tasks/{task}', 'app\Projects\ProjectTasksController@delete');

//Project Tags
Route::post('/api/tags/{project}', 'app\Projects\ProjectTagsController@store');
Route::delete('/api/tags/{project}/{tag}/', 'app\Projects\ProjectTagsController@delete');
Route::get('/api/tags/search/{query}/', 'app\Projects\ProjectTagsController@search');

//Upload
Route::post('/api/upload/project/{project}', 'app\UploadController@project');
Route::patch('/api/upload/project/{project}', 'app\UploadController@projectDelete');
Route::post('/api/upload/profile/{user}', 'app\UploadController@profile');
Route::patch('/api/upload/profile/{user}', 'app\UploadController@profileDelete');
Route::post('/api/upload/settings/logo/{setting}', 'app\UploadController@logo');
Route::patch('/api/upload/settings/logo/{setting}', 'app\UploadController@logoDelete');
Route::post('/api/upload/settings/favicon/{setting}', 'app\UploadController@favicon');
Route::patch('/api/upload/settings/favicon/{setting}', 'app\UploadController@faviconDelete');
Route::post('/api/upload/editor/image', 'app\UploadController@editorImage');
Route::patch('/api/upload/editor/image', 'app\UploadController@editorImageDelete');
Route::post('/api/upload/editor/video', 'app\UploadController@editorVideo');
Route::patch('/api/upload/editor/video', 'app\UploadController@editorVideoDelete');

//Types
Route::get('/api/types', 'app\TypesController@show');

//Roles
Route::get('/api/roles', 'app\RolesController@show');

//Contact
Route::post('/api/contact', 'app\ContactController@mail');

//Authentication
//Auth::routes();
// Route::get('/logged', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('/logged', 'Auth\LoginController@login');
// Route::get('/register', 'Auth\RegisterController@showRegistrationForm');

Route::post('/verify', 'Auth\LoginController@verify');


Route::get('/logged', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/logged', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/dashboard/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
