<?php
namespace Mahatech\AlindoExpress\Middleware;

use Mahatech\AlindoExpress\App\View;
use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Repository\SessionRepository;
use Mahatech\AlindoExpress\Service\SessionService;

class Mustlogin implements Middleware{
    private SessionService $sessionService;

    public function __construct() {
        $connection = Database::getConnection();
        $sessionRepo = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepo);
    }
    public function before(): void{
        if($this->sessionService->current() == null){
            View::redirect('/login');
        }
    }
}