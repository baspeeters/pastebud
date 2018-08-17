<?php

namespace App\Tests\Entity;

use App\Entity\Pastable;
use PHPUnit\Framework\TestCase;

class PastableTest extends TestCase
{
    public function testSetName()
    {
        // Given that we have a pastable
        $pastable = new Pastable();

        // And we set its name to some value
        $value = 'Name of object';
        $pastable->setName($value);

        // It should have the same value when we get its name
        $this->assertEquals($value, $pastable->getName());
    }

    public function testGetName()
    {
        // Given that we have a new pastable
        $pastable = new Pastable();

        // Its name should be null
        $this->assertEquals((string) null, $pastable->getName());
    }

    public function testSetContent()
    {
        // Given that we have a pastable
        $pastable = new Pastable();

        // And we set its content to some value
        $value = 'Some content';
        $pastable->setContent($value);

        // It should have the same value when we get its content
        $this->assertEquals($value, $pastable->getContent());
    }

    public function testGetContent()
    {
        // Given that we have a new pastable
        $pastable = new Pastable();

        // Its content should be null
        $this->assertEquals((string) null, $pastable->getContent());
    }
}
