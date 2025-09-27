<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository {

    public function getByUuid(string $uuid) {
        return Payment::where('uuid', $uuid)->first();
    }

    public function create(array $data) {
        return Payment::create($data);
    }
}