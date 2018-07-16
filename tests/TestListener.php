<?php

namespace App\Tests;

use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\TestSuite;

class TestListener extends BaseTestListener
{
    public function startTestSuite(TestSuite $suite)
    {
        if (strpos($suite->getName(),'integration') !== false ) {
            reset_db();
        }
    }
}
