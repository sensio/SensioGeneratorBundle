<?php

namespace Sensio\Bundle\GeneratorBundle\Tests\Manipulator;

use Sensio\Bundle\GeneratorBundle\Manipulator\RoutingManipulator;

class RoutingManipulatorTest extends \PHPUnit_Framework_TestCase
{
    public function testHasResourceInAnnotation()
    {
        $tmpDir = sys_get_temp_dir().'/sf2';
        $file = tempnam($tmpDir, 'routing');

        $routing = <<<DATA
acme_demo:
    resource: @AcmeDemoBundle/Controller/
    type:     annotation
DATA;

        file_put_contents($file, $routing);

        $manipulator = new RoutingManipulator($file);
        $this->assertTrue($manipulator->hasResourceInAnnotation('AcmeDemoBundle'));
    }

    public function testHasResourceInAnnotationReturnFalseIfOnlyOneControllerDefined()
    {
        $tmpDir = sys_get_temp_dir().'/sf2';
        $file = tempnam($tmpDir, 'routing');

        $routing = <<<DATA
acme_demo_post:
    resource: "@AcmeDemoBundle/Controller/PostController.php"
    type:     annotation
DATA;

        file_put_contents($file, $routing);

        $manipulator = new RoutingManipulator($file);
        $this->assertFalse($manipulator->hasResourceInAnnotation('AcmeDemoBundle'));
    }
}
