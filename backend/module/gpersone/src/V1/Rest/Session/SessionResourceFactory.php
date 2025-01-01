<?php

namespace gpersone\V1\Rest\Session;

use Laminas\Db\Adapter\Adapter;
use Psr\Container\ContainerInterface;

class SessionResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $dbAdapter = $container->get(Adapter::class);
        return new SessionResource($dbAdapter);
    }
}
