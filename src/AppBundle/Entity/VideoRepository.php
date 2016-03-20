<?php

namespace AppBundle\Entity;

use Chrisyue\Mala\Manager\VideoManagerInterface;
use Chrisyue\Mala\Model\ChannelInterface;
use Doctrine\ORM\EntityRepository;

class VideoRepository extends EntityRepository implements VideoManagerInterface
{
    public function findByChannel(ChannelInterface $channel)
    {
        return $this->createQueryBuilder('v')
            ->where('v.channel = :channel')
            ->setParameters(compact('channel'))
            ->getQuery()
            ->getResult();
    }
}
