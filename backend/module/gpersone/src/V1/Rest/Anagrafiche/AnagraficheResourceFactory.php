<?php
namespace gpersone\V1\Rest\Anagrafiche;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;

class AnagraficheResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = new TableGateway('anagrafiche', $dbAdapter);

        return new AnagraficheResource($tableGateway);
    }
}
