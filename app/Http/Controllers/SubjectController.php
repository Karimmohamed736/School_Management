<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('teachers')->get();
        return response()->json([
            'success' => true,
            'data' => $subjects,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = Subject::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $subject,
        ], 201);
    }

    public function show($id)
    {
        $subject = Subject::with('teachers')->find($id);
        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Subject not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $subject,
        ]);
    }
}
