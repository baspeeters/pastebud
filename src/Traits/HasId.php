<?php
/**
 * Created by PhpStorm.
 * User: bas
 * Date: 7/13/18
 * Time: 11:41 AM
 */

namespace App\Traits;


use Doctrine\ORM\Mapping as ORM;

trait HasId
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId() : int
    {
        if (is_int($this->id) === false) {
            throw new NoIdException();
        }

        return $this->id;
    }
}
