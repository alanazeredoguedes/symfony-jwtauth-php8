<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia;


///**
// * @ORM\Entity
// * @ORM\Table(name="media__media")
// */
#[ORM\Entity]
#[ORM\Table(name: "media")]
class SonataMediaMedia extends BaseMedia
{

//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    public function getId()
    {
        return $this->id;
    }

}