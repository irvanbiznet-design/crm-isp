<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_number' => $this->customer_number,
            'name' => $this->name,
            'nik' => $this->nik,
            'phone' => $this->phone,
            'email' => $this->email,
            'photo' => $this->photo,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'area' => new AreaResource($this->whenLoaded('area')),
            'package' => new InternetPackageResource($this->whenLoaded('package')),
            'status' => $this->status,
            'subscription_date' => $this->subscription_date,
            'due_date' => $this->due_date,
            'pppoe_username' => $this->pppoe_username,
            'ip_address' => $this->ip_address,
            'mac_address' => $this->mac_address,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
