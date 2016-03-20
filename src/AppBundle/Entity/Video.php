<?php

namespace AppBundle\Entity;

use Chrisyue\Mala\Model\VideoInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="VideoRepository")
 */
class Video implements VideoInterface
{
    use IdAwareTrait;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $uri;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * This property is for demostration purpose,
     * in a real world case it's better too make a ChannelVideo
     * to let Channel "many to many" Video
     *
     * @var Channel
     * 
     * @ORM\ManyToOne(targetEntity="Channel")
     */
    private $channel;

    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }
}
