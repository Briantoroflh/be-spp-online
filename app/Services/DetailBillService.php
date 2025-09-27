<?php

namespace App\Services;

use App\Repositories\DetailBillRepository;

class DetailBillService
{
    private $detailBillRepository;

    public function __construct(
        DetailBillRepository $detailBillRepository
    ) {
        $this->detailBillRepository  = $detailBillRepository;
    }

    public function getAll() {
        return $this->detailBillRepository->getAll();
    }

    public function create(array $data) {
        return $this->detailBillRepository->create($data);
    }

    public function update(string $uuid, array $data) {
        return $this->detailBillRepository->update($uuid, $data);
    }

    public function delete(string $uuid) {
        return $this->detailBillRepository->delete($uuid);
    }
}
