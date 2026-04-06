<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return response()->json([
            'success' => true,
            'message' => 'Student index',
            'students' => $students
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'date_of_birth' => 'required|date',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        $password = bcrypt($validatedData['password']);
        $student = Student::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'password' => $password,
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'classroom_id' => $validatedData['classroom_id']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'student' => $student
        ]);
    }

    public function show($id)
    {
        $student = Student::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Student details',
            'student' => $student
        ]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'student' => $student
        ]);
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully',
            'student' => $student
        ]);
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $classroom = Classroom::find($request->classroom_id);
                $studentsCount = $classroom->students()->count();

                if ($studentsCount >= $classroom->capacity) {
                    throw new \Exception('Classroom is full');
                }

                Student::where('id', $request->student_id)->update(['classroom_id' => $request->classroom_id]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Student enrolled successfully'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
