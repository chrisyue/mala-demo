<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PlaylistScheduleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:playlist:schedule')
            ->setDefinition([
                new InputArgument('channel-id', InputArgument::REQUIRED),
                new InputOption('starts-at', null, InputOption::VALUE_REQUIRED, 'default is now', 'now'),
                new InputOption('ends-at', null, InputOption::VALUE_REQUIRED, 'default is tommorrow', 'tomorrow'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startsAt = new \DateTime($input->getOption('starts-at'));
        $endsAt = new \DateTime($input->getOption('ends-at'));

        $msScheduler = $this->getContainer()->get('app.playlist_scheduler');
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $channel = $em->getRepository('AppBundle:Channel')->find($input->getArgument('channel-id'));
        if (null === $channel) {
            $output->writeln('<error>No channel is found, do you forget to run app:channel:create ?</error>');

            return;
        }

        $msScheduler->schedule($channel, $startsAt, $endsAt);

        $output->writeln('<info>Done! :)</info>');
    }
}
