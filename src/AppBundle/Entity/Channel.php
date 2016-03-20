<?php

namespace AppBundle\Entity;

use Chrisyue\Mala\Model\ChannelInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Channel implements ChannelInterface
{
    use IdAwareTrait;
}
