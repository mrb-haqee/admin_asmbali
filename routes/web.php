<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Konfigurasi\Aksesibilitas\Permission\PermissionIndex;
use App\Livewire\Konfigurasi\Aksesibilitas\Roles\Detail\RolesSubIndex;
use App\Livewire\Konfigurasi\Aksesibilitas\Roles\RolesIndex;
use App\Livewire\Konfigurasi\Masterdata\Account\AccountIndex;
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

            Route::get('account', AccountIndex::class)->name('account.index');
        });

        Route::name('aksesibilitas.')->prefix('aksesibilitas')->group(function () {
            Route::get('roles', RolesIndex::class)->name('roles.index');
            Route::get('roles/{role}', RolesSubIndex::class)->name('roles.show');

            Route::get('permission', PermissionIndex::class)->name('permission.index');
        });
    });
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
