<?php

namespace Tests;

trait TestTrait
{
    /** Handling trowen exceptions - it is not handled after PHPUnit 9.5  */
    public function assertException($callback, $expectedExceptionClass = null): void
    {
        $gotException = false;
        try {
            $callback();
        }catch (\Exception $e){
            $gotException = true;
            if (!empty($expectedExceptionClass)){
                $exceptionGottenClass = get_class($e);
                $this->assertEquals($expectedExceptionClass,$exceptionGottenClass,'There is different Exception');
            }
        }
        $this->assertTrue($gotException,'There is no exceptions');
    }

    /** output  */
    public function output($method)
    {
        echo PHP_EOL . '-----------' . $method . ' ---------' .PHP_EOL;
    }
}