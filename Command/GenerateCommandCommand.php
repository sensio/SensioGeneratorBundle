<?php

namespace Sensio\Bundle\GeneratorBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Sensio\Bundle\GeneratorBundle\Generator\CommandGenerator;
use Sensio\Bundle\GeneratorBundle\Manipulator\KernelManipulator;
use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;
use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

/**
 * Generates a command
 *
 * @author Tito Miguel Costa <symfony2@titomiguelcosta>
 */
class GenerateCommandCommand extends ContainerAwareCommand
{
    private $generator;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputOption('bundle-name', '', InputOption::VALUE_REQUIRED, 'The optional bundle name'),
                new InputOption('class-name', '', InputOption::VALUE_REQUIRED, 'The optional class name'),
                new InputOption('command-name', '', InputOption::VALUE_REQUIRED, 'The optional command name'),
                new InputOption('command-description', '', InputOption::VALUE_REQUIRED, 'The optional command description'),
            ))
            ->setDescription('Generates a command')
            ->setHelp(<<<EOT
The <info>generate:command</info> command helps you generates new commands.
EOT
            )
            ->setName('generate:command')
        ;
    }
    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When namespace doesn't end with Bundle
     * @throws \RuntimeException         When bundle can't be executed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();

        if ($input->isInteractive()) {
            if (!$dialog->askConfirmation($output, $dialog->getQuestion('Do you confirm generation', 'yes', '?'), true)) {
                $output->writeln('<error>Command aborted</error>');

                return 1;
            }
        }

        foreach (array('bundle-name', 'class-name', 'command-name') as $option) {
            if (null === $input->getOption($option)) {
                throw new \RuntimeException(sprintf('The "%s" option must be provided.', $option));
            }
        }

        $bundle  = $this->getContainer()->get('kernel')->getBundle($input->getOption('bundle-name'));

        $generator = $this->getGenerator();
        $generator->generate($bundle, $input->getOption('class-name'), $input->getOption('command-name'), $input->getOption('command-description'));

        $output->writeln('Generating the command code: <info>OK</info>');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $dialog->writeSection($output, 'Welcome to the Symfony2 command generator');

        $kernel = $this->getContainer()->get('kernel');
        $bundle = $dialog->askAndValidate($output, $dialog->getQuestion('Bundle name', $input->getOption('bundle-name')), function ($name) use($kernel){ $kernel->getBundle($name); return $name; }, false, $input->getOption('bundle-name'));
        $input->setOption('bundle-name', $bundle);

        $class = $dialog->askAndValidate($output, $dialog->getQuestion('Class name', $input->getOption('class-name')), array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateClassName'), false, $input->getOption('class-name'));
        $input->setOption('class-name', $class);

        $name = $dialog->askAndValidate($output, $dialog->getQuestion('Command name', $input->getOption('command-name')), array('Sensio\Bundle\GeneratorBundle\Command\Validators', 'validateCommandName'), false, $input->getOption('command-name'));
        $input->setOption('command-name', $name);

        $description = $dialog->askAndValidate($output, $dialog->getQuestion('Command description', $input->getOption('command-description')), function ($description){ return $description; }, false, $input->getOption('command-description'));
        $input->setOption('command-description', $description);
    }

    protected function getGenerator()
    {
        if (null === $this->generator) {
            $this->generator = new CommandGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/command');
        }

        return $this->generator;
    }

    public function setGenerator(CommandGenerator $generator)
    {
        $this->generator = $generator;
    }

    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }
}