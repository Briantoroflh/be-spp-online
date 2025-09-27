<?php

namespace App\Services;

use App\Repositories\BillRepository;

class BillService {
    private $billRepository;

    public function __construct(
        BillRepository $billRepository
    )
    {
        $this->billRepository = $billRepository;
    }

    public function getAll(array $fields) {
        return $this->billRepository->getAll($fields);
    }
    
    public function getAllByStudentUuid(string $studentUuid) {
        return $this->billRepository->getAllByStudentUUid($studentUuid);
    }

    public function getByUuid(string $uuid) {
        return $this->billRepository->getByUuid($uuid);
    }

    public function create(array $data) {
        return $this->billRepository->create($data);
    }

    public function update(string $uuid, array $data) {
        return $this->billRepository->update($uuid, $data);
    }

    public function delete(string $uuid) {
        return $this->billRepository->delete($uuid);
    }

}