<?php

namespace App\Modules\Invoices\Infrastructure\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceApproval extends JsonResource
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
            'id' => $this->id,
            'number' => $this->number,
            'date' => $this->date,
            'due_date' => $this->due_date,
            'status' => $this->status
        ];

    }
}
