<?php

namespace AppBundle\Entity;

use Chrisyue\Mala\Model\ScheduledMediaSegment as BaseScheduledMediaSegment;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ScheduledMediaSegment extends BaseScheduledMediaSegment
{
    use IdAwareTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Program")
     */
    protected $program;

    /**
     * @ORM\ManyToOne(targetEntity="Channel")
     */
    protected $channel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $uri;

    /**
     * @ORM\Column(type="integer")
     */
    protected $duration;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sequence;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDiscontinuity;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startsAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endsAt;
}
