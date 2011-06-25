<?php

namespace Sensio\Bundle\GeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

//annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Sensio\Bundle\GeneratorBundle\Form\GenerateBundleType;
use Sensio\Bundle\GeneratorBundle\Entity\Bundle;
use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator;
use Sensio\Bundle\GeneratorBundle\Command\Validators;

class BundleController extends Controller
{   
    /**
     * @Route("/bundle", name="_generator_bundle")
     * @Template()
     */
    public function generateAction()
    {
        $request = $this->get('request');
        $bundle = new Bundle();
        
        $form = $this->get('form.factory')->create(new GenerateBundleType(), $bundle);
        
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $namespace = $bundle->namespace_vendor . "\\" . $bundle->namespace_bundle; 
                $dir = '/' === substr($bundle->dir, -1, 1) ? $bundle->dir : $bundle->dir.'/';
                if (!$this->get('filesystem')->isAbsolutePath($dir)) {
                    $dir = dirname($this->get('kernel')->getRootDir()).'/'.$dir;
                }
                
                $generator = new BundleGenerator($this->get('filesystem'), __DIR__.'/../Resources/skeleton/bundle');
                $generator->generate($namespace, $bundle->bundle_name, $dir, $bundle->format, $bundle->structure);
                
                $request->getSession()->setFlash('Your bundle has been generated.');
                return new RedirectResponse($this->generateUrl('_generator'));
            }
        }
        
        return array(
            'form' => $form->createView()
        );
    }
}