<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the enrollments.
     */
    public function index()
    {
        return response()->json(Enrollment::with(['student', 'course'])->get());
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string|max:10',
            'atttendance' => 'required|string|max:10',
            'status' => 'required|string|max:50',
        ]);

        $enrollment = Enrollment::create($validated);

        return response()->json($enrollment, 201);
    }

    /**
     * Display the specified enrollment.
     */
    public function show(string $id)
    {
        $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
        return response()->json($enrollment);
    }

    /**
     * Update the specified enrollment in storage.
     */
    public function update(Request $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'sometimes|required|exists:students,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'grade' => 'sometimes|required|string|max:10',
            'atttendance' => 'sometimes|required|string|max:10',
            'status' => 'sometimes|required|string|max:50',
        ]);

        $enrollment->update($validated);

        return response()->json($enrollment);
    }

    /**
     * Remove the specified enrollment from storage.
     */
    public function destroy(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted successfully.']);
    }
}
