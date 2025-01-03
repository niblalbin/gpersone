<?php
namespace gpersone\V1\Rest\Anagrafiche;

use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Stdlib\Parameters;
use gpersone\V1\Rest\Ruoli\RuoliResource;
use gpersone\V1\Rest\Session\SessionResource;

class AnagraficheResource extends AbstractResourceListener
{
    protected $dbAdapter;
    protected $tableGateway;
    
    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
    {
        $this->dbAdapter = $dbAdapter;
        $this->tableGateway = $tableGateway;
    }

    /**
     * Create (POST /anagrafiche)
     */
    public function create($data)
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        $token = trim($authHeader);

        if (!$token) {
            return new ApiProblem(401, 'Token mancante o non valido');
        }

        try {
            // verifico se il token è ancora valido
            $es = new SessionResource($this->dbAdapter);
            $esito = $es->checkSession($token);
            if($esito != true){
                return new ApiProblem(500, 'Token scaduto, riavvia la sessione.');
            }

            $es = new RuoliResource($this->dbAdapter);
            $esito = $es->checkRuolo($token);

            if (isset($esito['error'])) {
                return new ApiProblem(403, $esito['error']);
            }
        }catch (\Throwable $th) {
            return new ApiProblem(500, 'Errore server: ' . $th->getMessage());
        }

        $requiredFields = ['nome', 'cognome', 'cod_fiscale', 'email'];
        foreach ($requiredFields as $field) {
            if (empty($data->$field)) {
                return new ApiProblem(400, "Il campo '$field' è obbligatorio.");
            }
        }

        $insertData = [
            'nome'        => $data->nome,
            'cognome'     => $data->cognome,
            'sesso'       => $data->sesso ?? null,
            'nas_luogo'   => $data->nas_luogo ?? null,
            'nas_regione' => $data->nas_regione ?? null,
            'nas_prov'    => $data->nas_prov ?? null,
            'nas_cap'     => $data->nas_cap ?? null,
            'data_nascita'=> $data->data_nascita ?? null,
            'cod_fiscale' => $data->cod_fiscale,
            'res_luogo'   => $data->res_luogo ?? null,
            'res_regione' => $data->res_regione ?? null,
            'res_prov'    => $data->res_prov ?? null,
            'res_cap'     => $data->res_cap ?? null,
            'indirizzo'   => $data->indirizzo ?? null,
            'telefono'    => $data->telefono ?? null,
            'email'       => $data->email,
            'id_ruolo'    => $data->id_ruolo ?? 2,
            'pass_email'  => hash('sha256', 'cambiami')
        ];

        try {
            $this->tableGateway->insert($insertData);
            $newId = $this->tableGateway->getLastInsertValue();

            return $this->fetch($newId);
        } catch (\Throwable $th) {
            return new ApiProblem(500, 'Errore durante la creazione dell\'anagrafica: ' . $th->getMessage());
        }
    }

    /**
     * Fetch singolo (GET /anagrafiche/:id)
     */
    public function fetch($id)
    {
        return 'test fetch anagrafiche';
    }

    /**
     * Fetch all (GET /anagrafiche)
     */
    public function fetchAll($params = [])
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        $token = trim($authHeader);

        if (!$token) {
            return new ApiProblem(401, 'Token mancante o non valido');
        }

        try {
            // verifico se il token è ancora valido
            $es = new SessionResource($this->dbAdapter);
            $esito = $es->checkSession($token);
            if($esito != true){
                return new ApiProblem(500, 'Token scaduto, riavvia la sessione.');
            }

            $es = new RuoliResource($this->dbAdapter);
            $esito = $es->checkRuolo($token);

            if (isset($esito['error'])) {
                return new ApiProblem(403, $esito['error']);
            }

            if (isset($esito['id_ruolo']) && $esito['id_ruolo'] !== 2) {
                $results = $this->tableGateway->select();
                return $results;
            } else {
                return new ApiProblem(403, 'Ruolo non autorizzato a visualizzare questa lista.');
            }
        } catch (\Throwable $th) {
            return new ApiProblem(500, 'Errore interno del server.');
        }
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
