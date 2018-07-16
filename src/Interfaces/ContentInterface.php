<?php

namespace App\Interfaces;

interface ContentInterface extends NameInterface
{
    public function getContent() : string;
    public function setContent(string $value) : bool;
}
