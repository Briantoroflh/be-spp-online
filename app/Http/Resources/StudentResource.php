<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id_student,
            'nisn'         => $this->nisn,
            'nis'          => $this->nis,
            'name'         => $this->name,
            'password'     => $this->password,
            'email'        => $this->email,
            'class'        => $this->class->classes_name ?? null,
            'address'      => $this->address,
            'phone_number' => $this->phone_number,
            'user'         => $this->whenLoaded('user')
        ];
    }
}
