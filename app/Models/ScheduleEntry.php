<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleEntry extends Model
{
    protected $table = 'schedule_entries';
    protected $fillable = [
        'start_time',
        'end_time',
        'schedule_id',
        'subject_id',
        'teacher_id',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
