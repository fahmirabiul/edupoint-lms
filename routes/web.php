<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CourseIndex;
use App\Livewire\CourseShow;
use App\Livewire\MessageIndex;
use App\Livewire\Admin\Course\Index as AdminCourseIndex;
use App\Livewire\Admin\Course\Create as AdminCourseCreate;
use App\Livewire\Admin\Course\Edit as AdminCourseEdit;
use App\Livewire\Admin\Enrollment\Index as AdminEnrollmentIndex;
use App\Models\Course;

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

Route::view('/', 'welcome');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/courses', AdminCourseIndex::class)->name('courses.index');
    Route::get('/courses/create', AdminCourseCreate::class)->name('courses.create');
    Route::get('/courses/{id}/edit', AdminCourseEdit::class)->name('courses.edit');

    Route::get('/enrollments', AdminEnrollmentIndex::class)->name('enrollments.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/courses', CourseIndex::class)->name('courses.index');
    Route::get('/courses/{slug}', CourseShow::class)->name('courses.show');

    Route::get('/messages', MessageIndex::class)->name('messages.index');
});

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
