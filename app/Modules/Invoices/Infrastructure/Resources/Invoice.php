<?php

namespace App\Modules\Invoices\Infrastructure\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Companies\Infrastructure\Resources\Company as CompanyResource;
use App\Modules\Companies\Infrastructure\Resources\BilledCompany as BilledCompanyResource;
use Carbon\Carbon;

class Invoice extends JsonResource
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
            'date' => Carbon::parse($this->date)->format('d/m/Y'),
            'due_date' => Carbon::parse($this->due_date)->format('d/m/Y'),
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'company' => new CompanyResource($this->company),
            'billed_company' => new BilledCompanyResource($this->company),
            'products' => $this->products
        ];

    }
}
