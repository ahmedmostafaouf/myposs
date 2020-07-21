<?php

Route::group(['prefix'=>LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]]
    ,function (){
        Route::prefix('dashboard')->middleware(['auth'])->name('dashboard.')->group(function (){

            Route::get('dashboardIndex','DashboardController@index')->name('dashboardIndex');
            //user routes
//            Route::resource('users','UserController')->except(['show']);
            Route::get('create','UserController@create')->name('create');
            Route::post('store','UserController@store')->name('store');
            Route::get('index','UserController@index')->name('index');
            Route::get('edit/{user_id}','UserController@edit')->name('edit');
            Route::get('delete/{user_id}','UserController@delete')->name('delete');
            Route::post('update/{user_id}','UserController@update')->name('update');
            Route::delete('delete/{user_id}','UserController@delete')->name('delete');
            ///////////////////////// category Route//////////////////////////////
            Route::resource('categories','CategoryController')->except(['show']);
            Route::resource('products','ProductController')->except(['show']);
            // route clients
            Route::resource('clients','ClientController')->except(['show']);
            Route::resource('clients.orders','Client\OrderController')->except(['show']);

             // route order
            Route::resource('orders','OrderController');
            Route::get('/orders/{order}/products','OrderController@products')->name('orders.products');








        });
    });

/*Route::group(['prefix'=>'dashboard'],function (){
    Route::get('check',function (){
          return 'Hi dashboard';
    });
});*/
