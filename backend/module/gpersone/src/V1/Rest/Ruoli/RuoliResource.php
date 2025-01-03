<?php
namespace gpersone\V1\Rest\Ruoli;

use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\Stdlib\Parameters;
use gpersone\V1\Rest\Session\SessionResource;

class RuoliResource extends AbstractResourceListener
{
    protected $dbAdapter;
    protected $tableGateway;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->tableGateway = new TableGateway('ruoli', $this->dbAdapter);
    }

    public function checkRuolo($token){
        try {
            // verifico se il token è ancora valido
            $es = new SessionResource($this->dbAdapter);
            $esito = $es->checkSession($token);
            if($esito != true){
                return new ApiProblem(500, 'Token scaduto, riavvia la sessione.');
            }

            $sql = 'SELECT s.token, s.user_id, s.expires_at, a.* FROM sessions AS s LEFT JOIN anagrafiche AS a on a.id = s.user_id WHERE token = ? AND a.id_ruolo = 1';
            $stmt = $this->dbAdapter->createStatement($sql, [$token]);
            $res = $stmt->execute()->current();

            if (!$res) {
                return ['error' => 'Token non trovato o permessi insufficenti'];
            }

            return $res;
        } catch (\Exception $e) {
            return ['error' => 'Errore interno del server'];
        }
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
        return new ApiProblem(405, 'The GET method has not been defined for collections');
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
