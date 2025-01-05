<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesController;

Route::get('/', function () {
    return redirect('/series');
});

//https://laravel.com/docs/11.x/controllers#resource-controllers
//Substitui o código abaixo
Route::resource('/series', SeriesController::class)
    ->except(['show']);
    //->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);

/*
Route::controller(SeriesController::class)->group(function(){
    Route::get('/series', 'index')->name('series.index');
    Route::get('/series/criar', 'create')->name('series.create');
    Route::post('/series/salvar', 'store')->name('series.store');
});
*/
/*
@method('DELETE') no formulário 'traduz' o post para DELETE.
Assim o Laravel entende que é para deletar.
*/
/*
Route::delete('/series/destroy/{serie}', [SeriesController::class, 'destroy'])
    ->name('series.destroy');
*/
