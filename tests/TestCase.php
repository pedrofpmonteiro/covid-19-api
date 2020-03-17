<?php


namespace pedrofpmonteiro\Covid19\Tests;


use pedrofpmonteiro\Covid19\Covid19ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
          Covid19ServiceProvider::class
        ];
    }

}