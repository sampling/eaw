<?php

Route::group([
    'prefix'     => 'maps',
    'middleware' => 'access.routeNeedsPermission:view-maps-management',
], function() {

    /**
     * Map Management
     */
    Route::group(['namespace' => 'Maps'], function() {
        Route::resource('all', 'MapController', ['except' => ['show']]);
        Route::get('create', 'MapController@create')->name('admin.maps.create');
        Route::post('create', 'MapController@save')->name('admin.maps.save');        

        /**
         * Specific Map
         */
        Route::group(['prefix' => 'map/{id}', 'where' => ['id' => '[0-9]+']], function() {
            Route::get('delete', 'MapController@delete')->name('admin.maps.delete');
            Route::get('edit', 'MapController@edit')->name('admin.maps.edit');
        });
    });

});
