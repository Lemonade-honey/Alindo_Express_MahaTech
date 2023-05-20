<?php

/**
 * Desain Database => Singleton database
 */

 namespace Mahatech\AlindoExpress\Config;

use PDO;

 class Database{
    private static ?PDO $pdo = null;
    
    public static function getConnection(): ?PDO{
        try {
            self::$pdo = new PDO(
                'mysql:host=localhost;dbname=mahatec_alindo',
                'root',
                ''
            );
            return self::$pdo;
        } catch (\Exception $exception) {
            http_response_code(503);
            die($exception->getMessage());
        }
    }

    //PDO Transaction
    public static function beginTransaction(){
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction(){
        self::$pdo->commit();
    }

    public static function rollbackTransaction(){
        self::$pdo->rollBack();
    }
 }