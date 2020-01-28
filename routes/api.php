<?php

$router->post('User/LoginUtilisateur', [
    'uses' => 'UserController@LoginUtilisateur',
]);

$router->post('User/AjouterUtilisateur', [
    'uses' => 'UserController@AjouterUtilisateur',
]);

$router->get('/', function () use ($router) {
    return
    response('Access Denied', 401)
        ->header('Api version', env("APP_VERSION", "Default value if the key does not exists"), )
        ->header('Content-Type', 'application/json')
        ->header('Authorisation', 'Denied');
});

// Début Route group api

Route::group(['middleware' => 'jwt.verify'], function () {

    Route::post('AjouterCategorie', [
        'middleware' => 'jwt.role',
        'roles' => ['1'],
        'uses' => 'CategorieController@AjouterCategorie',
    ]);

    Route::post('AfficherCategorie', [
        'middleware' => 'jwt.role',
        'roles' => ['1'],
        'uses' => 'CategorieController@AfficherCategorie',
    ]);

    Route::post('AjouterPost', [
        'middleware' => 'jwt.role',
        'roles' => ['1'],
        'uses' => 'PostController@AjouterPost',
    ]);

    Route::post('AfficherPost', [
        'middleware' => 'jwt.role',
        'roles' => ['1'],
        'uses' => 'PostController@AfficherPost',
    ]);

    Route::post('AffecterCategorieToPost', [
        'middleware' => 'jwt.role',
        'roles' => ['1'],
        'uses' => 'PostCategorieController@AffecterCategorieToPost',
    ]);

}); // fin Route group api
