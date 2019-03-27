<?php

Auth::routes();

// Principal
Route::get('/', 'HomeController@index')->name('home');

// Livros
Route::get('books/openCart', 'BookController@openCart')->name('books.openCart');
Route::get('books/addCart/{id}', 'BookController@addCart')->name('books.addCart');
Route::get('books/rmCart/{id}', 'BookController@rmCart')->name('books.rmCart');
Route::resource('books', 'BookController');

// Emprestimos
Route::resource('/lendings', 'LendingController');
Route::get('lendings/finish/{id}', 'LendingController@finish')->name('lendings.finish');

// Autores
Route::resource('/authors', 'AuthorController');

