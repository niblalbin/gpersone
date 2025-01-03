<?php
namespace gpersone\V1\Rest\Nuclei;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\ApiTools\ApiProblem\ApiProblemException;
use gpersone\V1\Rest\Ruoli\RuoliResource;
use gpersone\V1\Rest\Session\SessionResource;

class NucleiResource extends AbstractResourceListener
{
    protected $dbAdapter;
    protected $tableGateway;
    
    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
    {
        $this->dbAdapter = $dbAdapter;
        $this->tableGateway = $tableGateway;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array|Parameters $params
     * @return ApiProblem|mixed
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
            // Verifica token
            $sessionResource = new SessionResource($this->dbAdapter);
            $sessionValid = $sessionResource->checkSession($token);
            if (!$sessionValid) {
                return new ApiProblem(500, 'Token scaduto, riavvia la sessione.');
            }

            // Verifica ruolo
            // $ruoliResource = new RuoliResource($this->dbAdapter);
            // $esitoRuolo = $ruoliResource->checkRuolo($token);
            // if (isset($esitoRuolo['error'])) {
            //     return new ApiProblem(403, $esitoRuolo['error']);
            // }

            // $idRuolo = $esitoRuolo['id_ruolo'] ?? null;

            // Recupera l'utente corrente dal token
            $sql = "SELECT user_id FROM sessions WHERE token = ?";
            $statement = $this->dbAdapter->createStatement($sql, [$token]);
            $result = $statement->execute()->current();

            $idUtente = $result['user_id'];

            // Se l'utente è amministratore, restituisci tutte le anagrafiche
            // if ($idRuolo !== 2) {
            //     $results = $this->tableGateway->select();
            //     return $results;
            // }

            // Recupera il nucleo familiare dell'utente
            $sql = "SELECT id_nucleo FROM relazioni_familiari WHERE id_persona = ?";
            $statement = $this->dbAdapter->createStatement($sql, [$idUtente]);
            $result = $statement->execute();
            if (!$result->isQueryResult()) {
                return new ApiProblem(403, 'Nucleo familiare non trovato');
            }

            $idNucleo = $result->current();
            $idNucleo = $idNucleo['id_nucleo'];

            // Recupera le anagrafiche dei membri dello stesso nucleo familiare
            $sql = "
                SELECT a.*, r.grado_parentela
                FROM anagrafiche a
                JOIN relazioni_familiari r ON a.id = r.id_persona
                WHERE r.id_nucleo = ?
            ";
            $statement = $this->dbAdapter->createStatement($sql, [$idNucleo]);
            $results = $statement->execute();

            $data = [];
            foreach ($results as $row) {
                $data[] = $row;
            }

            return $data;
        } catch (\Throwable $th) {
            return new ApiProblem(500, 'Errore interno del server.');
        }
    }


    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
