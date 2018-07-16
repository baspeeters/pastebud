<?php
/**
 * Created by PhpStorm.
 * User: bas
 * Date: 7/11/18
 * Time: 4:31 AM
 */

namespace App\Traits;


use Doctrine\ORM\Mapping as ORM;

trait HasName
{
    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    public function getName(): string
    {
        return (string) $this->name;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setName(string $name) : bool
    {
        $this->name = $name;

        return true;
    }
}
