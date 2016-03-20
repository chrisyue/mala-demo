<?php

namespace AppBundle\Command;

use AppBundle\Entity\Channel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChannelCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:channel:create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $channel = new Channel();
        $em->persist($channel);
        $em->flush();

        $output->writeln('<info>Done! :)</info>');
    }
}
