<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|max:255',
        ]);

        Student::create($request->only(
            'name', 'email', 'course'
        ));

        return redirect()->route('students.index')
            ->with('success', 'Student added successfully!')
            ->with('success_type', 'created');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'course' => 'required|string|max:255',
        ]);

        $student->update($request->only(
            'name', 'email', 'course'
        ));

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully!')
            ->with('success_type', 'updated');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!')
            ->with('success_type', 'deleted');
    }
}
