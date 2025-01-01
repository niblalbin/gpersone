<?php
namespace gpersone\V1\Rest\Session;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;

class SessionResource extends AbstractResourceListener
{
    protected $dbAdapter;
    protected $tableGateway;
    
    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
    {
        $this->dbAdapter = $dbAdapter;
        $this->tableGateway = $tableGateway;
    }

    public function create($data)
    {
        $email = $data->email ?? null;
        $password = $data->password ?? null;

        if (!$email || !$password) {
            return new ApiProblem(400, 'Email o password mancanti');
        }

        try {
            // Verifica credenziali
            $sql = 'SELECT id, pass_email FROM anagrafiche WHERE email = ? LIMIT 1';
            $stmt = $this->dbAdapter->createStatement($sql, [$email]);
            $result = $stmt->execute()->current();

            if (!$result) {
                return new ApiProblem(401, 'Email non trovata');
            }

            // Verifica password con SHA256
            if (hash('sha256', $password) !== $result['pass_email']) {
                return new ApiProblem(401, 'Password non valida');
            }

            // Genera token
            $token = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+3 hour'));

            // Salva sessione
            $insertSql = '
                INSERT INTO sessions (token, user_id, expires_at)
                VALUES (?, ?, ?)
            ';
            $this->dbAdapter->createStatement($insertSql, [
                $token,
                $result['id'],
                $expiresAt
            ])->execute();

            // Restituisci token
            return [
                'token' => $token,
                'expires_at' => $expiresAt,
            ];
        } catch (\Exception $e) {
            return new ApiProblem(500, 'Errore interno del server: ' . $e->getMessage());
        }
    }
}
