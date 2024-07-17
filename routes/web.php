<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProjetController;            
use App\Http\Controllers\ArchiveController;            
use App\Http\Controllers\RapportController;            
use App\Http\Controllers\UserControlleur;            

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	
	Route::get('projets/{projet}/activites/create', [ProjetController::class, 'createActivite'])->name('projets.activites.create');
	Route::post('projets/{projet}/activites', [ProjetController::class, 'addActivite'])->name('projets.activites.store');
	Route::delete('projets/{projet}/activites/{activite}', [ProjetController::class, 'destroyActivite'])->name('projets.activites.destroy');
	Route::patch('projets/{projet}/activites/{activite}/terminer', [ProjetController::class, 'terminerActivite'])->name('projets.activites.terminer');
	Route::post('projets/{projet}/activites/{activite}/commencer', [ProjetController::class, 'commencerActivite'])->name('projets.activites.commencer');
	Route::patch('/projets/{projet}/activites/{activite}/changerRapport', [ProjetController::class, 'changerRapport'])->name('projets.activites.changerRapport');
	Route::get('projets', [ProjetController::class,'index'])->name('projets');
	Route::get('projets/{id}', [ProjetController::class, 'show'])->name('projets.show');
	Route::post('projet', [ProjetController::class, 'store'])->name('projets.store');
	Route::post('/projets/{id}', [ProjetController::class, 'update'])->name('projets.update');
	Route::get('rapports', [RapportController::class,'index'])->name('rapports');
	Route::get('users', [UserControlleur::class, 'index'])->name('users');
	Route::get('users/create', [UserControlleur::class, 'create'])->name('users.create');
	Route::post('user', [UserControlleur::class, 'store'])->name('user.store');
	Route::get('/users/{id}/edit', [UserControlleur::class, 'edit'])->name('users.edit');
	Route::post('/users/{id}', [UserControlleur::class, 'update'])->name('users.update');
	Route::delete('/users/{id}', [UserControlleur::class, 'destroy'])->name('users.destroy');
	//Route::get('projets/{id}', [ProjetController::class, 'show'])->name('projets.show');
	Route::post('rapport', [RapportController::class, 'store'])->name('rapports.store');
	Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
	Route::delete('/archives/{id}', [ArchiveController::class, 'delete'])->name('archives.delete');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});

Route::get('site', function () {
	return view('pages.site-index');
})->name('site');