<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 * (c) Ilias Lazaridis <ilias@lazaridis.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\GeneratorBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\GenerateBundleCommand as BaseCmd;
use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator as BaseGen;

/**
 * Generates "thin" bundles, containing only the essential files
 *
 * @author Ilias Lazaridis <ilias@lazaridis.com>
 */

class GenerateBundleThinCommand extends BaseCmd
{
    protected $generator;
    
    protected function configure()
    {
        parent::configure();
        $this->setName('generate:bundle:thin');
        $this->setDescription('Generates a thin bundle (only essential files)');
    }
    
    protected function getGenerator()
    {
        if (null === $this->generator) {
            $filesystem = $this->getContainer()->get('filesystem');
            $skeletonDir = __DIR__ . '/../Resources/skeleton/' . 'bundle';   
            $this->generator = new BundleThinGenerator($filesystem, $skeletonDir);
        }

        return $this->generator;
    }
}

// Override behaviour of the related Generator

class BundleThinGenerator extends BaseGen
{    
    protected function renderFile ($skeletonDir, $template, $target, $parameters)
    {
        // those files are not rendered
        if ('Extension.php' == $template || 'Configuration.php' == $template) {
            return;
        }

        // don't render services.*
        $filename = pathinfo($template, PATHINFO_FILENAME);
        if ('services' == $filename) {
            return;
        }

        // all other files rendered as usual
        parent::renderFile($skeletonDir, $template, $target, $parameters);
    }
}
