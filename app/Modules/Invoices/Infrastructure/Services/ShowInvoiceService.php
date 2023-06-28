<?php

namespace App\Modules\Invoices\Infrastructure\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LogicException;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Domain\Enums\StatusEnum;
use Carbon\Carbon;

class ShowInvoiceService
{
    protected $tax = 6.25;
    protected $total = 0;
    protected $subtotal = 0;

    public function productsData ($products)
    {
        foreach ($products as $product) {
            $product->quantity = $product->pivot->quantity;
            $product->amount = $this->calculateAmount($product->quantity, $product->price);
            $this->subtotal += $product->amount;

            unset($product->pivot);
        }
        $this->total = '$' . round($this->calculateTotal(), 2);

        return $products;
    }

    public function getSubtotal ()
    {
        return $this->subtotal;
    }

    public function getTotal ()
    {
        return $this->total;
    }

    protected function calculateAmount ($quantity, $price)
    {
        return $quantity * $price;
    }

    protected function calculateTotal (): float
    {
        return ($this->subtotal * $this->tax) / 100;
    }
}