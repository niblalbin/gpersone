<?php

namespace gpersone\V1\Rest\Session;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;

class SessionResource extends AbstractResourceListener
{
    protected $dbAdapter;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function create($data)
    {
        $email = $data->email ?? null;
        $password = $data->password ?? null;

        if (!$email || !$password) {
            return new ApiProblem(400, 'Email o password mancanti');
        }

        // Verifica credenziali
        $sql = 'SELECT id, pass_email FROM anagrafiche WHERE email = ? LIMIT 1';
        $stmt = $this->dbAdapter->createStatement($sql, [$email]);
        $result = $stmt->execute()->current();

        if (!$result) {
            return new ApiProblem(401, 'Email non trovata');
        }

        $bcrypt = new Bcrypt();
        if (!$bcrypt->verify($password, $result['pass_email'])) {
            return new ApiProblem(401, 'Password non valida');
        }

        // Genera token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

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
    }
}
