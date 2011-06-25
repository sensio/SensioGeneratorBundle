<?php

namespace Sensio\Bundle\GeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

//annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Sensio\Bundle\GeneratorBundle\Form\GenerateBundleType;
use Sensio\Bundle\GeneratorBundle\Entity\Bundle;

class BundleController extends Controller
{   
    /**
     * @Route("/bundle", name="_generator_bundle")
     * @Template()
     */
    public function generateAction()
    {
        $bundle = new Bundle();
        
        $form = $this->get('form.factory')->create(new GenerateBundleType(), $bundle);
        return array(
            'form' => $form->createView()
        );
    }
}