<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Rules\ValidSchoolDays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        // Validate the request
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => ['required', 'date', new ValidSchoolDays()],
        ]);

        try {
            DB::transaction(function() use ($request){
                Attendance::create([
                    'student_id' => $request->student_id,
                    'date' => $request->date,
                    'attended_at' => now(),
                ]);
            });
            return response()->json(
                [
            'success' => true,
            'message' => 'Attendance marked successfully.'
                ]
            , 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark attendance. '
                ], 500);
        }
    }

    public function index(Request $request)
    {
        $attendances = Attendance::with('student')->get();
        return response()->json($attendances);
    }
}
