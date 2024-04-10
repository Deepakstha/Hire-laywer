<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LawyerController;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/lawyer', [LawyerController::class, 'lawyer_page']);
Route::get('/lawyer/{id}', [LawyerController::class, 'lawyer_details']);
Route::get('/hire-lawyer-request', [LawyerController::class, 'displayHireLawyerRequest']);
Route::get('/accept-hire-request/{id}', [LawyerController::class, 'acceptHireRequest']);
Route::get('/delete-hire-request/{id}', [LawyerController::class, 'deleteHireRequest']);
Route::get('/book-appointment/{id}', [LawyerController::class, 'displayBookAppointmentForm']);
Route::post('/book-appointment', [LawyerController::class, 'bookAppointment']);
Route::get('/ratings', [LawyerController::class, 'lawyer_rating_form'])->middleware((['auth']));
Route::get('/clients', [LawyerController::class, 'displayClients']);
Route::get('/appointments', [LawyerController::class, 'displayAppointmentToLawyer']);
Route::get('/lawyer-appointment', [LawyerController::class, 'displayAppointmentForUser']);
Route::get('/delete-appointment/{id}', [LawyerController::class, 'deleteAppointment']);
// Route::get('/hire-lawyer', [LawyerController::class, 'hire_request_lawyer']);
Route::match(['get', 'post'], '/hire-lawyer', [LawyerController::class, 'hire_request_lawyer']);

Route::get("/message/{id}", [MessageController::class, 'fetchMessages']);
Route::get("/send-message", [MessageController::class, 'sendMessage']);
Route::get("/lawyer-message", [LawyerController::class, 'displayClientsForMessage']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/lawyer-dashboard', [LawyerController::class, 'lawyer_dashboard'])
    ->middleware(['auth', 'verified', 'checkLawyerRole'])
    ->name('lawyer-dashboard');

Route::get("/admin-dashboard", [AdminController::class, "admin_dashboard"])->middleware((['auth']))->name('admin-dashboard');
Route::get("/lawyer-request", [AdminController::class, "displayLawyerRequest"]);
Route::get("/accept-lawyer-request/{id}", [AdminController::class, "acceptLawyerRequest"]);

// Route::get('/lawyer-dashboard', function () {
//     return view('lawyer-dashboard');
// })->middleware(['auth', 'verified', 'checkLawyerRole'])->name('lawyer-dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
