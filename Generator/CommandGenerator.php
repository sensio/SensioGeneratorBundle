<?php

namespace Sensio\Bundle\GeneratorBundle\Generator;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Generates a command
 *
 * @author Tito Miguel Costa <symfony2@titomiguelcosta>
 */
class CommandGenerator extends Generator
{
private $filesystem;
    private $skeletonDir;

    public function __construct(Filesystem $filesystem, $skeletonDir)
    {
        $this->filesystem = $filesystem;
        $this->skeletonDir = $skeletonDir;
    }

    public function generate(BundleInterface $bundle, $class, $name, $description)
    {
        $dir = $bundle->getPath().'/Command';
        $file = $dir.'/'.$class.'Command.php';
        if (file_exists($file)) {
            throw new \RuntimeException(sprintf('Unable to generate the command as the file "%s" already exists.', realpath($file)));
        }

        $parameters = array(
            'class' => $class,
            'bundle' => $bundle->getNamespace(),
            'name' => $name,
            'description' => $description
        );

        $this->filesystem->mkdir($dir);
        $this->renderFile($this->skeletonDir, 'Command.php', $file, $parameters);
    }
}
