<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::redirect('home', '/');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search/{category?}', [HomeController::class, 'search'])->name('search');

Auth::routes();

Route::get('/view/course/{course}', [HomeController::class, 'viewCourse'])->name('course');

Route::get('/view/tags/{tag}', [CourseController::class, 'tags'])->name('tags');

Route::get('/view/categories/{category}', [CourseController::class, 'categories'])->name('categories');

Route::middleware('auth')->group(function () {
    Route::get('/view/course/{course}/lession/{lession}', [CourseController::class, 'lession'])->name('lession');

    Route::get('/profile/{function?}', [UserController::class, 'profile'])->name('profile');

    Route::get('admin/{function?}/{course?}/{lession?}', [AdminController::class, 'dashboard'])->middleware('can:admin')->name('admin');

    Route::post('admin/course/add-course/success', [AdminController::class, 'addCourse'])->name('add-course');

    Route::post('admin/course/add-lession/success/{course}', [AdminController::class, 'addLession'])->name('add-lession');

    Route::get('admin/course/remove-course/{course?}', [AdminController::class, 'removeCourse'])->name('remove-course');

    Route::get('functionadmin/remove-lession/{lession}', [AdminController::class, 'removeLession'])->name('remove-lession');

    Route::get('admin/course/edit-course/{course}', [AdminController::class, 'editCourse'])->name('edit-course');

    Route::post('admin/course/edit-course/success/{course}', [AdminController::class, 'handleEditCourse'])->name('handle-edit-course');

    Route::post('admin/course/lession/edit-lession/{course}={lession}', [AdminController::class, 'handleEditLession'])->name('edit-lession');

});

Route::get('handle', function (Request $request) {
    if ($request->ajax()) {
        // ghi thoi gian phat video

        Auth::user()->lessions()
            ->where('lession_id', $request->lession_id)
            ->update([
                'timer' => $request->timer
            ]);

        if ($request->timer >= $request->total / 2) {
            Auth::user()->lessions()
                ->where('lession_id', $request->lession_id)
                ->update([
                    'is_finish' => true
                ]);
        };
    }
})->name('handle');
