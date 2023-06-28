<?php
// NOT IN USE
namespace App\Modules\Invoices\Infrastructure\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LogicException;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Domain\Enums\StatusEnum;

class ApprovalService
{
    /*protected $approvalFacade;

    public function __construct (ApprovalFacadeInterface $approvalFacade)
    {
        $this->approvalFacade = $approvalFacade;
    }*/

    protected function validateStatus ($invoiceId, $invoiceStatus, $classString, $approvalFacade)
    {
        $dto = new ApprovalDto (Str::uuid($invoiceId), $invoiceStatus, $classString);

        $approvalFacade->approve($dto);

        return $dto;
    }

    /**
     * saveStatus
     */
    public function saveStatus ($invoice, $status, $approvalFacade)
    {
        $validate = $this->validateStatus($invoice->id, $invoice->status, Invoice::class, $approvalFacade);

        if ($validate) {

            $invoice->status = $status;
            $invoice->save();

            return $invoice;
        }

        return false;

    }

}