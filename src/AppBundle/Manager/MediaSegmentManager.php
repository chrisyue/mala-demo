<?php

namespace AppBundle\Manager;

use AppBundle\Entity\ScheduledMediaSegment;
use Chrisyue\Mala\Manager\MediaSegmentManagerInterface;
use Chrisyue\Mala\Model\ChannelInterface;
use Chrisyue\Mala\Model\ProgramInterface;
use Chrisyue\Mala\Model\ScheduledMediaSegment as BaseScheduledMediaSegment;
use Doctrine\ORM\EntityManagerInterface;

class MediaSegmentManager implements MediaSegmentManagerInterface
{
    private $em;
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository('AppBundle:ScheduledMediaSegment');
    }

    public function clear(ChannelInterface $channel, \DateTime $startsAt)
    {
        $this->repo->createQueryBuilder('m')
            ->delete()
            ->where('m.channel = :channel AND m.startsAt >= :startsAt')
            ->setParameters(compact('channel', 'startsAt'))
            ->getQuery()
            ->execute();
    }

    public function findLast(ChannelInterface $channel)
    {
        return $this->repo->createQueryBuilder('m')
            ->where('m.channel = :channel')
            ->setParameters(compact('channel'))
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findPlaying(ChannelInterface $channel, \DateTime $playingAt, $duration)
    {
        $firstSegmentStartsAt = $this->repo->createQueryBuilder('m')
            ->select('m.startsAt')
            ->where('m.channel = :channel AND :playingAt BETWEEN m.startsAt AND m.endsAt')
            ->setParameters(compact('channel', 'playingAt'))
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();

        $endsAt = new \DateTime($firstSegmentStartsAt);
        $endsAt->modify(sprintf('+%d seconds', $duration - 1));

        return $this->repo->createQueryBuilder('m')
            ->where('m.channel = :channel AND m.startsAt between :firstSegmentStartsAt and :endsAt')
            ->setParameters(compact('channel', 'firstSegmentStartsAt', 'endsAt'))
            ->getQuery()
            ->getResult();
    }

    public function create(ProgramInterface $program, \DateTime $startsAt, \DateTime $endsAt, $uri, $duration, $sequence, $isDiscontinuity)
    {
        $uri = preg_replace('/[^\/]+$/', $uri, $program->getVideo()->getUri());

        return new ScheduledMediaSegment($program, $startsAt, $endsAt, $uri, $duration, $sequence, $isDiscontinuity);
    }

    public function saveDeferred(BaseScheduledMediaSegment $scheduledMs)
    {
        $this->em->persist($scheduledMs);
    }

    public function commit()
    {
        $this->em->flush();
    }
}
