<?php

namespace App\Http\Controllers;

use App\Models\CourseLecturer;
use Illuminate\Http\Request;

class CourseLecturerController extends Controller
{
    public function index()
    {
        return response()->json(CourseLecturer::with(['course', 'lecturer'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'role' => 'required|integer',
        ]);

        $courseLecturer = CourseLecturer::create($validated);

        return response()->json($courseLecturer, 201);
    }

    public function show(string $id)
    {
        $courseLecturer = CourseLecturer::with(['course', 'lecturer'])->findOrFail($id);
        return response()->json($courseLecturer);
    }

    public function update(Request $request, string $id)
    {
        $courseLecturer = CourseLecturer::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'sometimes|required|exists:courses,id',
            'lecturer_id' => 'sometimes|required|exists:lecturers,id',
            'role' => 'sometimes|required|integer',
        ]);

        $courseLecturer->update($validated);

        return response()->json($courseLecturer);
    }

    public function destroy(string $id)
    {
        $courseLecturer = CourseLecturer::findOrFail($id);
        $courseLecturer->delete();

        return response()->json(['message' => 'CourseLecturer deleted successfully.']);
    }
}
