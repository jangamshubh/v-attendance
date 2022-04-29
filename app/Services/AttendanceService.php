<?php

namespace App\Services;

use Auth;
use App\Models\Attendance;
use App\Models\AttendanceBatch;
use App\Models\AttendanceStudent;
use App\Models\ClassroomBatch;
use App\Models\BatchStudent;
use App\Models\User;
use Carbon\Carbon;
use App\Models\BatchTeacherSubject;
use App\Models\Subject;
class AttendanceService {

    public function getAllAttendances($batch_id) {
        if(Auth::user()->hasPermissionTo('Get Individual Teacher Attendances')) {
            $attendance_ids = AttendanceBatch::where('batch_id',$batch_id)->pluck('attendance_id')->toArray();
            $attendance = Attendance::whereIn('id',$attendance_ids)->where('added_by',Auth::id())->with('attendance_get_subjects','attendance_student_get_attendance')->get();
            $keyed = $attendance->map(function ($item) {
                $attendance_data = AttendanceStudent::where('attendance_id',$item['id']);
                $attendance_taken = false;
                if($item['attendance_student_get_attendance'] != '') {
                    $attendance_taken = true;
                } else {
                    $attendance_taken = false;
                }
                return [
                    'id' => $item['id'],
                    'added_by' => $item['added_by'],
                    'attendance_get_subjects' => $item['attendance_get_subjects'],
                    'attendance_student_get_students' => $attendance_taken,
                    'date' => $item['date'],
                    'total_students' => $attendance_data->count(),
                    'present_students' => $attendance_data->where('status',1)->count(),
                ];
            });
            $data = $keyed->all();
            return $this->retrieveSuccessMessage($data);
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function getAllStudentAttendance($subject_id) {
        if(Auth::user()->hasPermissionTo('Get All Student Attendances')) {
            $attendance_ids = Attendance::where('subject_id',$subject_id)->pluck('id')->toArray();
            $attendances = AttendanceStudent::whereIn('attendance_id',$attendance_ids)->where('student_id',Auth::id())->with('attendance_student_get_attendance')->get();
            return $this->retrieveSuccessMessage($attendances);
        } else {
            return $this->roleErrorMessage();
        }
    }


    public function addAttendance($request) {
        if(Auth::user()->hasPermissionTo('Add Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $attendance = new Attendance;
                $attendance->subject_id = $request->subject_id;
                $attendance->date = Carbon::parse($request->date)->setTimezone('Asia/Kolkata')->format('d-m-Y');
                $start_time = $request->start_time['hours'] .':'. $request->start_time['minutes'];
                $end_time = $request->end_time['hours'] .':'. $request->end_time['minutes'];
                $attendance->start_time = Carbon::parse($start_time)->format('H:i');
                $attendance->end_time = Carbon::parse($end_time)->format('H:i');
                $attendance->added_by = Auth::id();
                $attendance->save();
                if($request->attendance_for == 1) {
                    $this->attendance_for_1($request,$attendance);
                    return $this->takeAttendanceSuccessMessage($attendance);
                } elseif($request->attendance_for == 2) {
                    $this->attendance_for_2($request,$attendance);
                    return $this->takeAttendanceSuccessMessage($attendance);
                } else {
                    return $this->contactAdminErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function getAttendanceStudents($attendance_id) {
        if(Auth::user()->hasPermissionTo('Add Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $attendance_taken = AttendanceStudent::where('attendance_id',$attendance_id)->count();
                $teacher_id = Attendance::where('id',$attendance_id)->pluck('added_by')->first();
                if($attendance_taken == 0) {
                    if($teacher_id == Auth::id()) {
                        $batches = AttendanceBatch::where('attendance_id',$attendance_id)->pluck('batch_id')->toArray();
                        $student_ids = BatchStudent::whereIn('batch_id',$batches)->pluck('student_id')->toArray();
                        $students = User::whereIn('id',$student_ids)->get();
                        return $this->retrieveSuccessMessage($students);
                    } else {
                        return $this->addedByErrorMessage();
                    }
                } else {
                    return $this->attendanceTakenErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function takeAttendance($request,$attendance_id) {
        if(Auth::user()->hasPermissionTo('Add Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $added_by = Attendance::where('id',$attendance_id)->pluck('added_by')->first();
                if($added_by == Auth::id()) {
                    $attendance = $request->attendance;
                    for($i = 0; $i < count($attendance); $i++) {
                        $attendance_student = new AttendanceStudent;
                        $attendance_student->attendance_id = $attendance_id;
                        $attendance_student->student_id = $attendance[$i]['student_id'];
                        $attendance_student->status = $attendance[$i]['status'];
                        $attendance_student->save();
                    }
                    return $this->takeAttendanceSuccessMessage($attendance_student);
                } else {
                    return $this->addedByErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function editAttendance($attendance_id) {
        if(Auth::user()->hasPermissionTo('Add Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $attendance = Attendance::find($attendance_id);
                if ($attendance->added_by == Auth::id()) {
                    $attendance->date = Carbon::parse($attendance->date)->format('d-M-Y');
                    $attendance->start_time = Carbon::parse($attendance->start_time)->format('H:i');
                    $attendance->end_time = Carbon::parse($attendance->end_time)->format('H:i');
                    return $this->retrieveSuccessMessage($attendance);
                } else {
                    return $this->addedByErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function updateAttendance($request,$attendance_id) {
        if(Auth::user()->hasPermissionTo('Add Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $attendance = Attendance::find($attendance_id);
                if ($attendance->added_by == Auth::id()) {
                    $attendance->date = Carbon::parse($request->date)->setTimezone('Asia/Kolkata')->format('d-m-Y');
                    $start_time = $request->start_time['hours'] .':'. $request->start_time['minutes'];
                    $end_time = $request->end_time['hours'] .':'. $request->end_time['minutes'];
                    $attendance->start_time = Carbon::parse($start_time)->format('H:i');
                    $attendance->end_time = Carbon::parse($end_time)->format('H:i');
                    $attendance->update();
                    return $this->updateSuccessMessage($attendance);
                } else {
                    return $this->addedByErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function showAttendance($attendance_id) {
        if(Auth::user()->hasPermissionTo('Show Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $attendance = Attendance::where('id',$attendance_id)->with('attendance_get_subjects')->first();
                if ($attendance->added_by == Auth::id()) {
                    $batch_ids = AttendanceBatch::where('attendance_id',$attendance_id)->pluck('batch_id')->toArray();
                    $batches = ClassroomBatch::whereIn('batch_id',$batch_ids)->with('classroom_batch_get_classrooms','classroom_batch_get_batches')->get();
                    $students = AttendanceStudent::where('attendance_id',$attendance_id)->with('attendance_student_get_students')->get();
                    $array[0] = $attendance;
                    $array[1] = $batches;
                    $array[2] = $students;
                    return $this->showAttendanceSuccessMessage($array);
                } else {
                    return $this->addedByErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    public function duplicateAttendance($request,$attendance_id) {
        if(Auth::user()->hasPermissionTo('Add Attendance')) {
            if(Auth::user()->hasRole('Teacher')) {
                $attendance = Attendance::where('id',$attendance_id)->with('attendance_get_subjects')->first();
                if ($attendance->added_by == Auth::id()) {
                    $new_attendance = new Attendance;
                    $new_attendance->subject_id = $attendance->subject_id;
                    $new_attendance->date = Carbon::parse($request->date)->setTimezone('Asia/Kolkata')->format('d-m-Y');
                    $new_attendance->start_time = Carbon::parse($attendance->start_time)->format('H:i');
                    $new_attendance->end_time = Carbon::parse($attendance->end_time)->format('H:i');
                    $new_attendance->added_by = Auth::id();
                    $new_attendance->save();
                    $batch_ids = AttendanceBatch::where('attendance_id',$attendance_id)->pluck('batch_id')->toArray();
                    for($i = 0;$i < count($batch_ids); $i++) {
                        $attendance_batch = new AttendanceBatch;
                        $attendance_batch->attendance_id = $new_attendance->id;
                        $attendance_batch->batch_id = $batch_ids[$i];
                        $attendance_batch->save();
                    }
                    return $this->takeAttendanceSuccessMessage($new_attendance);
                } else {
                    return $this->addedByErrorMessage();
                }
            } else {
                return $this->roleErrorMessage();
            }
        } else {
            return $this->roleErrorMessage();
        }
    }

    protected function attendance_for_1($request,$attendance) {
        $batches = ClassroomBatch::where('classroom_id',$request->classroom_id)->pluck('batch_id')->toArray();
        for($i = 0; $i < count($batches); $i++) {
            $attendance_batch = new AttendanceBatch;
            $attendance_batch->attendance_id = $attendance->id;
            $attendance_batch->batch_id = $batches[$i];
            $attendance_batch->save();
        }
    }

    protected function attendance_for_2($request,$attendance) {
        $attendance_batch = new AttendanceBatch;
        $attendance_batch->attendance_id = $attendance->id;
        $attendance_batch->batch_id = $request->batch_id;
        $attendance_batch->save();
    }

    protected function roleErrorMessage() {
        $attendances['status'] = 'error';
        $attendances['message'] = "You don't have the correct role to access this data";
        return $attendances;
    }

    protected function updateSuccessMessage($data) {
        $attendances['status'] = 'success';
        $attendances['message'] = 'Attendance Updated Successfully';
        $attendances['data'] = $data;
        return $attendances;
    }

    protected function retrieveSuccessMessage($data) {
        $attendances['status'] = 'success';
        $attendances['message'] = 'Attendance Retrieved Successfully';
        $attendances['data'] = $data;
        return $attendances;
    }

    protected function contactAdminErrorMessage() {
        $attendances['status'] = 'error';
        $attendances['message'] = "Contact the Admin!";
        return $attendances;
    }

    protected function takeAttendanceSuccessMessage($data) {
        $attendances['status'] = 'success';
        $attendances['message'] = 'Attendance Added Successfully';
        $attendances['data'] = $data;
        return $attendances;
    }
    protected function attendanceTakenErrorMessage() {
        $attendances['status'] = 'error';
        $attendances['message'] = "You have already taken the attendance!";
        return $attendances;
    }

    protected function showAttendanceSuccessMessage($data) {
        $attendance['status'] = 'success';
        $attendance['message'] = "Retrieved Attendance Successfully";
        $attendance['attendance'] = $data[0];
        $attendance['batches'] = $data[1];
        $attendance['students'] = $data[2];
        return $attendance;
    }

}
