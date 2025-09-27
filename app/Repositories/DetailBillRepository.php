<?php

namespace App\Repositories;

use App\Models\DetailBill;

class DetailBillRepository {
    public function getAll() {
        return DetailBill::latest()->paginate(10);
    }

    public function getByUuid(string $uuid) {
        return DetailBill::where('uuid', $uuid)->first();
    }

    public function create(array $data) {
        return DetailBill::create($data);
    }

    public function update(string $uuid, array $data) {
        $detailBill = DetailBill::where('uuid', $uuid)->first();
        $detailBill->update($data);
        return $detailBill;
    }

    public function delete(string $uuid) {
        $detailBill = DetailBill::findOrFail($uuid);
        $detailBill->delete();
    }
}