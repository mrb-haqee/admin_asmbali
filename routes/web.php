<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Konfigurasi\Aksesibilitas\Permission\PermissionIndex;
use App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail\RolesSubIndex;
use App\Livewire\Konfigurasi\Aksesibilitas\Roles\RolesIndex;
use App\Livewire\Konfigurasi\Masterdata\Menu\Detail\MenuSubIndex;
use App\Livewire\Konfigurasi\Masterdata\Menu\MenuIndex;
use App\Livewire\Konfigurasi\Masterdata\User\UserIndex;
use App\Livewire\TestLivewire;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified', 'menu.access'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('konfigurasi.')->prefix('konfigurasi')->group(function () {
        Route::name('masterdata.')->prefix('masterdata')->group(function () {
            Route::get('menu', MenuIndex::class)->name('menu.index');
            Route::get('menu/{menu}', MenuSubIndex::class)->name('menu.show');

            Route::get('user', UserIndex::class)->name('user.index');
        });

        Route::name('aksesibilitas.')->prefix('aksesibilitas')->group(function () {
            Route::get('roles', RolesIndex::class)->name('roles.index');
            Route::get('roles/{role}', RolesSubIndex::class)->name('roles.show');

            Route::get('permission', PermissionIndex::class)->name('permission.index');
        });
    });
    // Route::name('konfigurasi.')->prefix('konfigurasi')->group(function () {
    //     Route::name('masterdata.')->prefix('masterdata')->group(function () {
    //         Route::get('menu', function () {
    //             return view('livewire.konfigurasi.masterdata.menu.index');
    //         })->name('menu');
    //         Route::get('menu/{id}', function ($id) {
    //             $menu = Menu::find($id)->toArray();
    //             return view('livewire.konfigurasi.masterdata.menu.detail.index', ['menu_id' => $id, 'menu' => $menu]);
    //         })->name('menu.show');
    //     });
    // });


    // routes/web.php

    // Route::name('account.')->prefix('account')->group(function () {
    //     Route::resource('data', MenuController::class)->names('data');
    // });

    // Route::name('user.')->prefix('user')->group(function () {
    //     Route::resource('data', MenuController::class)->names('data');
    // });

    // Route::name('administrasi.')->prefix('administrasi')->group(function () {
    //     Route::name('laporan.')->prefix('laporan')->group(function () {
    //         Route::resource('laporan_pemasukan', UserManagementController::class)->names('laporan_pemasukan');
    //     });
    // });

    // Route::name('web_asm.')->prefix('web_asm')->group(function () {
    //     Route::name('content.')->prefix('content')->group(function () {
    //         Route::resource('landing_page', UserManagementController::class)->names('landing_page');
    //     });
    // });

    // Route::name('web_tpq.')->prefix('web_tpq')->group(function () {
    //     Route::name('content.')->prefix('content')->group(function () {
    //         Route::resource('landing_page', UserManagementController::class)->names('landing_page');
    //     });
    // });
});


Route::get('/buat-storage-link', function () {
    symlink(storage_path('app/public'), public_path('storage'));
    return 'Storage link berhasil dibuat!';
});

Route::get('/error', function () {
    abort(500);
})->name('error');

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
