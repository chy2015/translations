<?php

Route::group(['prefix' => config('amamarul-location.prefix') ,'as' => 'amamarul.translations.'], function(){

    Route::get('home', '\Busup\LocationsControllers\HomeController@index')->name('home');
    Route::get('lang/{lang}', '\Busup\LocationsControllers\HomeController@lang')->name('lang');
    Route::get('lang/generateJson/{lang}', '\Busup\LocationsControllers\HomeController@generateJson')->name('lang.generateJson');
    Route::get('newLang', '\Busup\LocationsControllers\HomeController@newLang')->name('lang.newLang');
    Route::get('newString', '\Busup\LocationsControllers\HomeController@newString')->name('lang.newString');
    Route::get('search', '\Busup\LocationsControllers\HomeController@search')->name('lang.search');
    Route::get('string/{code}', '\Busup\LocationsControllers\HomeController@string')->name('lang.string');
    Route::get('publish-all', '\Busup\LocationsControllers\HomeController@publishAll')->name('lang.publishAll');
});
Route::post('translations/lang/update/{id}', '\Busup\LocationsControllers\HomeController@update')->name('amamarul.translations.lang.update');
