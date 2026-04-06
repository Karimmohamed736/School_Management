<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['date', 'student_id', 'attended_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
