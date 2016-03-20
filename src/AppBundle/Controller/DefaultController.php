<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Channel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/{id}.m3u8", name="homepage")
     */
    public function indexAction(Channel $channel)
    {
        $m3u8 = $this->get('app.m3u8_generator')->generate($channel);

        return new Response($this->get('app.m3u8.dumper')->dump($m3u8), 200, ['Content-Type' => 'application/vnd.apple.mpegurl']);
    }
}
