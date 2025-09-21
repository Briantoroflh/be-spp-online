<?php

namespace App\Repositories;

use App\Models\School;
use App\Models\Student;

class StudentRepository
{
    // Super Admin
    public function getAll(array $fields)
    {
        return Student::select($fields)->latest()->with(['user', 'school'])->paginate(10);
    }

    public function getByUuid(string $uuid)
    {
        return Student::with('school:uuid,name,type_school')
            ->where('uuid', $uuid)
            ->first();
    }


    // User / School Admin
    public function getAllForSchoolAdmin(string $uuidUser, array $fields)
    {
        return Student::select($fields)
            ->whereHas('school', fn($q) => $q->where('user_uuid', $uuidUser))
            ->with(['school', 'school.user']) // ambil nama & pemilik sekolah saja
            ->orderBy('name')
            ->paginate(10);
    }

    public function createForSchoolAdmin(string $uuidUser, array $data)
    {
        $school = School::where('user_uuid', $uuidUser)->firstOrFail();

        $data['school_uuid'] = $school->uuid;

        return Student::create($data);
    }

    public function updateForSchoolAdmin(string $uuidUser, array $data)
    {
        $school = School::where('user_uuid', $uuidUser)->firstOrFail();

        $student = Student::where('uuid', $data['uuid'])
            ->where('school_uuid', $school->uuid)
            ->firstOrFail();

        $student->update($data);

        return $student;
    }

    public function deleteForSchoolAdmin(string $uuidUser, string $uuidStudent)
    {
        $school = School::where('user_uuid', $uuidUser)->firstOrFail();

        $student = Student::where('uuid', $uuidStudent)
            ->where('school_uuid', $school->uuid)
            ->firstOrFail();

        $student->delete();
    }
}
