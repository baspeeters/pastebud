<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Interfaces\ContentInterface;
use App\Traits\HasContent;
use App\Traits\HasId;
use App\Traits\HasName;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('ROLE_USER')"}
 * )
 * @ORM\Entity()
 */
class Pastable implements ContentInterface
{
    use HasId;
    use HasName;
    use HasContent;
}
