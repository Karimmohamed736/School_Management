<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;

class ParentModelController extends Controller
{
    public function myStudents(Request $request)
    {
        $parent = ParentModel::with('students')->find(auth('parent')->id());
        return $parent->students;

        //or Eager Loading
        return auth('parent')->user()->load('students');
    }

    public function grades($student_id)
{
    $student = Student::with('grades.test.subject')->findOrFail($student_id);

    return response()->json([
        'student' => $student->full_name,
        'grades' => $student->grades
    ]);
}

    //attendance from relation with student
    public function attendance($student_id)
{
    $student = Student::with('attendances')
        ->findOrFail($student_id);

    return response()->json([
        'student' => $student->full_name,
        'attendance' => $student->attendances
    ]);
}
}
