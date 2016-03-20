<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait SchedulableTrait
{
    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    protected $startsAt;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    protected $endsAt;

    public function setStartsAt(\DateTime $startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getStartsAt()
    {
        return $this->startsAt;
    }

    public function setEndsAt(\DateTime $endsAt)
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getEndsAt()
    {
        return $this->endsAt;
    }
}
