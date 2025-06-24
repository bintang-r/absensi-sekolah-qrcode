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

Route::redirect('/', '/login');

Route::middleware('auth', 'verified', 'force.logout')->namespace('App\Livewire')->group(function () {

    /**
     * master / data master
     */
    Route::prefix('master')->name('master.')->middleware('roles:admin')->namespace('Master')->group(function(){
        Route::redirect('/', 'master/admin');

        /**
         * admin
         */
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', Admin\Index::class)->name('index');
            Route::get('/tambah', Admin\Create::class)->name('create');
            Route::get('/{id}/edit', Admin\Edit::class)->name('edit');
        });
    });

    /**
     * beranda / home
     */
    Route::get('beranda', Home\Index::class)->name('home')
        ->middleware('roles:admin,siswa,guru');

    /**
     * setting
     */
    Route::prefix('pengaturan')->name('setting.')->middleware('roles:admin,siswa,guru')->namespace('Setting')->group(function () {
        Route::redirect('/', 'pengaturan/aplikasi');

        /**
         * Profile
         */
        Route::prefix('profil')->name('profile.')->group(function () {
            Route::get('/', Profile\Index::class)->name('index');
        });

        /**
         * Account
         */
        Route::prefix('akun')->name('account.')->group(function () {
            Route::get('/', Account\Index::class)->name('index');
        });
    });
});
