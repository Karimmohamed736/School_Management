<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'subject',
    ];

    protected $hidden = [
        'password',
    ];

public function scheduleEntries()
    {
        return $this->hasMany(ScheduleEntry::class);
    }
}
