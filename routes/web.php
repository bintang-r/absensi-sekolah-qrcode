<?php

use App\Http\Controllers\CetakPdfController;
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

/**
 * cetak pdf
 */
Route::middleware('auth','verified','force.logout')->prefix('cetak-pdf')->name('print-pdf.')->group(function(){
    Route::get('/kartu', [CetakPdfController::class,'card'])->middleware('roles:admin')->name('card');
});

Route::middleware('auth', 'verified', 'force.logout')->namespace('App\Livewire')->group(function () {

    /**
     * master / data master
     */
    Route::prefix('master')->name('master.')->middleware('roles:admin')->namespace('Master')->group(function(){
        Route::redirect('/', 'master/admin');

        /**
         * admin
         */
        Route::prefix('admin')->name('admin.')->middleware('roles:admin')->group(function () {
            Route::get('/', Admin\Index::class)->name('index');
            Route::get('/tambah', Admin\Create::class)->name('create');
            Route::get('/{id}/edit', Admin\Edit::class)->name('edit');
        });

        /**
         * class room / ruang kelas
         */
        Route::prefix('ruang-kelas')->name('classroom.')->middleware('roles:admin')->group(function(){
            Route::get('/', ClassRoom\Index::class)->name('index');
        });

        /**
         * subject study / mata pelajaran
         */
        Route::prefix('mata-pelajaran')->name('subject-study.')->middleware('roles:admin')->group(function(){
            Route::get('/', SubjectStudy\Index::class)->name('index');
        });
    });

    /**
     * teacher / guru
     */
    Route::prefix('guru')->name('teacher.')->middleware('roles:admin')->group(function () {
        Route::get('/',Teacher\Index::class)->name('index');
        Route::get('/tambah', Teacher\Create::class)->name('create');
        Route::get('/{id}/edit', Teacher\Edit::class)->name('edit');
        Route::get('/{id}/detail', Teacher\Detail::class)->name('detail');
    });

    /**
     * teacher subject / guru mata pelajaran
     */
    Route::prefix('mata-pelajaran-guru')->name('subject-teacher.')->middleware('roles:admin')->group(function(){
        Route::get('/', TeacherSubject\Index::class)->name('index');
    });

    /**
     * student / student
     */
    Route::prefix('siswa')->name('student.')->middleware('roles:admin')->group(function () {
        Route::get('/',Student\Index::class)->name('index');
        Route::get('/tambah', Student\Create::class)->name('create');
        Route::get('/{id}/edit', Student\Edit::class)->name('edit');
        Route::get('/{id}/detail', Student\Detail::class)->name('detail');
    });

    /**
     * qrcode / qrcode
     */
    Route::prefix('qr-code')->name('qrcode.')->middleware('roles:admin')->group(function(){
        Route::get('/', Qrcode\Index::class)->name('index');
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
