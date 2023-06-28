<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory;
use Tests\TestTrait;
use DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestTrait;

    protected $faker;

    public function setUp():void {
        parent::setUp();

        $this->seed();
    }
}
