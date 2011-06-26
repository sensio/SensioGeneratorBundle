<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('{{ bundle }}_homepage', new Route('/{name}', array(
    '_controller' => '{{ bundle }}:Default:index',
)));

return $collection;
