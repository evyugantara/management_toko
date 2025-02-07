<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('logacc');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cabang', function () {
    return view('cabang');
})->middleware(['auth', 'verified'])->name('cabang');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/logacc', [AuthController::class, 'indexlogin'])->name('logacc.index');
Route::post('/logacc/submit', [AuthController::class, 'submitlogin'])->name('logacc.submit');    


Route::middleware(['auth', 'Admin_Utama'])->group(function(){
    Route::get('admin/dashboard', [HomeController::class, 'index']);
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/cabang', [CabangController::class, 'tampil'])->name('admin.branch');
    Route::get('/admin/supervisor', [TransaksiController::class, 'view'])->name('admin.supervisor');
    Route::get('/admin/cabang', [CabangController::class, 'tampil'])->name('admin.branch'); 
    Route::get('/admin/cabangs/{id}', [CabangController::class, 'view'])->name('admin.show');
    // Route::get('/admin/cabangs/{id}', [CabangController::class, 'view'])->name('admin.show');
    Route::get('/admin/pegawai', [UserController::class, 'tampil'])->name('admin.pegawai');
    Route::get('/admin/pegawai/edit/{id}', [UserController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/pegawai/{id}/update', [UserController::class, 'update'])->name('admin.update');
    Route::delete('/admin/pegaawai/{id}/destroy', [UserController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin/pegawai/tambah', [AuthController::class, 'index'])->name('registrasi.index');
    Route::post('/admin/pegawai/tambah/submit', [AuthController::class, 'submit'])->name('registrasi.submit');
    Route::get('/admin/orders/pdf/{id}', [CabangController::class, 'generatePDF'])->name('admin.orders.pdf');
});

Route::middleware(['auth', 'Manajer_Toko'])->group(function(){
    Route::get('manager/dashboard',[BranchController::class, 'index']);
    Route::get('manager/dashboard',[BranchController::class, 'index'])->name('manager.dashboard');
    Route::get('manager/transaksi',[BranchController::class, 'transaksi'])->name('manager.transaksi');
    Route::get('manager/orders/pdf', [BranchController::class, 'generatePDF'])->name('manager.orders.pdf');
});

Route::middleware(['auth', 'Supervisor'])->group(function(){
    Route::get('supervisor/dashboard',[HomeController::class, 'superdash']);
    Route::get('supervisor/dashboard',[HomeController::class, 'superdash'])->name('supervisor.dashboard');
    Route::get('supervisor/transaksi',[HomeController::class, 'supershow'])->name('supervisor.show');
});

Route::middleware(['auth', 'Pegawai_Gudang'])->group(function(){
    Route::get('gudang/dashboard',[HomeController::class, 'gudang']);
    Route::get('gudang/dashboard',[HomeController::class, 'gudang'])->name('gudang.dashboard');
    Route::get('gudang/stok',[HomeController::class, 'gudangstok'])->name('gudang.stok');
    Route::get('gudang/create',[HomeController::class, 'gudangcreate'])->name('gudang.create');
    Route::post('gudang/store',[HomeController::class, 'gudangstore'])->name('gudang.store');
});

Route::middleware(['auth', 'Kasir'])->group(function(){
    Route::get('kasir/dashboard',[HomeController::class, 'kasir']);
    Route::get('kasir/dashboard',[HomeController::class, 'kasir'])->name('kasir.dashboard');
    Route::resource('transaksis', TransaksiController::class);
});





require __DIR__.'/auth.php';


   Route::get('/supervisor', function () {
    return view('supervisor');
   });