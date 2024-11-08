<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('../auth/login');
});
//
//
//Route::resource('notifications', NotificationController::class)->middleware(['auth', 'verified']);
//
//// REQUIREMENTS
////Route::get('requirements/{id}/tasks', [RequirementController::class, 'tasks'])->name('requirementsTaskList')->middleware(['auth', 'verified']);
////Route::get('requirements/{id}/tasks/{taskId}', [TaskController::class, 'index'])->name('requirements.showTasks')->middleware(['auth', 'verified']);
//Route::delete('/requirements/{requirement}/user/{user}', [RequirementController::class, 'deleteAssignedUser'])->name('requirements.user.delete');
//Route::resource('requirements', RequirementController::class)->middleware(['auth', 'verified']);
//
//// TASKS
//Route::post('upload', [TaskController::class, 'upload'])->name('tasks.upload');
//Route::resource('/tasks', TaskController::class)->middleware(['auth', 'verified']);
//
//// PORTFOLIO
//Route::resource('portfolios', PortfolioController::class)->middleware(['auth', 'verified']);
//
//Route::resource('/users', UserController::class)->middleware(['auth', 'verified']);
//Route::resource('/files', FileController::class)->middleware(['auth', 'verified']); // todo (functionality): delete, download, view
//
//Route::get('files/showTasks/{id}', [FileController::class, 'showTasks'])->name('tasks.showTasks')->middleware(['auth', 'verified']);
///*
//Route::get('/requirements', [FileController::class, 'index'])->name('requirements.index');
//Route::get('/requirements/{requirement}', [FileController::class, 'showRequirementFolders'])->name('requirements.show');
//Route::get('/tasks/{task}', [FileController::class, 'showTaskFolders'])->name('tasks.show');
//*/
Route::resource('dashboard', DashboardController::class)->middleware(['auth', 'verified']);
Route::resource('attachments', AttachmentController::class)->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::group(['middleware' => ['auth']], function () {
//    Route::group([
//        'prefix' => 'admin',
//        'middleware' => ['is_admin'],
//        'as' => 'admin.'
//    ], function () {
//        Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class);
//        Route::resource('tasks', \App\Http\Controllers\Admin\RequirementController::class);
//        Route::resource('dashboard', \App\Http\Controllers\Admin\DashboardController::class);
//        Route::resource('portfolios', \App\Http\Controllers\Admin\PortfolioController::class);
//        Route::resource('/files', \App\Http\Controllers\Admin\FileController::class);
//        Route::resource('notifications', \App\Http\Controllers\Admin\NotificationController::class);
//        Route::resource('requirements', \App\Http\Controllers\Admin\RequirementController::class);
//    });
//
//    Route::group([
//        'prefix' => 'user',
//        'as' => 'admin.'
//    ], function () {
//        Route::resource('tasks', \App\Http\Controllers\User\TaskController::class);
//        Route::resource('tasks', \App\Http\Controllers\User\RequirementController::class);
//    });
//});


require __DIR__ . '/auth.php';
