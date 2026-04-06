<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schedule;

class ScheduleController extends Controller
{
    public function index(){

    $shedule = Cache::remember('schedule_entries_with_relations', 60, function () {
        return ScheduleEntry::with(['subject', 'teacher'])->get();
    });
        $shedule = ScheduleEntry::with(['subject', 'teacher'])->get();
        return response()->json([
            'success' => true,
            'data' => $shedule,
        ]);
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time' => 'required|date_format:H:i',
        ]);

        $scheduleEntry = ScheduleEntry::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $scheduleEntry->load(['teacher', 'subject']),
        ], 201);
    }

    public function show($id){
        $scheduleEntry = ScheduleEntry::with(['teacher', 'subject'])->find($id);
        if (!$scheduleEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule entry not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $scheduleEntry,
        ]);
    }

    public function update(Request $request, $id){
        $scheduleEntry = ScheduleEntry::find($id);
        if (!$scheduleEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule entry not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'teacher_id' => 'exists:teachers,id',
            'subject_id' => 'exists:subjects,id',
            'day_of_week' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'time' => 'date_format:H:i',
        ]);

        $scheduleEntry->update($validatedData);

        return response()->json([
            'success' => true,
            'data' => $scheduleEntry->load(['teacher', 'subject']),
        ]);
    }

    public function delete($id){
        $scheduleEntry = ScheduleEntry::find($id);
        if (!$scheduleEntry) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule entry not found',
            ], 404);
        }

        $scheduleEntry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule entry deleted successfully',
        ]);

    }
}
