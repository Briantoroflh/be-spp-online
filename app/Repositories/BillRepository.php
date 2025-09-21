<?php

namespace App\Repositories;

use App\Models\Bill;

class BillRepository {
    public function getAll(array $fields) {
        return Bill::select($fields)->latest()->with(['student', 'detailBill'])->paginate(10);
    }

    public function getAllByStudentUUid(string $studentUuid) {
        return Bill::where('student_id', $studentUuid)->latest()->with(['student','detailBill'])->get();
    }

    public function getByUuid(string $uuid) {
        return Bill::where('uuid', $uuid)->first();
    }

    public function create(array $data) {
        return Bill::create($data);
    }

    public function update(string $uuid ,array $data) {
        $bill = Bill::findOrFail($uuid);
        $bill->update($data);
        return $bill;
    }

    public function delete(string $uuid) {
        $bill = Bill::findOrFail($uuid);
        $bill->delete();
    }
}