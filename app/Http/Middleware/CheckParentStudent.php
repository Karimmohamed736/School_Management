<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckParentStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $parent = $request->user();
        $studentId= $request->route('student_id');
        $ownStudent = $parent->students()->where('students.id',$studentId)->exists();
        if (!$ownStudent) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

        return $next($request);
    }
}
