<?php
// phpunit tests/Feature/RoutesTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use App\Domain\Enums\StatusEnum;

class RoutesTest extends TestCase
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

    public function test_approve_invoice ()
    {
        $this->output( __METHOD__);

        $invoice = Invoice::where('status', StatusEnum::DRAFT)->first();

        $response = $this->json('PUT', '/api/invoice/' . $invoice->id . '/approve');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('success')
                     ->has('data')
            );

        $output = json_decode($response->getContent(), 1);

        $this->assertArrayHasKey('status', $output['data']);
        $this->assertEquals(StatusEnum::APPROVED->value, $output['data']['status']);
    }

    public function test_reject_invoice ()
    {
        $this->output( __METHOD__);

        $invoice = Invoice::where('status', StatusEnum::DRAFT)->first();

        $response = $this->json('PUT', '/api/invoice/' . $invoice->id . '/reject');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('success')
                     ->has('data')
            );

        $output = json_decode($response->getContent(), 1);

        $this->assertArrayHasKey('status', $output['data']);
        $this->assertEquals(StatusEnum::REJECTED->value, $output['data']['status']);
    }

    public function test_reject_approved_invoice ()
    {
        $this->output( __METHOD__);

        $invoice = Invoice::where('status', StatusEnum::APPROVED)->first();

        $response = $this->json('PUT', '/api/invoice/' . $invoice->id . '/reject');

        $response
            ->assertStatus(500);

        $output = json_decode($response->getContent(), 1);

        $this->assertArrayHasKey('message', $output);
        $this->assertArrayHasKey('exception', $output);
        $this->assertEquals('approval status is already assigned', $output['message']);
        $this->assertEquals('LogicException', $output['exception']);
    }
}
