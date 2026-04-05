<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $manager = Manager::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $manager->assignRole('manager');

        $token = $manager->createToken('ApiToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Manager registered successfully', 'manager' => $manager,
            'token' => $token
            ],201);

}


public function login(LoginRequest $request){
    $creditials = $request->only('email','password');
    $validated = $request->validated();
    $manager = Auth::guard('manager')->user();

    if (!$manager || !Hash::check($request->password, $manager->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }
    $manager->tokens()->delete();
    $token = $manager->createToken('ApiToken')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Manager logged in successfully',
        'token' => $token
    ], 200);

}

public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json([
        'success'=>true,
        'message'=>'Manager logged out successfully'
    ],200);
}

public function index(){
    $managers = Manager::all();
    return response()->json([
        'success'=>true,
        'managers'=>$managers
    ],200);
}

public function show($id){
    $manager = Manager::find($id);
    if(!$manager){
        return response()->json([
            'success'=>false,
            'message'=>'Manager not found'
        ],404);
    }
    return response()->json([
        'success'=>true,
        'manager'=>$manager
    ],200);

}

public function update(UpdateRequest $request, $id){
    $manager = Manager::find($id);
    if(!$manager){
        return response()->json([
            'success'=>false,
            'message'=>'Manager not found'
        ],404);
    }

    $request->validate();

    $manager->update($request->only('name', 'email', 'password'));

    return response()->json([
        'success'=>true,
        'message'=>'Manager updated successfully',
        'manager'=>$manager
    ],200);

}

public function delete($id){
    $manager = Manager::find($id);
    if(!$manager){
        return response()->json([
            'success'=>false,
            'message'=>'Manager not found'
        ],404);
    }

    $manager->delete();
}

public function onlyTrashed(){
    $managers = Manager::onlyTrashed()->get();
    return response()->json([
        'success'=>true,
        'managers'=>$managers
    ],200);


}

public function restore($id){
    $manager = Manager::withTrashed()->find($id);
    if(!$manager){
        return response()->json([
            'success'=>false,
            'message'=>'Manager not found'
        ],404);
    }

    $manager->restore();
    return response()->json([
        'success'=>true,
        'message'=>'Manager restored successfully',
        'manager'=>$manager
    ],200);

}

public function forceDelete($id){
    $manager = Manager::withTrashed()->find($id);
    if(!$manager){
        return response()->json([
            'success'=>false,
            'message'=>'Manager not found'
        ],404);
    }

    $manager->forceDelete();
    return response()->json([
        'success'=>true,
        'message'=>'Manager permanently deleted'
    ],200);


}


}
