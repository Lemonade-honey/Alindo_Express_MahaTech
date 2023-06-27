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
        $stmt = $this->connection->prepare('INSERT INTO users(id, password, fullname, data, access_level, tanggal_pembuatan) VALUES(?, ?, ?, ?, ?, ?)');
        $stmt->execute([$user->userId, $user->userPassword, $user->userFullname, $user->userData, $user->userAccsessLevel, $user->tanggalPembuatan]);

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
                $user->userFullname = $row['fullname'];
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

    /**
     * Get All Staff Data
     */
    public function getAllData(): array{
        $stmt = $this->connection->prepare('SELECT * FROM users');
        $stmt->execute();

        try{
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $row){
                $array[] = $row;
            }

            return $array;
        }
        finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Jumlah Row pada tabel users DB
     */
    public function totalRow(){
        $stmt = $this->connection->prepare('SELECT * FROM users');
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * Pagination User/Staff
     */
    public function pagination(int $halamanAwal, int $batas): array{
        $stmt = $this->connection->prepare('SELECT id, fullname, data FROM users LIMIT :start, :batas');
        $stmt->bindParam(':start', $halamanAwal, PDO::PARAM_INT);
        $stmt->bindParam(':batas', $batas, PDO::PARAM_INT);
        $stmt->execute();
        try{
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $row){
                $array[] = $row;
            }

            return $array;
        }
        finally{
            $stmt->closeCursor();
        }
    }

    /**
     * Search User similiar fullname user
     * 
     * Mencari berdasarkan kemiripan data fullname
     */
    public function searchByFullname(string $fullname): ?array{
        $stmt = $this->connection->prepare("SELECT id, fullname, data FROM users WHERE fullname LIKE CONCAT('%', ?, '%')");
        $stmt->execute([$fullname]);

        try{
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($row){
                foreach($row as $data){
                    $array[] = $data;
                }

                return $array;
            }else{
                return null;
            }

        }finally{
            $stmt->closeCursor();
        }

    }
}