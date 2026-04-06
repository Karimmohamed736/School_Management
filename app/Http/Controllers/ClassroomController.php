<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(){
       $classrooms=  Classroom::all();
        return response()->json([
            'success'=>true,
            'Classrooms'=>$classrooms,
        ]);
    }

    public function store(Request $request){
        $classroom= Classroom::create([
            'name'=>$request->name,
            'grade'=>$request->grade,
            'section'=>$request->section,
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Classroom created successfully',
            'classroom'=>$classroom
        ]);
    }

    public function show($id){
        $classroom= Classroom::find($id);
        $schedule= Schedule::where('classroom_id',$id)->get();
        if(!$classroom){
            return response()->json([
                'success'=>false,
                'message'=>'Classroom not found'
            ],404);
        }
        return response()->json([
            'success'=>true,
            'classroom'=>$classroom,
            'schedule'=>$schedule
        ]);
    }

    public function update(Request $request, $id){
        $classroom= Classroom::find($id);
        if(!$classroom){
            return response()->json([
                'success'=>false,
                'message'=>'Classroom not found'
            ],404);
        }
        $classroom->update($request->only('name', 'grade', 'section'));
        return response()->json([
            'success'=>true,
            'message'=>'Classroom updated successfully',
            'classroom'=>$classroom
        ]);
    }

    public function delete($id){
        $classroom= Classroom::find($id);
        if(!$classroom){
            return response()->json([
                'success'=>false,
                'message'=>'Classroom not found'
            ],404);
        }
        $classroom->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Classroom deleted successfully',
        ]);
    }
}
