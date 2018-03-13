<?php
//
//Route::namespace('Vadiasov\ArtistsAdmin\Controllers')->as('artists::')->middleware('web')->group(function () {
//    // Routes defined here have the web middleware applied
//    // like the web.php file in a laravel project
//    // They also have an applied controller namespace and a route names.
//
//    Route::middleware('artists')->group(function () {
//        // Routes defined here have the self-assigned middleware applied.
//        // By default this middleware is empty.
//    });
//});

// src/Routes/web.php
Route::group(['middleware' => ['web', 'admin']], function () {
    Route::get('admin/artists', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@index')->name('admin/artists');
    Route::get('admin/artists/create', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@create')->name('admin/artists/create');
    Route::post('admin/artists/create', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@store');
    Route::get('admin/artists/{id}/edit', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@edit');
    Route::post('admin/artists/{id}/edit', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@update');
    Route::get('admin/artists/{id}/delete', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@destroy');
    Route::get('admin/artists/{id}/edit-image', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@editImage')->name('edit-image');
    Route::post('admin/artists/{id}/edit-image', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@storeImage');
    Route::get('admin/artists/{id}/crop-image', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@cropImage')->name('crop->image');
    Route::post('admin/artists/{id}/crop-image', 'Vadiasov\ArtistsAdmin\Controllers\ArtistsController@processImage');
});
