<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Program;
use Chrisyue\Mala\Manager\EpgManagerInterface;
use Chrisyue\Mala\Model\ChannelInterface;
use Chrisyue\Mala\Model\ProgramInterface;
use Chrisyue\Mala\Model\VideoInterface;
use Doctrine\ORM\EntityManagerInterface;

class EpgManager implements EpgManagerInterface
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository('AppBundle:Program');
    }

    public function clear(ChannelInterface $channel, \DateTime $startsAt)
    {
        $this->repo->createQueryBuilder('p')
            ->delete()
            ->where('p.channel = :channel AND p.startsAt >= :startsAt')
            ->setParameters(compact('channel', 'startsAt'))
            ->execute();
    }

    public function findLastProgram(ChannelInterface $channel)
    {
        return $this->repo->createQueryBuilder('p')
            ->where('p.channel = :channel')
            ->orderBy('p.startsAt', 'DESC')
            ->setParameters(compact('channel'))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function find(ChannelInterface $channel, \DateTime $startsAt, \DateTime $endsAt)
    {
        return $this->repo->createQueryBuilder('p')
            ->where('p.channel = :channel AND p.startsAt BETWEEN :startsAt AND :endsAt')
            ->setParameters(compact('channel', 'startsAt', 'endsAt'))
            ->getQuery()
            ->getResult();
    }

    public function createProgram(ChannelInterface $channel, VideoInterface $video, $sequence, \DateTime $startsAt, \DateTime $endsAt)
    {
        $program = new Program();
        $program->setChannel($channel)->setVideo($video)->setSequence($sequence)
            ->setStartsAt($startsAt)->setEndsAt($endsAt);

        return $program;
    }

    public function saveDeferred(ProgramInterface $program)
    {
        $this->em->persist($program);
    }

    public function commit()
    {
        $this->em->flush();
    }
}
