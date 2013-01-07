<?php
namespace {{ bundle }}\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class {{ class }}Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('{{ name }}')
            ->setDescription('{{ description }}')
            //->addArgument('name', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'Option descrition')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // The command code
    }
}
