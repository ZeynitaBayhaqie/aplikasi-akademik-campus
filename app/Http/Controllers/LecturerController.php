<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        return response()->json(Lecturer::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'NIP' => 'required|string|max:50|unique:lecturers,NIP',
            'department' => 'required|string|max:100',
            'email' => 'required|email|unique:lecturers,email',
        ]);

        $lecturer = Lecturer::create($validated);

        return response()->json($lecturer, 201);
    }

    public function show(string $id)
    {
        return response()->json(Lecturer::findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $lecturer = Lecturer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'NIP' => 'sometimes|required|string|max:50|unique:lecturers,NIP,' . $lecturer->id,
            'department' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:lecturers,email,' . $lecturer->id,
        ]);

        $lecturer->update($validated);

        return response()->json($lecturer);
    }

    public function destroy(string $id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $lecturer->delete();

        return response()->json(['message' => 'Lecturer deleted successfully.']);
    }
}
