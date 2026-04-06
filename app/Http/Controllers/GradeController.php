<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function show($id)
    {
        $grade = Grade::with(['student', 'test'])->find($id);
        if (!$grade) {
            return response()->json([
                'success' => false,
                'message' => 'Grade not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $grade
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'test_id' => 'required|exists:tests,id',
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $grade = Grade::create($validated);
        return response()->json([
            'success' => true,
            'data' => $grade
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json([
                'success' => false,
                'message' => 'Grade not found'
            ], 404);
        }

        $validated = $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'test_id' => 'sometimes|required|exists:tests,id',
            'grade' => 'sometimes|required|numeric|min:0|max:100',
        ]);

        $grade->update($validated);
        return response()->json([
            'success' => true,
            'data' => $grade
        ]);
    }
}
