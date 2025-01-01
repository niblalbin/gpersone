<?php
namespace gpersone\V1\Rest\Ruoli;

class RuoliResourceFactory
{
    public function __invoke($services)
    {
        $dbAdapter = $services->get('DbAdapter');
        return new RuoliResource($dbAdapter);
    }
}
