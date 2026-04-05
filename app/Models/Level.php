<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'stage_id',
        'deleted_at',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
