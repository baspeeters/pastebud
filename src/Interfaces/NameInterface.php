<?php

namespace App\Interfaces;

interface NameInterface extends IdInterface
{
    public function getName() : string;
    public function setName(string $value) : bool;
}
