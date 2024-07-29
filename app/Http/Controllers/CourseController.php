<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        return CourseResource::collection(Course::paginate(8));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $path = $request->file('image')->store('images', 'public');

        $course = Course::create([
            'title' => $request->title,
            'image' => $path,
            'description' => $request->description,
        ]);

        return response()->json($course, 201);
    }

    public function show(string $id)
    {
        return new CourseResource(Course::find($id));
    }

    public function update(Request $request, string $id)
    {
        $course = Course::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($course->image);

            $path = $request->file('image')->store('images', 'public');
            $course->image = $path;
        }

        $course->title = $request->title;
        $course->description = $request->description;

        $course->save();

        return response()->json($course, 200);
    }


    public function destroy($id)
    {
        $course = Course::find($id);

        Storage::disk('public')->delete($course->image);

        return Course::destroy($id);
    }
}
