<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'level_id',
        'capacity',
        ];
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function schedules()
    {
        return $this->hasOne(Schedule::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
