<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait HasContent
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $content;

    public function getContent(): string
    {
        return (string) $this->content;
    }

    /**
     * @param string $content
     * @return bool
     */
    public function setContent(string $content) : bool
    {
        $this->content = $content;

        return true;
    }
}
