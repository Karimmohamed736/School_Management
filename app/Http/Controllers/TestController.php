<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::with(['classroom', 'subject', 'grades'])->get();
        return response()->json([
            'success' => true,
            'data' => $tests
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'nullable|date',
        ]);

        $test = Test::create($validated);
        return response()->json([
            'success' => true,
            'data' => $test
        ], 201);
    }

    public function show($id)
    {
        $test = Test::with(['classroom', 'subject', 'grades'])->find($id);
        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'Test not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $test
        ]);
    }
}
