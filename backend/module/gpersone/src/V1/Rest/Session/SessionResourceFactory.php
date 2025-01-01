<?php

namespace gpersone\V1\Rest\Session;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;

class SessionResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = new TableGateway('session', $dbAdapter);

        return new SessionResource($dbAdapter, $tableGateway);
    }
}
