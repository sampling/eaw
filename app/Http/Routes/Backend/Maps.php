<?php

Route::group([
    'prefix'     => 'maps',
    'middleware' => 'access.routeNeedsPermission:view-maps-management',
], function() {

    /**
     * Map Management
     */
    Route::group(['namespace' => 'Maps'], function() {
        Route::get('all', 'MapController@index')->name('admin.maps.index');
        Route::get('create', 'MapController@create')->name('admin.maps.create');
        Route::post('create', 'MapController@store')->name('admin.maps.create');        

        /**
         * Specific Map
         */
        Route::group(['prefix' => 'map/{id}', 'where' => ['id' => '[0-9]+']], function() {
            Route::delete('delete', 'MapController@delete')->name('admin.maps.delete');
            Route::get('edit', 'MapController@edit')->name('admin.maps.edit');
        });
    });

});
