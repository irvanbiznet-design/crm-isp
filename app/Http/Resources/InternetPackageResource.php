<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternetPackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'download_speed' => $this->download_speed,
            'upload_speed' => $this->upload_speed,
            'burst' => $this->burst,
            'limit' => $this->limit,
            'price' => $this->price,
            'fup' => $this->fup,
        ];
    }
}
