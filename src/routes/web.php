<?php

Route::group(['prefix' => config('location.prefix') ,'as' => 'amamarul.translations.'], function(){

    Route::get('home', '\Chy2015\Translations\Controllers\HomeController@index')->name('home');
    Route::get('lang/{lang}', '\Chy2015\Translations\Controllers\HomeController@lang')->name('lang');
    Route::get('lang/generateJson/{lang}', '\Chy2015\Translations\Controllers\HomeController@generateJson')->name('lang.generateJson');
    Route::get('newLang', '\Chy2015\Translations\Controllers\HomeController@newLang')->name('lang.newLang');
    Route::get('newString', '\Chy2015\Translations\Controllers\HomeController@newString')->name('lang.newString');
    Route::get('search', '\Chy2015\Translations\Controllers\HomeController@search')->name('lang.search');
    Route::get('string/{code}', '\Chy2015\Translations\Controllers\HomeController@string')->name('lang.string');
    Route::get('publish-all', '\Chy2015\Translations\Controllers\HomeController@publishAll')->name('lang.publishAll');
});
Route::post('translations/lang/update/{id}', '\Chy2015\Translations\Controllers\HomeController@update')->name('amamarul.translations.lang.update');
