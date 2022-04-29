<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\CollegeController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\ClassroomController;
use App\Http\Controllers\API\BatchController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\CollegeDepartmentController;
use App\Http\Controllers\API\DepartmentClassroomController;
use App\Http\Controllers\API\ClassroomBatchController;
use App\Http\Controllers\API\AssignmentController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AssignmentSubmissionController;
use App\Http\Controllers\API\PracticalController;
use App\Http\Controllers\API\PracticalSubmissionController;
use App\Http\Controllers\API\BatchTeacherSubjectController;
use App\Http\Controllers\API\BatchStudentController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\SpecialActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::post('/signup', [AuthController::class, 'register']);
    Route::post('/signin', [AuthController::class, 'login'])->name('login');
    Route::post('/token-refresh', [AuthController::class, 'refresh']);
    Route::post('/signout', [AuthController::class, 'signout']);
});

Route::group(['prefix' => 'roles'], function ($router) {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/{id}/show', [RoleController::class, 'show'])->name('roles.show');
});

Route::group(['prefix' => 'users'], function ($router) {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::get('/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('/{id}/show', [UserController::class, 'show'])->name('users.show');
    Route::post('/import', [UserController::class ,'import'])->name('users.import');
    Route::post('/update-roll-numbers', [UserController::class ,'updateRollNumbers'])->name('users.updateRollNumbers');
    Route::get('/getAllCollegeAdmins',[UserController::class,'getAllCollegeAdmins'])->name('users.get-all-college-admins');
});

Route::group(['prefix' => 'colleges'], function ($router) {
    Route::get('/', [CollegeController::class, 'index'])->name('colleges.index');
    Route::post('/store', [CollegeController::class, 'store'])->name('colleges.store');
    Route::get('/{id}/edit', [CollegeController::class, 'edit'])->name('colleges.edit');
    Route::put('/{id}/update', [CollegeController::class, 'update'])->name('colleges.update');
    Route::get('/{id}/delete', [CollegeController::class, 'delete'])->name('colleges.delete');
    Route::get('/{id}/show', [CollegeController::class, 'show'])->name('colleges.show');
});

Route::group(['prefix' => 'departments'], function ($router) {
    Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/{id}/update', [DepartmentController::class, 'update'])->name('departments.update');
    Route::get('/{id}/delete', [DepartmentController::class, 'delete'])->name('departments.delete');
    Route::get('/{id}/show', [DepartmentController::class, 'show'])->name('departments.show');
});

Route::group(['prefix' => 'classrooms'], function ($router) {
    Route::get('/', [ClassroomController::class, 'index'])->name('classrooms.index');
    Route::post('/store', [ClassroomController::class, 'store'])->name('classrooms.store');
    Route::get('/{id}/edit', [ClassroomController::class, 'edit'])->name('classrooms.edit');
    Route::put('/{id}/update', [ClassroomController::class, 'update'])->name('classrooms.update');
    Route::get('/{id}/delete', [ClassroomController::class, 'delete'])->name('classrooms.delete');
    Route::get('/{id}/show', [ClassroomController::class, 'show'])->name('classrooms.show');
});

Route::group(['prefix' => 'batches'], function ($router) {
    Route::get('/', [BatchController::class, 'index'])->name('batches.index');
    Route::post('/store', [BatchController::class, 'store'])->name('batches.store');
    Route::get('/{id}/edit', [BatchController::class, 'edit'])->name('batches.edit');
    Route::put('/{id}/update', [BatchController::class, 'update'])->name('batches.update');
    Route::get('/{id}/delete', [BatchController::class, 'delete'])->name('batches.delete');
    Route::get('/{id}/show', [BatchController::class, 'show'])->name('batches.show');
});

Route::group(['prefix' => 'subjects'], function ($router) {
    Route::get('/', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/store', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/{id}/update', [SubjectController::class, 'update'])->name('subjects.update');
    Route::get('/{id}/delete', [SubjectController::class, 'delete'])->name('subjects.delete');
    Route::get('/{id}/show', [SubjectController::class, 'show'])->name('subjects.show');
});

Route::group(['prefix' => 'college-departments'], function ($router) {
    Route::get('/{college_id}', [CollegeDepartmentController::class, 'index'])->name('college-departments.index');
    Route::post('/store', [CollegeDepartmentController::class, 'store'])->name('college-departments.store');
    Route::get('/{id}/edit', [CollegeDepartmentController::class, 'edit'])->name('college-departments.edit');
    Route::put('/{id}/update', [CollegeDepartmentController::class, 'update'])->name('college-departments.update');
    Route::get('/{id}/delete', [CollegeDepartmentController::class, 'delete'])->name('college-departments.delete');
});

Route::group(['prefix' => 'department-classrooms'], function ($router) {
    Route::get('/{department_id}', [DepartmentClassroomController::class, 'index'])->name('department-classrooms.index');
    Route::post('/store', [DepartmentClassroomController::class, 'store'])->name('department-classrooms.store');
    Route::get('/{id}/edit', [DepartmentClassroomController::class, 'edit'])->name('department-classrooms.edit');
    Route::put('/{id}/update', [DepartmentClassroomController::class, 'update'])->name('department-classrooms.update');
    Route::get('/{id}/delete', [DepartmentClassroomController::class, 'delete'])->name('department-classrooms.delete');
});

Route::group(['prefix' => 'classroom-batches'], function ($router) {
    Route::get('/{classroom_id}', [ClassroomBatchController::class, 'index'])->name('classroom-batches.index');
    Route::post('/store', [ClassroomBatchController::class, 'store'])->name('classroom-batches.store');
    Route::get('/{id}/edit', [ClassroomBatchController::class, 'edit'])->name('classroom-batches.edit');
    Route::put('/{id}/update', [ClassroomBatchController::class, 'update'])->name('classroom-batches.update');
    Route::get('/{id}/delete', [ClassroomBatchController::class, 'delete'])->name('classroom-batches.delete');
});

Route::group(['prefix' => 'reset-password'], function ($router) {
    Route::post('/generate-otp',[ResetPasswordController::class, 'generateOTP']);
    Route::post('/{unique_identifier}/check-otp',[ResetPasswordController::class, 'checkOTP']);
    Route::post('/{unique_identifier}/change-password',[ResetPasswordController::class, 'resetPassword']);
    Route::get('/{unique_identifier}/check-status',[ResetPasswordController::class, 'checkStatus']);
});

Route::group(['prefix' => 'batch-teacher-subjects'], function ($router) {
    Route::get('/getTeacherSubjects',[BatchTeacherSubjectController::class, 'getTeacherSubjects']);
    Route::get('/{subject_id}/getTeacherClassrooms',[BatchTeacherSubjectController::class, 'getTeacherClassrooms']);
    Route::get('/{classroom_id}/getTeacherBatches',[BatchTeacherSubjectController::class, 'getTeacherBatches']);
});

Route::group(['prefix' => 'batch-students'], function ($router) {
    Route::get('/getAllStudentBatchSubjects',[BatchStudentController::class, 'getAllStudentBatchSubjects'])->name('attendances.getAllStudentBatchSubjects');
});


Route::group(['prefix' => 'assignments'], function ($router) {
    Route::get('/', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/store', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/{id}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/{id}/update', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::get('/{id}/delete', [AssignmentController::class, 'delete'])->name('assignments.delete');
    Route::get('/{id}/show',[AssignmentController::class, 'show'])->name('assignments.show');

    Route::get('/{assignment_id}/submissions',[AssignmentSubmissionController::class, 'index'])->name('assignment-submissions.index');
    Route::post('/{assignment_id}/submissions/add',[AssignmentSubmissionController::class, 'store'])->name('assignment-submissions.store');
    Route::post('/{assignment_id}/submissions/auto-evaluate',[AssignmentSubmissionController::class, 'autoEvaluate'])->name('assignment-submissions.auto-evaluate');
    Route::post('/{assignment_id}/submissions/{id}/add-marks',[AssignmentSubmissionController::class, 'addMarks'])->name('assignment-submissions.add-marks');
    Route::get('/{assignment_id}/submissions/checkTime',[AssignmentSubmissionController::class, 'checkTime'])->name('assignment-submissions.check-time');
    Route::get('/{assignment_id}/submissions/checkSubmissionPermission',[AssignmentSubmissionController::class, 'checkSubmissionPermission'])->name('assignment-submissions.check-submission-permission');
    Route::get('/{assignment_id}/submissions/checkAddMarksPermission',[AssignmentSubmissionController::class, 'checkAddMarksPermission'])->name('assignment-submissions.check-add-marks-permission');
    Route::get('/{assignment_id}/submissions/{id}/show',[AssignmentSubmissionController::class,'show'])->name('assignment-submissions.show');
});

Route::group(['prefix' => 'practicals'], function ($router) {
    Route::get('/', [PracticalController::class, 'index'])->name('practicals.index');
    Route::post('/store', [PracticalController::class, 'store'])->name('practicals.store');
    Route::get('/{id}/edit', [PracticalController::class, 'edit'])->name('practicals.edit');
    Route::put('/{id}/update', [PracticalController::class, 'update'])->name('practicals.update');
    Route::get('/{id}/delete', [PracticalController::class, 'delete'])->name('practicals.delete');
    Route::get('/{id}/show',[PracticalController::class, 'show'])->name('practicals.show');

    Route::get('/{practical_id}/submissions',[PracticalSubmissionController::class, 'index'])->name('practical-submissions.index');
    Route::post('/{practical_id}/submissions/add',[PracticalSubmissionController::class, 'store'])->name('practical-submissions.store');
    Route::post('/{practical_id}/submissions/auto-evaluate',[PracticalSubmissionController::class, 'autoEvaluate'])->name('practical-submissions.auto-evaluate');
    Route::post('/{practical_id}/submissions/{id}/add-marks',[PracticalSubmissionController::class, 'addMarks'])->name('practical-submissions.add-marks');
    Route::get('/{practical_id}/submissions/checkTime',[PracticalSubmissionController::class, 'checkTime'])->name('practical-submissions.check-time');
    Route::get('/{practical_id}/submissions/checkSubmissionPermission',[PracticalSubmissionController::class, 'checkSubmissionPermission'])->name('practical-submissions.check-submission-permission');
    Route::get('/{practical_id}/submissions/checkAddMarksPermission',[PracticalSubmissionController::class, 'checkAddMarksPermission'])->name('practical-submissions.check-add-marks-permission');
    Route::get('/{practical_id}/submissions/{id}/show',[PracticalSubmissionController::class,'show'])->name('practical-submissions.show');
});

Route::group(['prefix' => 'special-activities'], function ($router) {
    Route::get('/', [SpecialActivityController::class, 'index'])->name('special-activities.index');
    Route::post('/store', [SpecialActivityController::class, 'store'])->name('special-activities.store');
    Route::get('/{id}/edit', [SpecialActivityController::class, 'edit'])->name('special-activities.edit');
    Route::put('/{id}/update', [SpecialActivityController::class, 'update'])->name('special-activities.update');
    Route::get('/{id}/delete', [SpecialActivityController::class, 'delete'])->name('special-activities.delete');
    Route::get('/{id}/show',[SpecialActivityController::class, 'show'])->name('special-activities.show');
});

Route::group(['prefix' => 'attendances'], function ($router) {
    Route::get('/{batch_id}/get-data', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/{subject_id}/student-attendance',[AttendanceController::class, 'getAllStudentAttendance'])->name('attendances.student-attendance');
    Route::post('/store', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/{attendance_id}/edit',[AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/{attendance_id}/update',[AttendanceController::class, 'update'])->name('attendances.update');
    Route::post('/{attendance_id}/duplicate-attendance',[AttendanceController::class, 'duplicateAttendance'])->name('attendances.duplicateAttendance');
    Route::get('/{attendance_id}/getAttendanceStudents', [AttendanceController::class, 'getAttendanceStudents'])->name('attendances.getAttendanceStudents');
    Route::post('/{attendance_id}/takeAttendance', [AttendanceController::class, 'takeAttendance'])->name('attendances.takeAttendance');
    Route::get('/{attendance_id}/show',[AttendanceController::class, 'show'])->name('attendances.show');
});

Route::group(['prefix' => 'profile'], function ($router) {
    Route::get('/getProfile',[ProfileController::class, 'getProfile'])->name('profile.getProfile');
    Route::put('/update',[ProfileController::class, 'update'])->name('profile.update');
});
