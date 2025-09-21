<?php

namespace App\Repositories;

use App\Models\DetailBill;

class DetailBillRepository {
    public function getAll(array $fields) {
        return DetailBill::select($fields)->latest()->paginate(10);
    }

    public function getByUuid(string $uuid) {
        return DetailBill::where('uuid', $uuid)->firstOrFail();
    }

    public function create(array $data) {
        return DetailBill::create($data);
    }

    public function update(string $uuid, array $data) {
        $detailBill = DetailBill::findOrFail($uuid);
        $detailBill->update($data);
        return $detailBill;
    }

    public function delete(string $uuid) {
        $detailBill = DetailBill::findOrFail($uuid);
        $detailBill->delete();
    }
}