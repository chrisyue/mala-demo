<?php

namespace AppBundle\Entity;

use Chrisyue\Mala\Model\ProgramInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Program implements ProgramInterface
{
    use IdAwareTrait;
    use SchedulableTrait;

    /**
     * @var Channel
     * 
     * @ORM\ManyToOne(targetEntity="Channel")
     */
    private $channel;

    /**
     * @var Video
     * 
     * @ORM\ManyToOne(targetEntity="Video")
     */
    private $video;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $sequence;

    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setVideo(Video $video)
    {
        $this->video = $video;

        return $this;
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getSequence()
    {
        return $this->sequence;
    }
}
