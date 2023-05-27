<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyPayrollController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\MyAttendanceController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\CheckInCheckOutController;
use App\Http\Controllers\Auth\WebAuthnLoginController;
use App\Http\Controllers\Auth\WebAuthnRegisterController;
use App\Http\Controllers\CheckinCheckoutController as ControllersCheckinCheckoutController;

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


Auth::routes(['register' => false]);

Route::get('login/option', [LoginController::class, 'loginOption'])->name('login-option');

Route::post('webauthn/register/options', [WebAuthnRegisterController::class, 'options'])
     ->name('webauthn.register.options');
Route::post('webauthn/register', [WebAuthnRegisterController::class, 'register'])
     ->name('webauthn.register');

Route::post('webauthn/login/options', [WebAuthnLoginController::class, 'options'])
     ->name('webauthn.login.options');
Route::post('webauthn/login', [WebAuthnLoginController::class, 'login'])
     ->name('webauthn.login');

Route::get('/checkin-checkout', [CheckinCheckoutController::class, 'CheckInCheckOut']);
Route::post('/checkin-checkout/store', [CheckInCheckOutController::class, 'CheckInCheckOutStore']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');

    Route::resource('employee', EmployeeController::class);
    Route::get('employee/datatable/ssd', [EmployeeController::class, 'ssd']);

    Route::resource('salary', SalaryController::class);
    Route::get('salary/datatable/ssd', [SalaryController::class, 'ssd']);

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.profile');
    Route::post('/profile/biometric-data', [ProfileController::class, 'biometricData']);
    Route::delete('/profile/biometric-data/delete/{id}', [ProfileController::class, 'biometricDataDestroy']);
    
    Route::resource('department', DepartmentController::class);
    Route::get('department/datatable/ssd', [DepartmentController::class, 'ssd']);

    Route::resource('role', RoleController::class);
    Route::get('role/datatable/ssd', [RoleController::class, 'ssd']);

    Route::resource('permission', PermissionController::class);
    Route::get('permission/datatable/ssd', [PermissionController::class, 'ssd']);

    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance/datatable/ssd', [AttendanceController::class, 'ssd']);

    Route::get('attendance-overview', [AttendanceController::class, 'overview'])->name('attendance.overview');
    Route::get('attendance-overview-table', [AttendanceController::class, 'overviewTable']);

    Route::get('attendance-scan', [AttendanceScanController::class, 'scan'])->name('attendance-scan');
    Route::post('attendance-scan/store', [AttendanceScanController::class, 'scanStore'])->name('attendance-scan.store');
    Route::get('my-attendance-overview-table', [MyAttendanceController::class, 'overviewTable']);
    Route::get('my-attendance/datatable/ssd', [MyAttendanceController::class, 'ssd']);
    Route::get('my-payroll-table', [MyPayrollController::class, 'payrollTable']);

    Route::resource('company-setting', CompanySettingController::class)->only(['show', 'edit', 'update']);

    Route::get('payroll', [PayrollController::class, 'payroll'])->name('payroll');
    Route::get('payroll-table', [PayrollController::class, 'payrollTable']);

    Route::resource('project', ProjectController::class);
    Route::get('project/datatable/ssd', [ProjectController::class, 'ssd']);

    Route::resource('my-project', MyProjectController::class)->only(['index', 'show']);
    Route::get('my-project/datatable/ssd', [MyProjectController::class, 'ssd']);

    Route::resource('task', TaskController::class);
    Route::get('task-data', [TaskController::class, 'taskData']);
    Route::get('task-sortable', [TaskController::class, 'taskSortable']);
});