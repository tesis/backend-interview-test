<?php

namespace App\Modules\Invoices\Presentation\Http\Controllers;

use App\Infrastructure\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\ApprovalFacadeInterface;

use App\Modules\Invoices\Infrastructure\Resources\InvoiceApproval as InvoiceApprovalResource;
use App\Modules\Invoices\Infrastructure\Resources\Invoice as InvoiceResource;
use App\Modules\Invoices\Infrastructure\Resources\Invoices as InvoiceCollection;
use App\Modules\Invoices\Infrastructure\Services\ShowInvoiceService;

class InvoicesController extends Controller
{
    protected $approvalFacade;

    /**
     * __construct
     */
    public function __construct (ApprovalFacadeInterface $approvalFacade)
    {
        $this->approvalFacade = $approvalFacade;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /** FYI - just for my own use */
    public function index()
    {
        return response()->json(['success' => 1, 'data'=> (new InvoiceCollection(Invoice::all())) ], 200);
    }

    /**
     * Display the specified resource. Lazy load other models.
     *
     * @param  Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice, ShowInvoiceService $showInvoiceService)
    {
        $invoice->load(
            'company',
            'products',
        );

        $showInvoiceService->productsData($invoice->products);

        $invoice->subtotal = $showInvoiceService->getSubtotal();
        $invoice->total = $showInvoiceService->getTotal();

        return response()->json(['success' => 1, 'data'=> (new InvoiceResource($invoice)) ], 200);
    }

    public function approve(Invoice $invoice)
    {
        try {
            $dto = new ApprovalDto (Str::uuid($invoice->id), $invoice->status, Invoice::class);
            $this->approvalFacade->approve($dto);

            $invoice->changeStatus(StatusEnum::APPROVED);

            return response()->json(['success' => 1, 'data'=> (new InvoiceApprovalResource($invoice)) ], 200);
        } catch (LogicException $e) {
            return response()->json(['success' => 0, 'message'=> $e->getMessage() ], 500);
        }
    }

    public function reject(Invoice $invoice)
    {
        try {
            $dto = new ApprovalDto (Str::uuid($invoice->id), $invoice->status, Invoice::class);
            $this->approvalFacade->reject($dto);

            $invoice->changeStatus(StatusEnum::REJECTED);

            return response()->json(['success' => 1, 'data'=> (new InvoiceApprovalResource($invoice)) ], 200);
        } catch (LogicException $e) {
            return response()->json(['success' => 0, 'message'=> $e->getMessage() ], 500);
        }
    }

}