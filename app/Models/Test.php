<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['name', 'classroom_id', 'subject_id', 'date'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
