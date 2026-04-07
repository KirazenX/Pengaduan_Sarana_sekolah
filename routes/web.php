<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.login');
});

// Rute untuk dashboard yang mengarahkan pengguna ke halaman yang sesuai berdasarkan peran mereka (admin atau siswa)
Route::middleware('auth')->get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.aspirasi.index');
    }

    return redirect()->route('siswa.aspirasi.index');
})->name('dashboard');

// Rute yang dikelompokkan berdasarkan middleware untuk memastikan hanya pengguna yang terautentikasi dapat mengaksesnya, dengan pembagian lebih lanjut berdasarkan peran (siswa atau admin)
Route::middleware(['auth'])->group(function () {

    Route::middleware('role:siswa')->group(function () {
        Route::get('/aspirasi', [AspirasiController::class, 'index'])->name('siswa.aspirasi.index');
        Route::get('/aspirasi/create', [AspirasiController::class, 'create'])->name('siswa.aspirasi.create');
        Route::get('/aspirasi/{id}', [AspirasiController::class, 'show'])->name('siswa.aspirasi.show');
        Route::post('/aspirasi', [AspirasiController::class, 'store'])->name('siswa.aspirasi.store');
    });

    // Rute untuk admin yang mencakup manajemen aspirasi, pengguna, dan kategori, dengan pembatasan akses hanya untuk admin melalui middleware 'role:admin'
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/aspirasi', [AdminController::class, 'index'])->name('admin.aspirasi.index');
        Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::put('/admin/aspirasi/{id}', [AdminController::class, 'update'])->name('admin.aspirasi.update');
        Route::resource('/admin/categories', CategoryController::class, ['as' => 'admin']);
    });

});
