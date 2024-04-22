<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\ProfileController;
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
Route::get('/', [PaymentController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return redirect()->route('admin.payment.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/stripe', [ProfileController::class, 'stripe'])->name('profile.stripe');
    Route::post('/profile/updateSettings', [ProfileController::class, 'updateSettings'])->name('profile.updateSettings');
});
Route::middleware('auth')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('payment', PaymentController::class);
        Route::get('payment/copyCreate/{payment}', [PaymentController::class, 'copyCreate'])->name('payment.copyCreate');
});



Route::get('pay/{token}', [PayController::class, 'show'])->name('pay.show');
Route::post('pay/checkout/{payment}', [PayController::class, 'checkout'])->name('pay.checkout');
Route::get('success', [PayController::class, 'success'])->name('success');

// Route::get('email/payment_confirmation', [PaymentReceived::class, 'build'])->name(+)
require __DIR__.'/auth.php';
