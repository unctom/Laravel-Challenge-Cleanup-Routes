<?php

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

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'books'], function () {
        Route::get('create', [\App\Http\Controllers\BookController::class, 'create'])->name('books.create');
        Route::post('store', [\App\Http\Controllers\BookController::class, 'store'])->name('books.store');
        Route::get('{book:slug}/report/create', [\App\Http\Controllers\BookReportController::class, 'create'])->name('books.report.create');
        Route::post('{book}/report', [\App\Http\Controllers\BookReportController::class, 'store'])->name('books.report.store');
    });


    Route::group(['prefix' => 'user'], function () {

        Route::get('books', [\App\Http\Controllers\BookController::class, 'index'])->name('user.books.list');
        Route::get('books/{book:slug}/edit', [\App\Http\Controllers\BookController::class, 'edit'])->name('user.books.edit');
        Route::put('books/{book:slug}', [\App\Http\Controllers\BookController::class, 'update'])->name('user.books.update');
        Route::delete('books/{book}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('user.books.destroy');

        Route::get('orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('user.orders.index');

        Route::get('settings', [\App\Http\Controllers\UserSettingsController::class, 'index'])->name('user.settings');
        Route::post('settings/{user}', [\App\Http\Controllers\UserSettingsController::class, 'update'])->name('user.settings.update');
        Route::post('settings/password/change/{user}', [\App\Http\Controllers\UserChangePassword::class, 'update'])->name('user.password.update');

    });
});

Route::get('books/{book:slug}', [\App\Http\Controllers\BookController::class, 'show'])->name('books.show');

Route::get('admin', \App\Http\Controllers\Admin\AdminDashboardController::class)->middleware('isAdmin')->name('admin.index');

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {

    Route::get('books', [\App\Http\Controllers\Admin\AdminBookController::class, 'index'])->name('admin.books.index');
    Route::get('books/create', [\App\Http\Controllers\Admin\AdminBookController::class, 'create'])->name('admin.books.create');
    Route::post('books', [\App\Http\Controllers\Admin\AdminBookController::class, 'store'])->name('admin.books.store');
    Route::get('books/{book}/edit', [\App\Http\Controllers\Admin\AdminBookController::class, 'edit'])->name('admin.books.edit');
    Route::put('books/{book}', [\App\Http\Controllers\Admin\AdminBookController::class, 'update'])->name('admin.books.update');
    Route::delete('books/{book}', [\App\Http\Controllers\Admin\AdminBookController::class, 'destroy'])->name('admin.books.destroy');
    Route::put('book/approve/{book}', [\App\Http\Controllers\Admin\AdminBookController::class, 'approveBook'])->name('admin.books.approve');

    Route::get('users', [\App\Http\Controllers\Admin\AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
});





require __DIR__ . '/auth.php';
