<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\LoanHistoryController;
use App\Http\Controllers\ELibraryController;
use App\Http\Controllers\OpacController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardPustakawanController;
use App\Http\Controllers\DashboardAnggotaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmailVerificationController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [LandingController::class, 'index']
)->name('landing');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

// Route::get(
//     '/login',
//     [AuthController::class, 'login']
// )->name('login');

Route::post(
    '/login',
    [AuthController::class, 'loginPost']
)->name('login.post');

Route::get(
    '/register',
    [AuthController::class, 'register']
)->name('register');

Route::get(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');

Route::get(
    '/login',
    [LoginController::class, 'login']
)->name('login');

Route::post(
    '/login',
    [LoginController::class, 'authenticate']
)->name('login.post');

Route::get(
    '/register',
    [RegisterController::class, 'create']
)->name('register');

Route::post(
    '/register',
    [RegisterController::class, 'store']
)->name('register.store');


/*
|--------------------------------------------------------------------------
| DASHBOARD ROLE
|--------------------------------------------------------------------------
*/

// ADMIN
Route::get(
    '/admin/dashboard',
    [DashboardAdminController::class, 'index']
)
    ->middleware('permission:dashboard,view')
    ->name('admin.dashboard');

// PUSTAKAWAN
Route::get(
    '/pustakawan/dashboard',
    [DashboardPustakawanController::class, 'index']
)
    ->middleware('permission:dashboard,view')
    ->name('pustakawan.dashboard');

// ANGGOTA
Route::get(
    '/anggota/dashboard',
    [DashboardAnggotaController::class, 'index']
)
    ->middleware('permission:dashboard,view')
    ->name('anggota.dashboard');
/*
|--------------------------------------------------------------------------
| OPAC PUBLIC
|--------------------------------------------------------------------------
*/

Route::get(
    '/opac',
    [OpacController::class, 'index']
)->name('opac.index');

Route::get(
    '/opac/{book}',
    [OpacController::class, 'show']
)->name('opac.show');


/*
|--------------------------------------------------------------------------
| ADMIN & PUSTAKAWAN
|--------------------------------------------------------------------------
*/

// BOOKS
Route::get(
    '/books',
    [BookController::class, 'index']
)
    ->middleware('permission:books,view')
    ->name('books.index');

Route::get(
    '/books/create',
    [BookController::class, 'create']
)
    ->middleware('permission:books,create')
    ->name('books.create');

Route::post(
    '/books',
    [BookController::class, 'store']
)
    ->middleware('permission:books,create')
    ->name('books.store');

Route::get(
    '/books/{book}',
    [BookController::class, 'show']
)
    ->middleware('permission:books,view')
    ->name('books.show');

Route::get(
    '/books/{book}/edit',
    [BookController::class, 'edit']
)
    ->middleware('permission:books,edit')
    ->name('books.edit');

Route::put(
    '/books/{book}',
    [BookController::class, 'update']
)
    ->middleware('permission:books,edit')
    ->name('books.update');

Route::delete(
    '/books/{book}',
    [BookController::class, 'destroy']
)
    ->middleware('permission:books,delete')
    ->name('books.destroy');

// MEMBERS

Route::get(
    '/members',
    [MemberController::class, 'index']
)
    ->middleware('permission:users,view')
    ->name('members.index');

Route::get(
    '/members/create',
    [MemberController::class, 'create']
)
    ->middleware('permission:users,create')
    ->name('members.create');

Route::post(
    '/members',
    [MemberController::class, 'store']
)
    ->middleware('permission:users,create')
    ->name('members.store');

Route::get(
    '/members/{member}',
    [MemberController::class, 'show']
)
    ->middleware('permission:users,view')
    ->name('members.show');

Route::get(
    '/members/{member}/edit',
    [MemberController::class, 'edit']
)
    ->middleware('permission:users,edit')
    ->name('members.edit');

Route::put(
    '/members/{member}',
    [MemberController::class, 'update']
)
    ->middleware('permission:users,edit')
    ->name('members.update');

Route::delete(
    '/members/{member}',
    [MemberController::class, 'destroy']
)
    ->middleware('permission:users,delete')
    ->name('members.destroy');

// MEMBER CARD
Route::get(
    '/members/{member}/card',
    [MemberController::class, 'card']
)
    ->middleware('permission:users,print')
    ->name('members.card');

// REPORTS
Route::get(
    '/reports',
    [ReportController::class, 'index']
)
    ->middleware('permission:reports,view')
    ->name('reports.index');

// EXPORT PDF
Route::get(
    '/reports/export/pdf',
    [ReportController::class, 'exportPdf']
)
    ->middleware('permission:reports,print')
    ->name('reports.export.pdf');

// EXPORT EXCEL
Route::get(
    '/reports/export/excel',
    [ReportController::class, 'exportExcel']
)
    ->middleware('permission:reports,export')
    ->name('reports.export.excel');

//STATISTICS
Route::get(
    '/statistics',
    [StatisticController::class, 'index']
)
    ->middleware('permission:reports,view')
    ->name('statistics.index');

//MANAJEMEN HAK AKSES
Route::get(
    '/users',
    [UserController::class, 'index']
)
    ->middleware('permission:users,view')
    ->name('users.index');

/*
|--------------------------------------------------------------------------
| PUSTAKAWAN
|--------------------------------------------------------------------------
*/

// LOANS
Route::get(
    '/loans',
    [LoanController::class, 'index']
)
    ->middleware('permission:loans,view')
    ->name('loans.index');

Route::get(
    '/loans/create',
    [LoanController::class, 'create']
)
    ->middleware('permission:loans,create')
    ->name('loans.create');

Route::post(
    '/loans/store',
    [LoanController::class, 'store']
)
    ->middleware('permission:loans,create')
    ->name('loans.store');


// RETURNS
Route::get(
    '/returns',
    [ReturnController::class, 'index']
)
    ->middleware('permission:returns,view')
    ->name('returns.index');

Route::post(
    '/returns/process',
    [ReturnController::class, 'process']
)
    ->middleware('permission:returns,create')
    ->name('returns.process');


// RESERVASI PUSTAKAWAN
Route::get(
    '/reservations',
    [ReservationController::class, 'index']
)
    ->middleware('permission:reservations,view')
    ->name('reservations.pustakawan');

Route::post(
    '/reservations/store',
    [ReservationController::class, 'store']
)
    ->middleware('permission:reservations,create')
    ->name('reservations.store');

Route::put(
    '/reservations/{reservation}/approve',
    [ReservationController::class, 'approve']
)
    ->middleware('permission:reservations,edit')
    ->name('reservations.approve');

Route::put(
    '/reservations/{reservation}/cancel',
    [ReservationController::class, 'cancel']
)
    ->middleware('permission:reservations,edit')
    ->name('reservations.cancel');

Route::get(
    '/pustakawan/reservations',
    [ReservationController::class, 'index']
)->name('reservations.pustakawan');


/*
|--------------------------------------------------------------------------
| Anggota
|--------------------------------------------------------------------------
*/

// LOAN HISTORY
Route::get(
    '/loan-history',
    [LoanHistoryController::class, 'anggota']
)->name('loan-history.index');


// RESERVASI anggota
Route::get(
    '/reservations/anggota',
    [ReservationController::class, 'anggota']
)->name('reservations.anggota');

// E-LIBRARY
Route::get(
    '/elibrary',
    [ELibraryController::class, 'index']
)->name('elibrary.index');

Route::get(
    '/elibrary/{digitalBook}/read',
    [ELibraryController::class, 'read']
)->name('elibrary.read');

Route::get(
    '/elibrary/{digitalBook}',
    [ELibraryController::class, 'show']
)->name('elibrary.show');

// NOTIFIKASI
Route::get(
    '/notifications',
    [NotificationController::class, 'index']
)->name('notifications.index');

// PERMISSION
Route::get(
    '/admin/permissions',
    [PermissionController::class, 'index']
)
    ->middleware('permission:users,edit')
    ->name('permissions.index');

Route::post(
    '/admin/permissions/update',
    [PermissionController::class, 'update']
)
    ->middleware('permission:users,edit')
    ->name('permissions.update');

//PROFIL//
Route::get(
    '/profile',
    [ProfileController::class, 'index']
)->name('profile.index');

Route::get(
    '/profile/edit',
    [ProfileController::class, 'edit']
)->name('profile.edit');

Route::put(
    '/profile/update',
    [ProfileController::class, 'update']
)->name('profile.update');

// EMAIL VERIFICATION
Route::get(
    '/verify-email',
    [EmailVerificationController::class, 'showForm']
)->name('verify.email');

Route::post(
    '/verify-email',
    [EmailVerificationController::class, 'verify']
)->name('verify.email.submit');

Route::post(
    '/resend-otp',
    [EmailVerificationController::class, 'resendOtp']
)->name('resend.otp');
