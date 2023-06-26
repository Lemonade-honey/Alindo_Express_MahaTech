<?php
namespace Mahatech\AlindoExpress\Service;

use Mahatech\AlindoExpress\Config\DotEnv;
use Mahatech\AlindoExpress\Domain\Session;
use Mahatech\AlindoExpress\Repository\SessionRepository;

class SessionService{
    private static string $COOKIE_NAME = "ALINDO";
    private SessionRepository $sessionRepo;

    public function __construct($sessionRepo) {
        $this->sessionRepo = $sessionRepo;
    }

    /**
     * Session Create
     * @return Session
     */
    public function create(string $user_id, int $accsesLevel, ?bool $month = false): Session{
        $session = new Session;
        $session->idSession = md5(time() . uniqid());
        $session->userId = $user_id;
        $session->accessLevel = $accsesLevel;

        DotEnv::set_default_timezone();

        $session->tanggal = date('Y/m/d H:i:s');

        $this->sessionRepo->save($session);
        if($month){
            setcookie(self::$COOKIE_NAME, $session->idSession, time() + (60 * 60 * 24 * 30), "/");
        }else{
            setcookie(self::$COOKIE_NAME, $session->idSession, time() + (60 * 60 * 1), "/");
        }

        return $session;
    }

    /**
     * Session Destroy
     */
    public function destroy(){
        $sessionIdGet = $_COOKIE[self::$COOKIE_NAME] ?? "";
        $this->sessionRepo->deleteById($sessionIdGet);

        setcookie(self::$COOKIE_NAME, "", 1, "/");
    }

    /**
     * Get session from client
     * @return string userId
     */
    public function current(): ?String{
        $sessionIdGet = $_COOKIE[self::$COOKIE_NAME] ?? "";

        $session = $this->sessionRepo->findById($sessionIdGet);
        if($session == null){
            return null;
        }

        return $session->userId;
    }
}