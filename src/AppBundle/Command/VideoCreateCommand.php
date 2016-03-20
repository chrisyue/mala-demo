<?php

namespace AppBundle\Command;

use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VideoCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:video:create')
            ->setDefinition([
                new InputArgument('uri', InputArgument::REQUIRED, 'video m3u8 uri'),
                new InputArgument('channel-id', InputArgument::REQUIRED),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $em = $container->get('doctrine.orm.entity_manager');
        $parser = $container->get('app.m3u8.parser');

        $uri = $input->getArgument('uri');
        $m3u8 = $parser->parseFromUri($uri);

        $channel = $em->getRepository('AppBundle:Channel')->find($input->getArgument('channel-id'));
        if (null === $channel) {
            $output->writeln('<error>No channel is found, do you forget to run app:channel:create ?</error>');

            return;
        }

        $video = new Video();
        $video->setUri($uri)
            ->setDuration($m3u8->getDuration())
            ->setChannel($channel);

        $em->persist($video);
        $em->flush();

        $output->writeln('<info>Done! :)</info>');
    }
}
