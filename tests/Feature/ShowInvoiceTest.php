<?php
// phpunit tests/Feature/ShowInvoiceTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Domain\Enums\StatusEnum;

class ShowInvoiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp():void
    {
        parent::setUp();
    }

    public function test_show_invoice ()
    {
        $this->output( __METHOD__);

        $invoice = Invoice::first();

        $response = $this->json('GET', '/api/invoice/' . $invoice->id);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data')
                     ->has('success')
            );

        $output = json_decode($response->getContent(), 1);

        $this->assertArrayHasKey('products', $output['data']);
        $this->assertArrayHasKey('company', $output['data']);
    }


}
