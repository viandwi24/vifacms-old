<?php
##########################################################################
#############################[ADMIN ROUTE]#################################
###########################################################################
Route::group(['prefix' => 'admin'], function(){
	Auth::routes();
});

Route::group([
	'prefix' 		=> 'admin', 
	'middleware' 	=> ['auth'] 
], function(){
	### ADMIN - HOME ROUTE
	Route::get('/', 'Admin\HomeController@index')->name('admin.home');

	### ADMIN - POST PUBLISHED ROUTE
	Route::resource('/post/published', 'Admin\PostPublishedController', ['names'=>[
		'index' 	=> 'admin.post.published',
		'create' 	=> 'admin.post.create',
		'store' 	=> 'admin.post.store',
		'destroy' 	=> 'admin.post.destroy',
		'edit' 		=> 'admin.post.edit',
		'update' 	=> 'admin.post.update',
	]]);
	Route::get('/post/draft', 'Admin\PostPublishedController@draft')->name('admin.post.draft');

	### ADMIN - CATEGORY
	Route::resource('/post/category', 'Admin\CategoryController', ['names'=>[
		'index' 	=> 'admin.post.category',
		'store' 	=> 'admin.post.category.store',
		'destroy' 	=> 'admin.post.category.destroy',
	]]);
	Route::patch('/post/category/edit', 'Admin\CategoryController@update_a')
		->name('admin.post.category.update');


	### ADMIN - THEMA
	Route::resource('/theme', 'Admin\ThemeController', ['names'=>[
		'index' 	=> 'admin.theme.index',
		'edit' 		=> 'admin.theme.edit',
		'update' 	=> 'admin.theme.update',
	]]);
	Route::patch('/theme/update', 'Admin\ThemeController@update')
		->name('admin.theme.update');

	Route::get('/page/system', function(){})->name('admin.page.system');
	Route::get('/page/other', function(){})->name('admin.page.other');


	Route::get('/setting', 'Admin\SettingController@index')->name('admin.setting');
});







###########################################################################
############################[PUBLIC ROUTE]#################################
###########################################################################
Route::get('/', 'User\TemplateController@index')->name('home');
Route::get('/page/{page}', 'User\TemplateController@index')->name('page');

Route::get('/{post}', 'User\TemplateController@post_model1')->name('post.model1');
Route::get('/{segment_1}/{post}', 'User\TemplateController@post_model2')->name('post.model2');


/*
Route::get('/{url_models_1}/{post}', function(){
	return url()->current();
});
Route::get('/{url_models_1}/{url_models_2}/{post}', function(){
	return url()->current();
});
*/