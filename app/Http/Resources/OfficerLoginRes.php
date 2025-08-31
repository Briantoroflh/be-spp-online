<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficerLoginRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected $accessToken;

    public function __construct($resource, $accessToken = null)
    {
        parent::__construct($resource);
        $this->accessToken = $accessToken;
    }

    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'username' => $this->username,
            'email' => $this->email,
            'access_token' => $this->accessToken,
        ];
    }
}
