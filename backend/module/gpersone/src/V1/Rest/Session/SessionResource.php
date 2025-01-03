<?php
namespace gpersone\V1\Rest\Session;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\Adapter;
use Laminas\ApiTools\ApiProblem\ApiProblemException;

class SessionResource extends AbstractResourceListener
{
    protected $dbAdapter;
    protected $tableGateway;
    
    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->tableGateway = new TableGateway('sessions', $this->dbAdapter);
    }

    public function checkSession($token){
        try {
            $sql = 'SELECT expires_at FROM sessions WHERE token = ?';
            $stmt = $this->dbAdapter->createStatement($sql, [$token]);
            $res = $stmt->execute()->current();

            if (!$res) {
                return ['error' => 'Token non trovato'];
            }
    
            $currentTime = new \DateTime();
            $expiresAt = new \DateTime($res['expires_at']);

            if ($currentTime > $expiresAt) {
                $this->tableGateway->delete(['token' => $token]);
                return false;
            }
    
            return true;
        } catch (\Exception $e) {
            return ['error' => 'Errore interno del server'];
        }
    }

    public function create($data)
    {
        $email = $data->email ?? null;
        $password = $data->password ?? null;

        if (!$email || !$password) {
            return new ApiProblem(401, 'Email o password non valida.');
            // return ['error' => 'Email o password non valida'];
        }

        try {
            // Verifica credenziali
            $sql = 'SELECT id, pass_email FROM anagrafiche WHERE email = ? LIMIT 1';
            $stmt = $this->dbAdapter->createStatement($sql, [$email]);
            $result = $stmt->execute()->current();

            if (!$result) {
                return new ApiProblem(401, 'Email non trovata.');
                // return ['error' => 'Email non trovata'];
            }

            // Verifica password con SHA256
            if (hash('sha256', $password) !== $result['pass_email']) {
                return ['error' => 'Email o password non valida'];
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
            return ['error' => 'Errore interno del server'];

        }
    }

    public function fetchAll($params = [])
    {
        // recupera gli headers
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        $token = trim($authHeader);

        if (!$token) {
            return ['error' => 'Token mancante o non valido'];
        }

        try {
            $sql = 'SELECT token, user_id, expires_at FROM sessions WHERE token = ? LIMIT 1';
            $stmt = $this->dbAdapter->createStatement($sql, [$token]);
            $session = $stmt->execute()->current();

            if (!$session) {
                return ['error' => 'Token non trovato'];
            }

            $currentTime = new \DateTime();
            $expiresAt = new \DateTime($session['expires_at']);

            if ($currentTime > $expiresAt) {
                $this->tableGateway->delete(['token' => $token]);
                return ['error' => 'Token scaduto'];
            }

            $response = new \stdClass();
            $response->isValid = true;
            $response->user_id = $session['user_id'];
            $response->expires_at = $session['expires_at'];

            return $response;
        } catch (\Exception $e) {
            return ['error' => 'Errore interno del server'];
        }
    }
}
