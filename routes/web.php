<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LightAppController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\OperationLogController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Jobs\ConfigClearJob;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect(route('dashboard'));
});
Route::get('clear', function () {
    Artisan::call('config:clear');
    ConfigClearJob::dispatch();
    return "cleared";
});

Route::get('dummydata',function(){
    return view('dummy');
});
Route::post('voice',[UserController::class,'voice'])->name('voice');

//Suspend user middleware wil also use for IPaddress in future
Route::middleware(['blockIP'])->group(function () {
    //login routes
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::post('setfacesupport', [LoginController::class, 'SupportFace'])->name('SupportFace');
    Route::post('imagelogin', [LoginController::class, 'ImageLogin'])->name('ImageLogin');
    Route::post('voicelogin', [LoginController::class, 'VoiceLogin'])->name('VoiceLogin');
    Route::get('checkfacedata', [LoginController::class, 'CheckFaceData'])->name('CheckFaceData');

    //all routs which require authenticated user under this
    Route::middleware(['auth'])->group(static function () {
        Route::post('registerfacedata', [LoginController::class, 'RegisterFacedata'])->name('RegisterFacedata');
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
        Route::post('profilepic', [UserController::class, 'ProfilePic'])->name('ProfilePic');
        //search
        Route::get('search', [SearchController::class, 'search'])->name('search');
    });

    //Logs
    Route::get('Graph-Data', [OverviewController::class, 'getGraphData'])->name('Graph.Data');
    Route::get('get-data', [OverviewController::class, 'getData'])->name('get.data');
    Route::get('Overviews', [OverviewController::class, 'index'])->name('Overviews');
    Route::get('export-overview', [OverviewController::class, 'exportOverview'])->name('export.overview');
    Route::get('export-pdf', [OverviewController::class, 'exportPdf'])->name('export.pdf');
    Route::get('chart-logs/userId', [OverviewController::class, 'chartsData'])->name('chartLogs.userId');
    Route::get('group-usage/userId', [OverviewController::class, 'GroupusageData'])->name('groupUusage.userId');
    Route::get('logs', [LoginLogController::class, 'index'])
    ->name('logs')->middleware('checkPermis.backendManagement');
    Route::get('login-logs/filter', [LoginLogController::class, 'filter'])->name('loginLogs.filter');
    Route::get('users/role/{roleId}', [UserController::class, 'getUsersByRole'])->name('users.byRole');
    Route::get('filter-records', [LoginLogController::class, 'filterRecords'])->name('filter.records');;
    //operation
    Route::get('activities', [ActivityController::class, 'index'])->middleware('auth');
    Route::get('operation_logs', [OperationLogController::class, 'index'])
    ->name('operation_logs')->middleware('checkPermis.backendManagement');
    Route::get('operation-logs/filter', [OperationLogController::class, 'filter'])->name('operationLogs.filter');
    Route::get('users/role/{roleId}', [UserController::class, 'getUsersByRole'])->name('users.byRole');
    Route::get('filter-record', [OperationLogController::class, 'filterRecords'])->name('filter.record');;
    //end
    //EXCELL
    Route::get('export-logins', [LoginLogController::class, 'export'])->name('export.logins');
    Route::get('export-operation', [OperationLogController::class, 'export'])->name('export.operations');
    //END
    Route::delete('delete-message', [MessageController::class, 'destroy'])->name('delete-message');
    // Light app start
    Route::get('lightapp', [LightAppController::class, 'index'])->name('lightapp');
    Route::post('createlightapp', [LightAppController::class, 'createLightApp'])->name('createlightapp');
    Route::post('updatelightapp', [LightAppController::class, 'updateLightApp'])->name('updatelightapp');
    Route::get('showlightapp', [LightAppController::class, 'allLightApps'])->name('showlightapp');
    Route::get('desktopapp', [LightAppController::class, 'alladdedapps'])->name('desktopapp');
    //Route::get('list', [LightAppController::class, 'index']);
    //Route::get('add-form', [LightAppController::class, 'add_form']);
    Route::post('submit', [LightAppController::class, 'add_data']);
    Route::get('app_role_list/{type}', [LightAppController::class, 'AppRoleList']);
    Route::post('apps-update/{id}', [LightAppController::class, 'update']);
    Route::get('apps-delete/{id}', [LightAppController::class, 'delete_data']);
    Route::post('add-apps-desktop/{id}', [LightAppController::class, 'apps']);
    //end
    //search
    Route::get('search', [SearchController::class, 'search'])->name('search');
    Route::get('openiframe', [SearchController::class, 'listalliframe'])->name('openiframe');
    Route::get('closeiframe', [SearchController::class, 'closeiframe'])->name('closeiframe');
    //
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('desktop', [HomeController::class, 'desktop'])->name('desktop');
    //user routes
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/{id}', [UserController::class, 'index']);
    Route::get('user-add', [UserController::class, 'add'])->name('user-add');
    Route::post('user-create', [UserController::class, 'create'])->name('user-create');
    Route::get('user-edit/', [UserController::class, 'edit'])->name('user-edit');
    Route::post('user-update/{id}', [UserController::class, 'update'])->name('user-update');
    Route::get('user-delete/{id}', [UserController::class, 'destroy'])->name('user-delete');
    Route::get('usersList', [UserController::class, 'usersList'])->name('user-list');
    Route::post('importusers', [UserController::class, 'importUsers'])->name('importusers');
    Route::get('user-suspend/{id}', [UserController::class, 'suspend'])->name('user-suspend');
    Route::get('useradmin', [UserController::class, 'userAdmin'])
    ->name('useradmin')->middleware('checkPermis.userManagement');
    Route::get('usergroups', [UserController::class, 'userGroup'])->name('usergroups');
    Route::get('rolesadmin', [RolesController::class, 'roles'])
    ->name('rolesadmin')->middleware('checkPermis.roleManagement');
    Route::get('permissionsadmin', [PermissionsController::class, 'permissions'])
    ->name('permissionsadmin')->middleware('checkPermis.userManagement');
    //roles routes
    Route::get('roles', [RolesController::class, 'index'])->name('roles');
    Route::get('roles/{id}', [RolesController::class, 'index']);
    Route::get('role-add', [RolesController::class, 'add'])->name('role-add');
    Route::post('role-create', [RolesController::class, 'create'])->name('role-create');
    Route::get('role-edit', [RolesController::class, 'edit'])->name('role-edit');
    Route::post('role-update/{id}', [RolesController::class, 'update'])->name('role-update');
    Route::get('role-delete/{id}', [RolesController::class, 'destroy'])->name('role-delete');
    Route::get('rolesList', [RolesController::class, 'rolesList'])->name('role-list');
    //permissions routes
    Route::get('permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::get('permissions/{id}', [PermissionsController::class, 'index']);
    Route::get('permission-add', [PermissionsController::class, 'add'])->name('permission-add');
    Route::post('permission-create', [PermissionsController::class, 'create'])->name('permission-create');
    Route::get('permission-edit', [PermissionsController::class, 'edit'])->name('permission-edit');
    Route::post('permission-update/{id}', [PermissionsController::class, 'update'])->name('permission-update');
    Route::get('permission-delete/{id}', [PermissionsController::class, 'destroy'])->name('permission-delete');
    Route::get('permissionsList', [PermissionsController::class, 'permissionsList'])->name('permission-list');
    //group routes
    Route::get('groups', [GroupController::class, 'index'])->name('groups');
    Route::get('groups/{id}', [GroupController::class, 'index']);
    Route::get('group-add', [GroupController::class, 'add'])->name('group-add');
    Route::post('group-create', [GroupController::class, 'create'])->name('group-create');
    Route::get('group-edit', [GroupController::class, 'edit'])->name('group-edit');
    Route::post('group-update/{id}', [GroupController::class, 'update'])->name('group-update');
    Route::get('group-delete/{id}', [GroupController::class, 'destroy'])->name('group-delete');
    /// Filemanager
    Route::get('filemanager/{path?}', [FileManagerController::class, 'index'])
    ->where('path', '.*')->name('filemanager')->middleware('checkPermis.fileManager');
    Route::get('createfolder', [FileManagerController::class, 'createFolder'])->name('createfolder');
    Route::get('createfile', [FileManagerController::class, 'createFile'])->name('createfile');
    Route::get('editfile/{file}', [FileManagerController::class, 'editfile'])->where('name', '.*')->where('file', '.*')->name('editfile');
    Route::get('showpathdetail', [FileManagerController::class, 'pathfiledetail'])->name('showpathdetail');
    Route::post('upload', [FileManagerController::class, 'upload'])->name('upload');
    Route::post('upload/remove', [FileManagerController::class, 'remove'])->name('upload.remove');
    Route::post('upload/pause', [FileManagerController::class, 'pause'])->name('upload.pause');
    Route::post('upload/resume', [FileManagerController::class, 'resume'])->name('upload.resume');
    Route::post('upload/pause-all', [FileManagerController::class, 'pauseAll'])->name('upload.pauseAll');
    Route::post('upload/clear-all', [FileManagerController::class, 'clearAll'])->name('upload.clearAll');
    Route::post('upload/clear-out', [FileManagerController::class, 'clearOut'])->name('upload.clearOut');
    Route::get('download/{id}', [FileManagerController::class, 'downloadFile']);
    Route::get('renamefile', [FileManagerController::class, 'renameFile'])->name('renamefile');
    Route::get('deletefile', [FileManagerController::class, 'deleteFile'])->name('deletefile');
    Route::get('copyfile', [FileManagerController::class, 'copyFile'])->name('copyfile');
    Route::get('pastefile', [FileManagerController::class, 'pasteFile'])->name('pastefile');
    Route::get('contextmenu', [FileManagerController::class, 'contextMenu'])->name('contextmenu');
    Route::get('dotsviewer/{type}/{file}', [FileManagerController::class, 'editfile'])->where('name', '.*')
    ->where('file', '.*')->name('createDocuments');
    //comments
    Route::get('getUsers', [MessageController::class, 'getUsers'])->name('getUsers');
    Route::post('saveComment', [MessageController::class, 'saveCommentOrReply'])->name('saveComment');
    // Route::post('sendReply', [MessageController::class, 'sendReply'])->name('sendReply');
    Route::get('getMessage', [MessageController::class, 'getMessageData'])->name('getMessageData');
});


Route::get('login-logs/filter', [LoginLogController::class, 'filter'])->name('loginLogs.filter');


// Light app start

Route::get('lightapp', [LightAppController::class, 'index'])->name('lightapp');
Route::post('createlightapp', [LightAppController::class, 'createLightApp'])->name('createlightapp');
Route::post('updatelightapp', [LightAppController::class, 'updateLightApp'])->name('updatelightapp');
Route::get('showlightapp', [LightAppController::class, 'allLightApps'])->name('showlightapp');
Route::get('desktopapp', [LightAppController::class, 'alladdedapps'])->name('desktopapp');
//Route::get('list', [LightAppController::class, 'index']);
//Route::get('add-form', [LightAppController::class, 'add_form']);

Route::post('submit', [LightAppController::class, 'add_data']);
Route::get('app_role_list/{type}', [LightAppController::class, 'AppRoleList']);
Route::post('apps-update/{id}', [LightAppController::class, 'update']);
Route::get('apps-delete/{id}', [LightAppController::class, 'delete_data']);
Route::post('add-apps-desktop/{id}', [LightAppController::class, 'apps']);

Route::get('contextmenu', [FileManagerController::class, 'contextMenu'])->name('contextmenu');
Route::get('fileExpSearch', [FileManagerController::class, 'fileExpSearch'])->name('fileExp-list');

