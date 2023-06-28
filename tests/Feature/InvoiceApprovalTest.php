<?php
// phpunit tests/Feature/InvoiceApprovalTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use Illuminate\Support\Str;
use App;
use LogicException;

class InvoiceApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
    }

    public function test_invoice_model_can_be_approved ()
    {
        $this->output(__METHOD__);

        $dto = $this->getDto(StatusEnum::DRAFT);
        $validate = $this->makeValidate()->approve($dto);

        $this->assertTrue($validate, 'Expected Pass');

    }

    public function test_invoice_model_can_be_rejected ()
    {
        $this->output(__METHOD__);

        $dto = $this->getDto(StatusEnum::DRAFT);
        $validate = $this->makeValidate()->reject($dto);

        $this->assertTrue($validate, 'Expected Pass');

    }

    public function test_invoice_model_cannot_be_approved ()
    {
        $this->output(__METHOD__);

        $this->assertException(function (){
            $dto = $this->getDto(StatusEnum::APPROVED);

            $this->makeValidate()->approve($dto);
            throw new LogicException();
        },'LogicException');

        $this->assertTrue(true, 'Expected Pass');
    }

    public function test_invoice_model_cannot_be_approved_try_catch ()
    {
        $this->output(__METHOD__);

        try {
            $dto = $this->getDto(StatusEnum::APPROVED);
            $this->makeValidate()->approve($dto);
        } catch (LogicException $e) {
            $this->assertInstanceOf(LogicException::class, $e);
            $this->assertEquals($e->getMessage(), 'approval status is already assigned');
        }

        $this->assertTrue(true, 'Expected Pass');
    }

    protected function makeValidate()
    {
        return App::make(ApprovalFacadeInterface::class);
    }

    public function getDto ($status)
    {
        $invoice = Invoice::where('status', $status)->first();

        $dto = new ApprovalDto (Str::uuid($invoice->id), $invoice->status, Invoice::class);

        return $dto;
    }

}
