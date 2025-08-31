<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentReq;
use App\Http\Resources\StudentRes;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::select(
            'uuid',
            'name',
            'nisn',
            'nipd',
            'email',
            'age',
            'classes',
            'major'
        )->get();

        if($student->count() < 1){
            return ApiRes::errorResponse("Data student belum ada!", null, 404);
        }

        return ApiRes::successResponse("Data student berhasil di ambil!", StudentRes::collection($student));
    }

    public function show($uuid) {
        $student = Student::where('uuid', $uuid)->first();

        if(!$student) {
            return ApiRes::errorResponse("Student dengan uuid {$uuid} tidak ditemukan!", null, 404);
        }

        return ApiRes::successResponse("Data student ditemukan!", new StudentRes($student));
    }

    public function store(StudentReq $req) {
        $validated = $req->validated();

        try{
            $student = new Student();
            $student->fill($validated);
            $student->save();
        }catch(Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }
        
        return ApiRes::successResponse("Student berhasil dibuat!");
    }

    public function update(StudentReq $req, $uuid) {
        $validated = $req->validated();

        $student = Student::where('uuid', $uuid)->first();

        try{
            $student->update($validated);
        }catch(Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Student berhasil diubah!");
    }

    public function destroy($uuid) {
        $student = Student::where('uuid', $uuid)->first();

        try{
            $student->delete();
        }catch(Exception $err) {
            return ApiRes::errorResponse($err->getMessage(), null, 500);
        }

        return ApiRes::successResponse("Student berhasil dihapus!");
    }
}
