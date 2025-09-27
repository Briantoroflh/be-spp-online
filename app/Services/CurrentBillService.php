<?php

namespace App\Services;

use App\Models\CurrentBill;
use App\Repositories\CurrentBillRepository;

class CurrentBillService
{
    private $currRepository;

    public function __construct(
        CurrentBillRepository $currentBillRepository
    ) {
        $this->currRepository = $currentBillRepository;
    }

    public function getByUuid(string $uuid) {
        return $this->currRepository->getByUuid($uuid);
    }

    public function update(string $uuid, array $data){
        return $this->currRepository->update($uuid, $data);
    }

    public function delete(string $uuid) {
        return $this->currRepository->delete($uuid);
    }
}
