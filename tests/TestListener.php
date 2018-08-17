<?php

namespace App\Tests;

use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;

class TestListener extends BaseTestListener
{
    public function startTestSuite(TestSuite $suite)
    {
        if ($this->isIntegrationTest($suite)) {
            reset_db();
        }
    }

    private function isIntegrationTest(TestSuite $suite)
    {
        if (strpos(strtolower($suite->getName()),'integration') !== false) {
            return true;
        }
    }
}
