<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    // ================================
    // Super Admin
    // ================================

    public function index()
    {
        $fields = ['uuid', 'name', 'nisn', 'gender', 'birth_date', 'photo'];
        $students = $this->studentService->getAll($fields);

        return response()->json($students);
    }

    public function show(string $uuid)
    {
        $fields = ['uuid', 'name', 'nisn', 'gender', 'birth_date', 'photo'];
        $student = $this->studentService->getByUuid($fields, $uuid);

        return response()->json($student);
    }

    // ================================
    // School Admin
    // ================================

    public function indexForSchoolAdmin()
    {
        $fields = ['uuid', 'name', 'nisn', 'gender', 'birth_date', 'photo'];
        $students = $this->studentService->getAllForSchoolAdmin($fields);

        return response()->json($students);
    }

    public function storeForSchoolAdmin(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'nisn'       => 'required|string|max:20|unique:students,nisn',
            'gender'     => 'required|in:male,female',
            'birth_date' => 'required|date',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $student = $this->studentService->createForSchoolAdmin($data);

        return response()->json([
            'message' => 'Student created successfully',
            'data'    => $student,
        ], 201);
    }

    public function updateForSchoolAdmin(Request $request)
    {
        $data = $request->validate([
            'uuid'       => 'required|string|exists:students,uuid',
            'name'       => 'sometimes|string|max:255',
            'nisn'       => 'sometimes|string|max:20|unique:students,nisn,' . $request->uuid . ',uuid',
            'gender'     => 'sometimes|in:male,female',
            'birth_date' => 'sometimes|date',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $student = $this->studentService->updateForSchoolAdmin($data);

        return response()->json([
            'message' => 'Student updated successfully',
            'data'    => $student,
        ]);
    }

    public function destroyForSchoolAdmin(string $uuidStudent)
    {
        $uuidUser = Auth::user()->uuid;
        $this->studentService->deleteForSchoolAdmin($uuidUser, $uuidStudent);

        return response()->json([
            'message' => 'Student deleted successfully',
        ]);
    }
}
