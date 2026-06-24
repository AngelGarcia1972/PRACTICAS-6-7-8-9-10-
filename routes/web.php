<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('solo.celular');

Route::get('/admin/panel', function () {
    return 'Panel de administrador';
})->middleware('verificar.rol:admin');

Route::get('/movil', function () {
    return 'Versión móvil';
});

Route::get('/contacto', function () {
    return 'Página de contacto';
})->middleware('solo.celular');

Route::get('/acerca-de', function () {
    return 'Acerca de nosotros';
})->middleware('solo.celular');

Route::get('/servicios', function () {
    return 'Nuestros servicios';
})->middleware('solo.celular');
