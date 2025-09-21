<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentService {
    private $studentRepository;

    public function __construct(
        StudentRepository $studentRepository
    )
    {
        $this->studentRepository = $studentRepository;
    }

    // Super Admin
    public function getAll(array $fields) {
        return $this->studentRepository->getAll($fields);
    }

    public function getByUuid(array $fields, string $uuid) {
        return $this->studentRepository->getByUuid($uuid, $fields);
    }

    // School Admin
    public function getAllForSchoolAdmin(array $data) {
        $idUser = Auth::user()->uuid;
        
        return $this->studentRepository->getAllForSchoolAdmin($idUser, $data);
    }
    
    public function createForSchoolAdmin(array $data) {
        $idUser = Auth::user()->uuid;

        if(isset($data['photo'])){
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        return $this->studentRepository->createForSchoolAdmin($idUser, $data);
    }

    public function updateForSchoolAdmin(array $data) {
        $idUser = Auth::user()->uuid;

        $student = $this->studentRepository->getByUuid($data['uuid']);

        if (isset($data['photo'])) {
            if($student->photo){
                Storage::disk('public')->delete($student->photo);
            }

            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        return $this->studentRepository->updateForSchoolAdmin($idUser, $data);
    }

    public function deleteForSchoolAdmin(string $uuidUser, string $uuidStudent) {
        return $this->studentRepository->deleteForSchoolAdmin($uuidUser, $uuidStudent);
    }

    private function uploadPhoto(UploadedFile $file) {
        return $file->store('img', 'public');
    }
}