<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile_number',
        'roll_number',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function attendance_student_get_students() {
        return $this->hasMany('App\Models\AttendanceStudent', 'student_id');
    }

    public function assignment_get_teachers() {
        return $this->hasMany('App\Models\Assignment','added_by');
    }

    public function college_get_admins() {
        return $this->hasMany('App\Models\College', 'admin_id');
    }

    public function assignment_submission_get_students() {
        return $this->hasMany('App\Models\AssignmentSubmission', 'student_id');
    }

    public function practical_get_teachers() {
        return $this->hasMany('App\Models\Practical','added_by');
    }

    public function activity_get_teachers() {
        return $this->hasMany('App\Models\SpecialActivity','added_by');
    }
}
