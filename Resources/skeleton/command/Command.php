<?php

namespace {{ namespace }}\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class {{ command_class }} extends {{ need_container ? 'ContainerAwareCommand' : 'Command' }}
{
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputOption('length', null, InputOption::VALUE_OPTIONAL, 'The word length', 8),
            ))
            ->setName('{{ name }}')
            ->setDescription('{{ description }}')
            ->setHelp(<<<EOF
The <info>hangman:play</info> command starts a new game of the
famous hangman game:

<info>hangman:play --length=8</info>

Try to guess the hidden <comment>word</comment> whose length is
<comment>8</comment> before you reach the maximum number of
<comment>attempts</comment>.

EOF
            )
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
    }
}
