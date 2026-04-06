<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subjects')->get();
        return response()->json([
            'success' => true,
            'data' => $teachers,
        ]);

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers',
            'password' => 'required|string|min:8',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $teacher = Teacher::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        if (isset($validatedData['subjects'])) {
            $teacher->subjects()->sync($validatedData['subjects']);
        }

        return response()->json([
            'success' => true,
            'data' => $teacher->load('subjects'),
        ], 201);
    }

    public function show($id)
    {
        $teacher = Teacher::with('subjects')->find($id);
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $teacher,
        ]);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:teachers,email,' . $teacher->id,
            'password' => 'sometimes|required|string|min:8',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        if (isset($validatedData['name'])) {
            $teacher->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $teacher->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $teacher->password = bcrypt($validatedData['password']);
        }
        $teacher->save();

        if (isset($validatedData['subjects'])) {
            $teacher->subjects()->sync($validatedData['subjects']);
        }

        return response()->json([
            'success' => true,
            'data' => $teacher->load('subjects'),
        ]);
    }

    public function delete($id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Teacher not found',
            ], 404);
        }
        $teacher->delete();
        return response()->json([
            'success' => true,
            'message' => 'Teacher deleted successfully',
        ]);
    }
}
