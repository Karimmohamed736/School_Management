<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['student_id', 'test_id', 'grade'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
