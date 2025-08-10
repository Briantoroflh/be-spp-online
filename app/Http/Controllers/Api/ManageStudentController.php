<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ApiRes;
use App\Http\Requests\Student\StudentReq;
use App\Http\Resources\StudentResource;

class ManageStudentController extends Controller
{
    public function index()
    {
        $student = Student::with(["user", "class"])->select(
            'id_student as id',
            'nisn',
            'nis',
            'name',
            'classes_id',
            'alamat as address',
            'no_telp as phone_number',
            'users_id'
        )->get();

        if ($student->count() < 1) {
            return ApiRes::error("Data not yet!", 404);
        }

        return ApiRes::success(StudentResource::collection($student), 'Data retrieved success!');
    }

    public function show(string $id)
    {
        $student = Student::findOrFail($id);

        return ApiRes::success($student, "Data retrieved success!");
    }

    public function store(StudentReq $req)
    {
        $validated = $req->validated();

        $student = new Student();
        $student->fill($validated);
        $student->save();

        return ApiRes::success($student, "Student success created!");
    }

    public function update(StudentReq $req, string $id)
    {
        $validated = $req->validated();

        $student = Student::findOrFail($id);
        $student->update($validated);

        return ApiRes::success($student, "Student success updated!");
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        $student->delete();
        return ApiRes::success($student, 'Student success deleted!');
    }
}
