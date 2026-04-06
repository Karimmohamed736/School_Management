<?php

namespace App\Http\Controllers;

use App\Models\Teaching;
use App\Rules\CheckTeacherSubject;
use Illuminate\Http\Request;

class TeachingController extends Controller
{
    public function index()
    {
        $teachings = Teaching::with(['teacher', 'subject'])->get();
        return response()->json([
            'success' => true,
            'data' => $teachings,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => [  'required', 'exists:subjects,id', new CheckTeacherSubject],
        ]);

        $teaching = Teaching::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $teaching->load(['teacher', 'subject']),
        ], 201);
    }

    public function show($id)
    {
        $teaching = Teaching::with(['teacher', 'subject'])->find($id);
        if (!$teaching) {
            return response()->json([
                'success' => false,
                'message' => 'Teaching not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $teaching,
        ]);
    }

    public function update(Request $request, $id)
    {
        $teaching = Teaching::find($id);
        if (!$teaching) {
            return response()->json([
                'success' => false,
                'message' => 'Teaching not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'teacher_id' => 'exists:teachers,id',
            'subject_id' => 'exists:subjects,id',
        ]);

        $teaching->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $teaching->load(['teacher', 'subject']),
        ]);
    }

    public function delete($id)
    {
        $teaching = Teaching::find($id);
        if (!$teaching) {
            return response()->json([
                'success' => false,
                'message' => 'Teaching not found',
            ], 404);
        }
        $teaching->delete();
        return response()->json([
            'success' => true,
            'message' => 'Teaching deleted successfully',
        ]);
    }


}
