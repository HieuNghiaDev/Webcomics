<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\YeuThichController;

// Route::get('/', function () {
//     return view('index');
// });

// // Trang chủ
Route::get('/ha', function () {
    return view('<layouts>header');
});

// Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index')->middleware('auth');

// Route đăng nhập
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Route đăng ký
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/forgot-password', function() {
    return view('forgot-password');
})->name('password.request');

Route::get('the-loai/{id}', [App\Http\Controllers\TheLoaiController::class, 'show'])->name('the-loai.show');
Route::get('the-loai', [App\Http\Controllers\TheLoaiController::class, 'index'])->name('the-loai.index');


Route::get('/truyen', [App\Http\Controllers\TruyenController::class, 'index'])->name('truyen.index');
Route::get('/truyen/{id}', [App\Http\Controllers\TruyenController::class, 'show'])->name('truyen.show');

// Route để đọc từ chương đầu tiên
Route::get('/truyen/{truyen}/chapter', [App\Http\Controllers\ChapterController::class, 'firstChapter'])
    ->name('truyen.chapter');

// Route để đọc một chương cụ thể
Route::get('/truyen/{truyen}/chapter/{chapter}', [App\Http\Controllers\ChapterController::class, 'show'])
    ->name('chapter.show');

// Routes cho phần đọc truyện
Route::get('/truyen/{truyen}/chapter', [App\Http\Controllers\ChapterController::class, 'firstChapter'])
    ->name('truyen.chapter');

Route::get('/truyen/{truyen}/chapter/{chapter}', [App\Http\Controllers\ChapterController::class, 'show'])
    ->name('chapter.show');

// Route cho comment
// Route::post('/chapter/{chapter}/comment', [App\Http\Controllers\ChapterController::class, 'storeComment'])
//     ->name('comment.store');
// Route cho comment
Route::post('/chapter/{chapter}/comment', [ChapterController::class, 'storeComment'])->name('comment.store');

// Route cho yêu thích
Route::post('/truyen/yeuthich', [YeuThichController::class, 'toggle'])->name('truyen.yeuthich');
Route::get('/truyen/yeuthich', [YeuThichController::class, 'index'])->name('truyen.yeuthich.index');