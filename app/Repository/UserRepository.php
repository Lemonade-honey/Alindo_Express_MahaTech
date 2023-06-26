<?php

namespace Mahatech\AlindoExpress\Repository;
use Mahatech\AlindoExpress\Domain\User;
use PDO;
class UserRepository{
    private PDO $connection;
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    /**
     * Save User Data
     */
    public function save(User $user): User{
        $stmt = $this->connection->prepare('INSERT INTO users(id, password, data, access_level, tanggal_pembuatan) VALUES(?, ?, ?, ?, ?)');
        $stmt->execute([$user->userId, $user->userPassword, $user->userData, $user->userAccsessLevel, $user->tanggalPembuatan]);

        return $user;
    }

    /**
     * Search User By Id
     */
    public function findById(string $userId): ?User{
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        try{
            if($row = $stmt->fetch()){
                $user = new User;
                $user->userId = $row['id'];
                $user->userPassword = $row['password'];
                $user->userData = $row['data'];
                $user->userAccsessLevel = $row['access_level'];

                return $user;
            }else{
                return null;
            }
        } finally{
            $stmt->closeCursor();
        }
    }
}