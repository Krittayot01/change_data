<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminChangeRequestController;
use App\Http\Controllers\ChangeRequestController; // อย่าลืมใส่บรรทัดนี้ไว้ด้านบนสุดของไฟล์ด้วยนะครับ

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
// หน้าแสดงแบบฟอร์มสำหรับสมาชิก
Route::get('/change-request', [ChangeRequestController::class, 'index'])->name('change-request.form');

// รับข้อมูลเมื่อกดปุ่ม Submit
Route::post('/change-request', [ChangeRequestController::class, 'store'])->name('change-request.store');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // บรรทัดนี้คือหน้า Index ซึ่งต้องมี ->name('change-requests.index') อยู่ด้านหลังสุดครับ
    Route::get('/change-requests', [AdminChangeRequestController::class, 'index'])->name('change-requests.index');

    // บรรทัดนี้คือหน้า Show (ที่คุณเพิ่งแก้ URL ไปล่าสุด)
    Route::get('/change-requests/show', [AdminChangeRequestController::class, 'show'])->name('change-requests.show');
});
require __DIR__ . '/auth.php';
