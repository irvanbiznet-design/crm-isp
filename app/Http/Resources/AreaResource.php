<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'district' => $this->district,
            'village' => $this->village,
            'cluster' => $this->cluster,
            'fiber_route' => $this->fiber_route,
        ];
    }
}
