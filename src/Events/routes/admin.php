<?php

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    'namespace' => 'Taggers\Events\Controllers'
    ], function() {
        Route::resource('eventcategories', 'EventCategoriesController', ['except' => ['create', 'show']]);
        Route::get('events/updatestatus/{id}', 'EventsController@updateStatus')->name('events.updatestatus');
        Route::resource('events', 'EventsController', ['except' => ['show']]);
});