<?php
namespace gpersone\V1\Rest\User;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\ApiTools\ApiProblem\ApiProblemException;
use gpersone\V1\Rest\Session\SessionResource;

class UserResource extends AbstractResourceListener
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
        return 'fetch user';
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

        // verifico se il token è ancora valido
        $es = new SessionResource($this->dbAdapter);
        $esito = $es->checkSession($token);
        if($esito != true){
            return new ApiProblem(500, 'Token scaduto, riavvia la sessione.');
        }

        try {
            // query per il recupero dell'utente, ricerca tramite token
            $sql = 'SELECT 
                        a.id,
                        a.nome,
                        a.cognome,
                        a.sesso,
                        a.nas_luogo,
                        a.nas_regione,
                        a.nas_prov,
                        a.nas_cap,
                        a.data_nascita,
                        a.cod_fiscale,
                        a.res_luogo,
                        a.res_regione,
                        a.res_prov,
                        a.res_cap,
                        a.indirizzo,
                        a.telefono,
                        a.email,
                        a.id_ruolo
                    FROM anagrafiche a
                    LEFT JOIN sessions s ON s.user_id = a.id
                    WHERE s.token = ?;';
            $stmt = $this->dbAdapter->createStatement($sql, [$token]);
            $result = $stmt->execute()->current();

            return [$result];
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
