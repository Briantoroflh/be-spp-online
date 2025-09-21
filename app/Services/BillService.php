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

}