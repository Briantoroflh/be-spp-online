<?php

namespace App\Repositories;

use App\Models\Bill;

class CurrentBillRepository {
    public function getAll(array $fields) {
        return Bill::select($fields)->latest()->with('bill')->paginate(10);
    }

    public function getByUuid(string $uuid, string $billUuid,array $fields) {
        return Bill::select($fields)->where('uuid', $uuid)
        ->where('bill_uuid', $billUuid)
        ->with('bill')
        ->firstOrFail();
    }

    public function create(array $data) {
        return Bill::create($data);
    }

    public function update(string $uuid, array $data) {
        $bill = Bill::findOrFail($uuid);
        $bill->update($data);
        return $bill;
    }

    public function delete(string $uuid) {
        $bill = Bill::findOrFail($uuid);
        $bill->delete();
    }
}