<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'nisn' => $this->nisn,
            'nipd' => $this->nipd,
            'email' => $this->email,
            'password' => $this->password,
            'age' => $this->age,
            'classes' => $this->classes,
            'major' => $this->major,
        ];
    }
}
