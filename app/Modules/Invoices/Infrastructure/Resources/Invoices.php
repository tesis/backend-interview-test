<?php

namespace App\Modules\Invoices\Infrastructure\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Invoices extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => Invoice::collection($this->collection),
        ];

        return [
            'data' => $collection,
        ];
    }

}
