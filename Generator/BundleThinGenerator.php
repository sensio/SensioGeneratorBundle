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

namespace Sensio\Bundle\GeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator;

/**
 * Generates a thin bundle.
 *
 * @author Ilias Lazaridis <ilias@lazaridis.com>
 */
class BundleThinGenerator extends BundleGenerator
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
