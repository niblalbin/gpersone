<?php
namespace gpersone\V1\Rest\Anagrafiche;

use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Stdlib\Parameters;

class AnagraficheResource extends AbstractResourceListener
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    private function getUserRole()
    {
        $identity = $this->getIdentity(); 
        if (method_exists($identity, 'getAuthenticationIdentity')) {
            $authData = $identity->getAuthenticationIdentity();
            return $authData['role'] ?? null;
        }
        return null;
    }

    /**
     * Create (POST /anagrafiche)
     */
    public function create($data)
    {
        $role = $this->getUserRole();
        if ($role !== 1) {
            return new ApiProblem(403, 'Non hai i permessi per creare un\'anagrafica');
        }

        $insertData = [
            'nome'        => $data->nome ?? null,
            'cognome'     => $data->cognome ?? null,
            'cod_fiscale' => $data->cod_fiscale ?? null,
            // finire di aggiungere gli altri campi
        ];

        $this->tableGateway->insert($insertData);
        $newId = $this->tableGateway->getLastInsertValue();

        return $this->fetch($newId);
    }

    /**
     * Fetch singolo (GET /anagrafiche/:id)
     */
    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(['id' => (int) $id]);
        $row = $rowset->current();
        if (! $row) {
            return new ApiProblem(404, 'Anagrafica non trovata');
        }
        return $row;
    }

    /**
     * Fetch all (GET /anagrafiche)
     */
    public function fetchAll($params = [])
    {
        $results = $this->tableGateway->select();
        return $results->toArray();
    }

    /**
     * Update (PUT /anagrafiche/:id)
     */
    public function update($id, $data)
    {
        $role = $this->getUserRole();
        if ($role !== 1) {
            return new ApiProblem(403, 'Non hai i permessi per modificare un\'anagrafica');
        }

        $updateData = [
            'nome'        => $data->nome ?? null,
            'cognome'     => $data->cognome ?? null,
            'cod_fiscale' => $data->cod_fiscale ?? null,
            // anche qua...
        ];

        $exists = $this->fetch($id);
        if ($exists instanceof ApiProblem) {
            return $exists;
        }
        
        $this->tableGateway->update($updateData, ['id' => (int)$id]);
        return $this->fetch($id);
    }

    /**
     * Delete (DELETE /anagrafiche/:id)
     */
    public function delete($id)
    {
        $role = $this->getUserRole();
        if ($role !== 1) {
            return new ApiProblem(403, 'Non hai i permessi per eliminare un\'anagrafica');
        }

        $exists = $this->fetch($id);
        if ($exists instanceof ApiProblem) {
            return $exists;
        }

        $this->tableGateway->delete(['id' => (int)$id]);
        return true;
    }

}
