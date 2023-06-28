<?php

namespace App\Modules\Companies\Infrastructure\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip
        ];

    }
}
