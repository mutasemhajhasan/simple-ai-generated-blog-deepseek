<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    RegisteredUserController,
    PasswordResetLinkController,
    NewPasswordController,
    EmailVerificationPromptController,
    VerifyEmailController,
    EmailVerificationNotificationController,
    ConfirmablePasswordController
};
use App\Http\Controllers\{
    CategoryController,
    CommentController,
    HomeController,
    PostController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Posts Routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->whereNumber('post');

// Public Category View Route
Route::get('/categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Registration Routes
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Posts Management
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->whereNumber('post');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update')->whereNumber('post');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->whereNumber('post');

    // Categories Management
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Comments Management
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store')
        ->whereNumber('post');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update')
        ->whereNumber('comment');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy')
        ->whereNumber('comment');
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])
        ->name('comments.approve')
        ->whereNumber('comment')
        ->middleware('can:approve,App\Models\Comment');

    // Email Verification
    Route::get('/verify-email', [EmailVerificationPromptController::class, 'show'])
        ->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Password Confirmation
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
