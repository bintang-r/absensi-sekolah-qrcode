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
         * class schedule / jadwal kelas
         */
        Route::prefix('jadwal-kelas')->name('class-schedule.')->middleware('roles:admin')->group(function(){
            Route::get('/', ClassSchedule\Index::class)->name('index');
            Route::get('/tambah', ClassSchedule\Create::class)->name('create');
            Route::get('/sunting/{id}', ClassSchedule\Edit::class)->name('edit');
        });

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

        /**
         *  class advisor / wali kelas
         */
        Route::prefix('wali-kelas')->name('advisor-class.')->middleware('roles:admin')->group(function(){
            Route::get('/', ClassAdvisor\Index::class)->name('index');
        });
    });

    // ATTENDANCE
    Route::prefix('presensi')->name('attendance.')->middleware('roles:admin')->namespace('Attendance')->group(function(){
        /**
         * class / kelas
         */
        Route::prefix('kelas')->name('class.')->group(function(){
            Route::get('/', Class\Index::class)->name('index');
            Route::get('/detail/{id}', Class\Detail::class)->name('detail');
        });

        /**
         * qrcode / qr code
         */
        Route::prefix('qrcode')->name('qrcode.')->group(function(){
            Route::get('/masuk', Qrcode\CheckIn::class)->name('check-in');
            Route::get('/keluar', Qrcode\CheckOut::class)->name('check-out');
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

    /** scan qr / camera */
    Route::prefix('scan-qr')->name('scan-qr.')->middleware('roles:operator,admin')->group(function(){
        Route::get('/', ScanQr\Index::class)->name('index');
    });

    /** teacher schedule / jadwal mengajar dosen */
    Route::prefix('jadwal-mengajar')->name('schedule-teacher.')->middleware('roles:guru')->group(function(){
        Route::get('/', TeacherSchedule\Index::class)->name('index');
    });

    /**
     * beranda / home
     */
    Route::get('beranda', Home\Index::class)->name('home')
        ->middleware('roles:admin,siswa,guru');

    /**
     * class attendance / presensi kelas
     */
    Route::prefix('presensi-kelas')->name('class-attendance.')->middleware('roles:guru')->group(function(){
        Route::get('/', ClassAttendance\Index::class)->name('index');
        Route::get('/detail/{id}', ClassAttendance\Detail::class)->name('detail');
        Route::get('/create/{id}', ClassAttendance\Create::class)->name('create');
        Route::get('/edit/{scheduleId}/{classAttendanceId}', ClassAttendance\Edit::class)->name('edit');
    });

    /**
     * whatsapp broadcast
     */
    Route::prefix('whatsapp-broadcast')->name('whatsapp-broadcast.')->middleware('roles:admin')->group(function(){
        Route::get('/', WhatsappBroadcast\Index::class)->name('index');
    });

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
