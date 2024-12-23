<?php

use App\Http\Controllers\Admin\NotificationController as Admin_NotificationController;
use App\Http\Controllers\Admin\PortfolioController as Admin_PortfolioController;
use App\Http\Controllers\Admin\RequirementController as Admin_RequirementController;
use App\Http\Controllers\Admin\RoleController as Admin_RoleController;
use App\Http\Controllers\Admin\TaskController as Admin_TaskController;
use App\Http\Controllers\Admin\UserController as Admin_UserController;
use App\Http\Controllers\Admin\FileController as Admin_FileController;
use App\Http\Controllers\Admin\DashboardController as Admin_DashboardController;
use App\Http\Controllers\Admin\PermissionController as Admin_PermissionController;
use App\Http\Controllers\Admin\UploadController as Admin_UploadController;

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\User\DashboardController as User_DashboardController;
use App\Http\Controllers\User\PortfolioController as User_PortfolioController;
use App\Http\Controllers\User\FileController as User_FileController;
//use App\Http\Controllers\User\ArchiveController as User_ArchiveController;
use App\Http\Controllers\User\NotificationController as User_NotificationController;
use App\Http\Controllers\User\RequirementController as User_RequirementController;
use App\Http\Controllers\User\TaskController as User_TaskController;
//use App\Http\Controllers\User\ProgressController as User_ProgressController;
//use App\Http\Controllers\User\RecentController as User_RecentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===== ADMIN =====

// ===== USER =====


Route::get('/', function () {
    return view('../auth/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/tmp/upload', [UploadController::class, 'upload'])->name('tmp_upload');
Route::delete('/tmp/revert', [UploadController::class, 'revert'])->name('tmp_revert');
Route::get('/tmp/restore', [UploadController::class, 'restore'])->name('tmp_restore');
Route::get('/tmp/load', [UploadController::class, 'load'])->name('tmp_load');

Route::get('/attachments/{attachment}/view', [AttachmentController::class, 'show'])->name('attachments.view');
Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'downloadAttachment'])->name('attachments.download');



Route::group(['middleware' => ['auth']], function () {

    // ===== ADMIN =====
    Route::group([
        'prefix' => 'admin',
        'middleware' => ['role:admin|super-admin'],
        'as' => 'admin.',
    ], function () {
        // ===== DASHBOARD =====
        Route::resource('dashboard', Admin_DashboardController::class);

        // ===== NOTIFICATIONS =====
        Route::resource('notifications', Admin_NotificationController::class);

        // ===== REQUIREMENTS =====
        // Route::get('/api/get-group-data', [Admin_RequirementController::class, 'getGroupData']);
        Route::delete('/requirements/{requirement}/user/{user}', [Admin_RequirementController::class, 'deleteAssignedUser'])->name('requirements.user.delete');
        Route::resource('requirements', Admin_RequirementController::class);

        // ===== TASKS =====
        Route::post('/tasks/upload', [Admin_TaskController::class, 'upload'])->name('tasks.upload');
        Route::delete('/tasks/revert', [Admin_TaskController::class, 'revert'])->name('tasks.revert');
        Route::resource('tasks', Admin_TaskController::class);

        // ===== PORTFOLIO =====
        Route::resource('portfolios', Admin_PortfolioController::class);

        // ===== ROLES =====
        // Route::get('/roles/{role}/permissions', [Admin_RoleController::class, 'get_permissions'])->name('get_permissions');
        Route::get('/roles/{role}/assign-user-roles', [Admin_RoleController::class, 'assign_user_roles'])->name('assign_user_roles');
        Route::delete('/roles/{role}/remove-user/{user}', [Admin_RoleController::class, 'remove_user_from_role'])->name('remove_user_from_role');
        Route::post('/roles/{role}/store-user-roles', [Admin_RoleController::class, 'store_user_roles'])->name('store_user_roles');
        Route::get('/roles/{role}/assign-permissions', [Admin_RoleController::class, 'assign_permission'])->name('assign_permission');
        Route::post('/roles/{role}/store-permissions', [Admin_RoleController::class, 'store_permission'])->name('store_permission');
        Route::delete('/roles/{role}/remove-permission/{permission}', [Admin_RoleController::class, 'remove_permission_from_role'])->name('remove_permission_from_role');
        Route::resource('roles', Admin_RoleController::class);

        // ===== PERMISSIONS =====
        Route::resource('permissions', Admin_PermissionController::class);

        // ===== USERS =====
        Route::resource('/users', Admin_UserController::class);

        // ===== FILES =====
        Route::resource('files', Admin_FileController::class);

        // ===== FILEPOND =====
        Route::post('/file_upload', [UploadController::class, 'upload'])->name('file.upload');
        Route::delete('/file_revert', [UploadController::class, 'revert'])->name('file.revert');

        // ===== ATTACHMENTS =====
        Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
    });

    // ===== USER =====
    Route::group([
        'prefix' => 'user',
        'middleware' => ['role:user'],
        'as' => 'user.',
    ], function () {
        // ===== DASHBOARD =====
        Route::resource('dashboard', User_DashboardController::class);

        // ===== PORTFOLIO =====
        Route::resource('portfolios', User_PortfolioController::class);

        // ===== FILE MANAGER =====
        Route::resource('files', User_FileController::class);

        // ===== ARCHIVE =====
//        Route::resource('archives', User_ArchiveController::class);

        // ===== NOTIFICATION =====
        Route::resource('notifications', User_NotificationController::class);

        // ===== REQUIREMENTS =====
        Route::resource('requirements', User_RequirementController::class);

        // ===== TASKS =====
        Route::resource('tasks', User_TaskController::class);

        // ===== PROGRESS =====
        // ===== RECENT =====
    });
});


/*
Route::get('files/showTasks/{id}', [FileController::class, 'showTasks'])->name('tasks.showTasks')->middleware(['auth', 'verified']);
Route::resource('dashboard', DashboardController::class)->middleware(['auth', 'verified']);
Route::get('/requirements', [FileController::class, 'index'])->name('requirements.index');
Route::get('/requirements/{requirement}', [FileController::class, 'showRequirementFolders'])->name('requirements.show');
Route::get('/tasks/{task}', [FileController::class, 'showTaskFolders'])->name('tasks.show');
Route::resource('attachments', AttachmentController::class)->middleware(['auth', 'verified']);
*/

require __DIR__ . '/auth.php';
