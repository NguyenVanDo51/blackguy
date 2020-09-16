<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CrawlController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $tag = app()->make('tag');

    return $tag->getIsShow();
});

Route::redirect('home', '/');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [CourseController::class, 'searchWithCategory'])->name('course.search');

Auth::routes(['verify' => true]);

Route::get('/view/course/{course}', [CourseController::class, 'show'])->name('course.show');

Route::get('/view/tags/{tag}', [TagController::class, 'show'])->name('tag.show');

Route::get('/view/categories/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::middleware('auth')->group(function () {
    Route::get('/view/course/{course}/lession/{lession}', [LessionController::class, 'show'])->name('lession.index');

    Route::get('/profile/{function?}', [UserController::class, 'show'])->middleware('verified')->name('profile');

    Route::post('/profile/change/password', [UserController::class, 'changePassword'])->name('profile-password');
});

Route::get('ohoho', function () {
})->name('test');

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('admin/view/course', [AdminController::class, 'courses'])->name('admin');

    Route::view('admin/edit/course/create', 'pages.admin.addcourse')->name('view-add-course');

    Route::post('admin/course/add-course/success', [AdminController::class, 'addCourse'])->name('add-course');

    Route::get('admin/course/remove-course/{course?}', [AdminController::class, 'removeCourse'])->name('remove-course');

    Route::get('admin/course/edit-course/{course}', [AdminController::class, 'editCourse'])->name('edit-course');

    Route::post('admin/course/edit-course/success/{course}', [AdminController::class, 'handleEditCourse'])->name('handle-edit-course');

    Route::get('admin/course/search', [CourseController::class, 'search'])->name('admin-course-search');


    // Lession
    Route::get('admin/view/lession/{course}', [AdminController::class, 'viewLessions'])->name('view-lession');

    Route::get('admin/course/lession/create/{course}', [AdminController::class, 'viewAddLession'])->name('view-add-lession');

    Route::post('admin/course/add-lession/success/{course}', [AdminController::class, 'addLession'])->name('add-lession');

    Route::get('admin/course/{course}/lession/edit-lession/{lession}', [AdminController::class, 'viewEditLession'])->name('edit-lession');

    Route::post('admin/course/{course}/success/{lession}', [AdminController::class, 'handleEditLession'])->name('handle-edit-lession');

    Route::get('admin/course/remove-lession/{lession}', [AdminController::class, 'removeLession'])->name('remove-lession');

    Route::view('/admin/view/statistical', 'pages.admin.statistical')->name('statistical');

//    User route
    Route::get('admin/view/users', [UserController::class, 'userList'])->name('admin-user-list');

    Route::get('/admin/users/search', [UserController::class, 'search'])->name('admin-user-search');

    Route::get('admin/users/remove/{user}', [UserController::class, 'remove'])->name('admin-user-remove');

    Route::post('admin/users/password/{user}', [UserController::class, 'changePasswordAdmin'])->name('admin-user-edit');

// Tags
    Route::get('admin/tags/view', [TagController::class, 'show'])->name('admin-tag-view');

    Route::get('admin/tags/delete/{tag}', [TagController::class, 'delete'])->name('admin-tag-edit');

    Route::post('admin/tags/add', [TagController::class, 'add'])->name('admin-tag-add');

    Route::post('admin/tags/home', [TagController::class, 'showHome'])->name('admin-tag-home');

// Crawl
    Route::get('/admin/crawl/course', [CrawlController::class, 'index'])->name('admin-crawl-view');

    Route::post('admin/crawl/course/handle', [CrawlController::class, 'create'])->name('admin-crawl-handle');

    Route::get('admin/crawl/course/remove/{ProcessCrawl}', [CrawlController::class, 'destroy'])->name('admin-crawl-remove');

    Route::get('admin/crawl/course/failed-redispatch/{ProcessCrawl}', [CrawlController::class, 'update'])->name('admin-crawl-failed-redispatch');

    Route::get('admin/crawl/course/{job_id}/show', [CrawlController::class, 'show'])->name('admin-crawl-show');

    Route::post('admin/crawl/course/{job_id}/edit', [CrawlController::class, 'edit'])->name('admin-crawl-edit');


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

Route::get('repository', [UserController::class, 'getAll'])->name('repository');
