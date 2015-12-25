<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Users
Route::get('users', 'UserController@getAllUsers'); // Get all users
Route::get('users/{id}', 'UserController@getUser'); // Get user by id
Route::post('users', 'UserController@insertUser'); // Insert user
Route::put('users/{id}', 'UserController@updateUser'); // Update user
Route::delete('users/{id}', 'UserController@deleteUser'); // Delete user

// Users Roles
Route::get('userroles', 'UserRoleController@getAllUserRoles'); // Get all user roles
Route::get('userroles/{id}', 'UserRoleController@getUserRole'); // Get user role by id
Route::post('userroles', 'UserRoleController@insertUserRole'); // Insert user role
Route::put('userroles/{id}', 'UserRoleController@updateUserRole'); // Update user role
Route::delete('userroles/{id}', 'UserRoleController@deleteUserRole'); // Delete user role

// Subjects
Route::get('subjects', 'SubjectController@getAllSubjects'); // Get all subjects
Route::get('subjects/{id}', 'SubjectController@getSubject'); // Get subject by id
Route::post('subjects', 'SubjectController@insertSubject'); // Insert subject
Route::put('subjects/{id}', 'SubjectController@updateSubject'); // Update subject
Route::delete('subjects/{id}', 'SubjectController@deleteSubject'); // Delete subject

// Languages
Route::get('languages', 'LanguageController@getAllLanguages'); // Get all languages
Route::get('languages/{id}', 'LanguageController@getLanguage'); // Get language by id
Route::post('languages', 'LanguageController@insertLanguage'); // Insert language
Route::put('languages/{id}', 'LanguageController@updateLanguage'); // Update language
Route::delete('languages/{id}', 'LanguageController@deleteLanguage'); // Delete language

// Publishers
Route::get('publishers', 'PublisherController@getAllPublishers'); // Get all languages
Route::get('publishers/{id}', 'PublisherController@getPublisher'); // Get language by id
Route::post('publishers', 'PublisherController@insertPublisher'); // Insert language
Route::put('publishers/{id}', 'PublisherController@updatePublisher'); // Update language
Route::delete('publishers/{id}', 'PublisherController@deletePublisher'); // Delete language