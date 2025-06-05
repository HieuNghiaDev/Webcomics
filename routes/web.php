<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\YeuThichController;
use App\Http\Controllers\TheoDoiController;
use app\Http\Controllers\TheLoaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;

// Route::get('/', function () {
//     return view('index');
// });

// Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index')->middleware('auth');

// Route đăng nhập
Route::get('/login', [LoginController::class, 'hienThiFormDangNhap'])->name('login');
Route::post('/login', [LoginController::class, 'dangNhap']);
Route::post('/logout', [LoginController::class, 'dangXuat'])->name('logout');

//Admin
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/', [AdminController::class, 'trangChu'])->name('admin');
    
    // Quản lý người dùng
    Route::get('/nguoi-dung', [AdminController::class, 'quanLyNguoiDung'])->name('nguoiDung');
    Route::get('/nguoi-dung/them', [AdminController::class, 'themNguoiDung'])->name('nguoiDung.them');
    Route::post('/nguoi-dung/luu', [AdminController::class, 'luuNguoiDung'])->name('nguoiDung.luu');
    Route::get('/nguoi-dung/sua/{id}', [AdminController::class, 'suaNguoiDung'])->name('nguoiDung.sua');
    Route::put('/nguoi-dung/cap-nhat/{id}', [AdminController::class, 'capNhatNguoiDung'])->name('nguoiDung.capNhat');
    Route::delete('/nguoi-dung/xoa/{id}', [AdminController::class, 'xoaNguoiDung'])->name('nguoiDung.xoa');
    
    // Quản lý truyện
    Route::get('/truyen', [AdminController::class, 'quanLyTruyen'])->name('truyen');
    Route::get('/truyen/them', [AdminController::class, 'themTruyen'])->name('truyen.them');
    Route::post('/truyen/luu', [AdminController::class, 'luuTruyen'])->name('truyen.luu');
    Route::get('/truyen/sua/{id}', [AdminController::class, 'suaTruyen'])->name('truyen.sua');
    Route::put('/truyen/cap-nhat/{id}', [AdminController::class, 'capNhatTruyen'])->name('truyen.capNhat');
    Route::delete('/truyen/xoa/{id}', [AdminController::class, 'xoaTruyen'])->name('truyen.xoa');
});

// Route cho tác giả
Route::prefix('author')->middleware('auth')->group(function () {
    Route::get('/', [AuthorController::class, 'dashboard'])->name('author.dashboard');
    Route::match(['get', 'post'], '/addComic', [AuthorController::class, 'addComic'])->name('author.addComic');
    Route::match(['get', 'post'], '/editComic/{id}', [AuthorController::class, 'editComic'])->name('author.editComic');
    Route::get('/viewComic/{id}', [AuthorController::class, 'viewComic'])->name('author.viewsComic');
    Route::get('/delete-comic/{id}', [AuthorController::class, 'deleteComic'])->name('author.delete_comic');
});

// Route::get('/author', [AuthorController::class, 'dashboard'])->name('author.dashboard');
// Route::match(['get', 'post'], '/author/addComic', [AuthorController::class, 'addComic'])->name('author.addComic');
// Route::match(['get', 'post'], '/author/editComic/{id}', [AuthorController::class, 'editComic'])->name('author.editComic');
// Route::get('/author/viewComic/{id}', [AuthorController::class, 'viewComic'])->name('author.viewsComic');
// Route::get('/author/delete-comic/{id}', [AuthorController::class, 'deleteComic'])->name('author.delete_comic');

// Route đăng ký
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route để hiển thị trang quên mật khẩu
Route::get('/forgot-password', function() {
    return view('forgot-password');
})->name('password.request');

//
Route::get('the-loai/{id}', [App\Http\Controllers\TheLoaiController::class, 'show'])->name('the-loai.show');
// Route::get('the-loai', [App\Http\Controllers\TheLoaiController::class, 'index'])->name('the-loai.index');


// Route::get('/truyen', [App\Http\Controllers\TruyenController::class, 'index'])->name('truyen.index');
Route::get('/truyen/{id}', [App\Http\Controllers\TruyenController::class, 'show'])->name('truyen.show');

// Thêm route cho rating
Route::post('/truyen/{truyen}/rating', [App\Http\Controllers\RatingController::class, 'store'])->name('rating.store');

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
Route::post('/chapter/{chapter}/comment', [ChapterController::class, 'storeComment'])->name('comment.store');

// Các route cho chức năng theo dõi
Route::post('/theo-doi/{id_truyen}', [TheoDoiController::class, 'toggleTheoDoi'])
    ->name('theo-doi.toggle')
    ->middleware('auth');

// Route hiển thị danh sách truyện theo dõi
Route::get('/theo-doi', [TheoDoiController::class, 'index'])->name('theo-doi.index')->middleware('auth');

// Route tìm kiếm truyện
Route::get('/search', [App\Http\Controllers\TruyenController::class, 'search'])->name('truyen.search');

// Route hiển thị tất cả truyện
Route::get('/truyen', [App\Http\Controllers\TruyenController::class, 'index'])->name('truyen.index');

// Thêm route cho hiển thị truyện theo thể loại
Route::get('/the-loai/{id}', [App\Http\Controllers\TheLoaiController::class, 'show'])->name('the-loai.show');

// Routes cho quản lý hồ sơ cá nhân
Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/password', [ProfileController::class, 'showPasswordForm'])->name('profile.password.form');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
});