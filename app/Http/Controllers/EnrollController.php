<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use Auth;
use Illuminate\Http\Request;

class EnrollController extends Controller
{
    public function check($courseId)
    {
        $isEnrolled = Enrolment::where('user_id', auth()->id())
            ->where('course_id', $courseId)
            ->exists();

        return response()->json(['isEnrolled' => $isEnrolled]);
    }
    public function store(Request $request)
    {
        $course = Enrolment::create([
            'user_id' => auth()->user()->id,
            'course_id' => $request->course_id,
        ]);

        return response()->json($course, 201);
    }

    public function destroy($courseId)
    {
        Enrolment::where('user_id', auth()->id())
            ->where('course_id', $courseId)
            ->delete();

        return response()->json(null, 204);
    }
}
