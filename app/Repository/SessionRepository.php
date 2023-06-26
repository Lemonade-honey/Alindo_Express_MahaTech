<?php

namespace Mahatech\AlindoExpress\Repository;

use Mahatech\AlindoExpress\Domain\Session;
use PDO;
class SessionRepository{
    private PDO $connection;
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Save Session
     */
    public function save(Session $session): Session{
        $stmt = $this->connection->prepare('INSERT INTO sessions(id, user_id, level, tanggal_pembuatan) VALUES(?, ?, ?, ?)');
        $stmt->execute([$session->idSession, $session->userId, $session->accessLevel, $session->tanggal]);

        return $session;
    }

    /**
     * Search Session by Id
     * @return Session | null
     */
    public function findById(string $idSession): ?Session{
        $stmt = $this->connection->prepare('SELECT id, user_id, level, tanggal_pembuatan FROM sessions WHERE id = ?');
        $stmt->execute([$idSession]);

        try{
            if($row = $stmt->fetch()){
                $session = new Session;
                $session->idSession = $row['id'];
                $session->userId = $row['user_id'];
                $session->accessLevel = $row['level'];
                $session->tanggal = $row['tanggal_pembuatan'];

                return $session;
            }else{
                return null;
            }
        } finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Delete session by Id
     */
    public function delete(string $idSession): bool{
        $stmt = $this->connection->prepare('DELETE FROM sessions WHERE id = ?');
        $stmt->execute([$idSession]);

        return true;
    }
}