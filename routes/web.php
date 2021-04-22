<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/phpinfo', function () {
    echo phpinfo();
});

Route::get('/cards', function () {
    $d = DB::table('dog_cards')->count();
    echo $d;
});

Route::name('dog.breed.')->group(function () {
    Route::group(['prefix' => 'dog-breeds'], function() {
        Route::get('/', [AppController::class, 'allBreeds'])->name('all');
    });
});

Route::name('dog.vaccination.')->group(function () {
    Route::group(['prefix' => 'dog-vaccination'], function() {
        Route::get('/', [AppController::class, 'allVaccination'])->name('all');
    });
});

Route::name('dog.digital.card')->group(function () {
    Route::group(['prefix' => 'dog-digital-cards'], function() {
        Route::get('/{card_number}', [AppController::class, 'showDogDigitalCard'])->name('show');
        Route::post('/create', [AppController::class, 'createDogDigitalCard'])->name('create');
        Route::post('/save-card-image/{card_number}', [AppController::class, 'saveCardImage'])->name('save.card.image');
    });
});

// ROOT
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '[\/\w\.-]*');
