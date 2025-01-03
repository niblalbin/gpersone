<?php
namespace gpersone\V1\Rest\Nuclei;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;

class NucleiResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = new TableGateway('nuclei_familiari', $dbAdapter);

        return new NucleiResource($dbAdapter, $tableGateway);
    }
}