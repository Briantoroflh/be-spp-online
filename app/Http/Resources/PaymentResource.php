<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_payment,
            'student' => $this->whenLoaded('student'),
            'date_payment' => $this->date_payment,
            'method_payment' => $this->method_payment,
            'total_amount' => $this->total_amount
        ];
    }
}
