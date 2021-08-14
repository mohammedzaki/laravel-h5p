<?php
Route::prefix('admin/h5p')->group(function () {
    Route::group(['middleware' => ['web']], function () {
        if (config('laravel-h5p.use_router') == 'EDITOR' || config('laravel-h5p.use_router') == 'ALL') {
            Route::resource('h5p', "Zaki\LaravelH5p\Http\Controllers\H5pController");
            Route::group(['middleware' => ['auth']], function () {
                Route::get(
                    'library',
                    "Zaki\LaravelH5p\Http\Controllers\LibraryController@index"
                )->name('h5p.library.index');
                Route::get(
                    'library/show/{id}',
                    "Zaki\LaravelH5p\Http\Controllers\LibraryController@show"
                )->name('h5p.library.show');
                Route::post(
                    'library/store',
                    "Zaki\LaravelH5p\Http\Controllers\LibraryController@store"
                )->name('h5p.library.store');
                Route::delete(
                    'library/destroy',
                    "Zaki\LaravelH5p\Http\Controllers\LibraryController@destroy"
                )->name('h5p.library.destroy');
                Route::get(
                    'library/restrict',
                    "Zaki\LaravelH5p\Http\Controllers\LibraryController@restrict"
                )->name('h5p.library.restrict');
                Route::post(
                    'library/clear',
                    "Zaki\LaravelH5p\Http\Controllers\LibraryController@clear"
                )->name('h5p.library.clear');
            });

            // ajax
            Route::match(
                ['GET', 'POST'],
                'ajax/libraries',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraries'
            )->name('h5p.ajax.libraries');
            Route::get('ajax', 'Zaki\LaravelH5p\Http\Controllers\AjaxController')->name('h5p.ajax');
            Route::get(
                'ajax/libraries',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraries'
            )->name('h5p.ajax.libraries');
            Route::get(
                'ajax/single-libraries',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@singleLibrary'
            )->name('h5p.ajax.single-libraries');
            Route::get(
                'ajax/content-type-cache',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@contentTypeCache'
            )->name('h5p.ajax.content-type-cache');
            Route::post(
                'ajax/library-install',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraryInstall'
            )->name('h5p.ajax.library-install');
            Route::post(
                'ajax/library-upload',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraryUpload'
            )->name('h5p.ajax.library-upload');
            Route::post(
                'ajax/rebuild-cache',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@rebuildCache'
            )->name('h5p.ajax.rebuild-cache');
            Route::post('ajax/files', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@files')->name('h5p.ajax.files');
            Route::post(
                'ajax/finish',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@finish'
            )->name('h5p.ajax.finish');
            Route::post(
                'ajax/content-user-data',
                'Zaki\LaravelH5p\Http\Controllers\AjaxController@contentUserData'
            )->name('h5p.ajax.content-user-data');

            //nonce
            Route::match(['GET', 'POST'], 'ajax/{nonce}/libraries', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraries');
            Route::post('ajax/{nonce}/files', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@files');
            Route::get('ajax/{nonce}/libraries', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraries');
            Route::get('ajax/{nonce}/single-libraries', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@singleLibrary');
            Route::get('ajax/{nonce}/content-type-cache', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@contentTypeCache')->name('h5p.ajax.content-type-cache');
            Route::post('ajax/{nonce}/library-install', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraryInstall')->name('h5p.ajax.library-install');
            Route::post('ajax/{nonce}/library-upload', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraryUpload')->name('h5p.ajax.library-upload');
            Route::post('ajax/{nonce}/filter', 'Zaki\LaravelH5p\Http\Controllers\AjaxController@libraryFilter')->name('h5p.ajax.library-filter');
        }

        // export
        //    if (config('laravel-h5p.use_router') == 'EXPORT' || config('laravel-h5p.use_router') == 'ALL') {
        Route::get('h5p/embed/{id}', 'Zaki\LaravelH5p\Http\Controllers\EmbedController')->name('h5p.embed');
        Route::get('h5p/export/{id}', 'Zaki\LaravelH5p\Http\Controllers\DownloadController')->name('h5p.export');
//    }
    });
});

Route::get('h5p/embed/{id}', 'Zaki\LaravelH5p\Http\Controllers\EmbedController')->name('h5p.embed.client');
