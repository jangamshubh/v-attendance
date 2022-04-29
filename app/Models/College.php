<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colleges';
    protected $fillable = ['name','year_of_establishment','aicte_id','admin_id'];


    public function college_get_admins() {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }
}
