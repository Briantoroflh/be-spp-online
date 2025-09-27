<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Models\CurrentBill;

class CurrentBillRepository {
    public function getAll(array $fields) {
        return CurrentBill::select($fields)->latest()->with('bill')->paginate(10);
    }

    public function getByUuid(string $uuid) {
        return CurrentBill::where('uuid', $uuid)
        ->with('bill')
        ->first();
    }

    public function create(array $data) {
        return CurrentBill::create($data);
    }

    public function update(string $uuid, array $data) {
        $bill = CurrentBill::where('uuid', $uuid)->first();
        $bill->update($data);
        return $bill;
    }

    public function delete(string $uuid) {
        $bill = CurrentBill::where('uuid', $uuid)->first();
        $bill->delete();
    }
}