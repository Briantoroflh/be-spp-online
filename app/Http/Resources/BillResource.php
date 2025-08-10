<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_bill,
            'student' => $this->student,
            'spp' => $this->spp,
            'month' => $this->month,
            'year' => $this->year,
            'amount' => $this->amount,
            'status' => $this->status
        ];
    }
}
