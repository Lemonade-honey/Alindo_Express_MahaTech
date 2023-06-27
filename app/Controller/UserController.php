<?php
namespace Mahatech\AlindoExpress\Controller;

use Exception;
use Mahatech\AlindoExpress\App\View;
use Mahatech\AlindoExpress\Config\Database;
use Mahatech\AlindoExpress\Model\User\UserCreateRequest;
use Mahatech\AlindoExpress\Model\User\UserLoginRequest;
use Mahatech\AlindoExpress\Repository\SessionRepository;
use Mahatech\AlindoExpress\Repository\UserRepository;
use Mahatech\AlindoExpress\Service\SessionService;
use Mahatech\AlindoExpress\Service\UserService;

class UserController{
    private UserService $userService;
    private SessionService $sessionService;
    public function __construct() {
        $connection = Database::getConnection();

        $userRepo = new UserRepository($connection);
        $this->userService = new UserService($userRepo);

        $sessionRepo = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepo);
    }

    /**
     * GET Login Page
     */
    public function login(){
        // View::render()
    }

    /**
     * POST Login Page
     */
    public function postLogin(){
        $req = new UserLoginRequest;
        $req->username = $_POST['username'];
        $req->password = $_POST['password'];

        try{
            $response = $this->userService->login($req);
            $this->sessionService->create($response->userId, $response->userAccsessLevel);

            // View::redirect()
        } catch (Exception $ex){
            // View::render( '', [
            //     'error' => $ex->getMessage()
            // ]);
        }
    }

    /**
     * GET Create Account (High level)
     */
    public function create(){
        // View::render()
    }

    /**
     * POST Create Account (High level)
     */
    public function postCreate(){
        $req = new UserCreateRequest;
        $req->userId = $_POST['user-id'];
        $req->userPassword = $_POST['password'];
        $req->userFullname = $_POST['fullname'];
        $req->userJobDesk = $_POST['jobdesk'];
        $req->userAccsessLevel = $_POST['level'];

        try{
            $this->userService->createAccount($req);
            // View::redirect()
        } catch(Exception $ex){
            View::render('', [
                'error' => $ex->getMessage()
            ]);
        }
    }

    /**
     * GET List Staf User (High level)
     */
    public function staf(){
        // list data
        // View::render()
    }

    /**
     * GET Detail Staff (High level)
     */
    public function detailStaf(){

    }

    /**
     * GET Update Staf (High level)
     */
    public function updateStaff(){

    }

    /**
     * POST Update Staf
     */
    public function postUpdateStaf(){
        
    }
}