# Authentification

- Move 2017_07_10_120054_user.php in database/migration
- Move AuthController in app/Http/Controllers
- Move AuthRoute in app/Http/Middleware
- Move User.php In app/Models (or wherever your model directory is)
- Move the views to the right folder and update them (also the extend of the Layouts)
- Add `'authRoute'             => AuthRoute::class,` in $routeMiddleware in app/Http/Kernel.php

- public route to add

        Route::get('/login', [
            'as'      => 'auth.login',
            'uses'    => 'AuthController@login'
        ]);
        
        Route::post('/login', [
            'as'      => 'auth.loginStore',
            'uses'    => 'AuthController@loginStore'
        ]);
        
        Route::get('/logout', [
            'as'    => 'auth.logout',
            'uses'  => 'AuthController@logout'
        ]);
        
        /**
         * Password recover
         */
        
        Route::get('/pwd/recover', [
            'as'    => 'auth.recoverPassword',
            'uses'  => 'AuthController@recoverPassword'
        ]);
        
        Route::post('/pwd/recover', [
            'as'    => 'auth.recoverPasswordStore',
            'uses'  => 'AuthController@recoverPasswordStore'
        ]);
        
        Route::get('/pwd/renew/{recoverHash}', [
            'as'    => 'auth.renewPassword',
            'uses'  => 'AuthController@renewPassword'
        ]);
        
        Route::post('/pwd/renew', [
            'as'    => 'auth.renewPasswordStore',
            'uses'  => 'AuthController@renewPasswordStore'
        ]);

- Route to protect : put them in a group behind the middleware 

        Route::group(
            [
                'middleware' => [ 'web','authRoute']
            ], function() {
            //TODO
        });

- You can finally add the helper function to the the helper (if no helper yet you can install it via the toolbox too)