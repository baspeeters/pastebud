<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Interfaces\SaveInterface;
use App\Traits\HasContent;
use App\Traits\HasId;
use App\Traits\HasName;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class Pastable implements SaveInterface
{
    use HasId;
    use HasName;
    use HasContent ;
}
