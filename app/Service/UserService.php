<?php
namespace Mahatech\AlindoExpress\Service;

use Exception;
use Mahatech\AlindoExpress\Config\DotEnv;
use Mahatech\AlindoExpress\Domain\User;
use Mahatech\AlindoExpress\Model\User\UserCreateRequest;
use Mahatech\AlindoExpress\Model\User\UserLoginRequest;
use Mahatech\AlindoExpress\Model\User\UserLoginResponse;
use Mahatech\AlindoExpress\Repository\UserRepository;

class UserService{
    private UserRepository $userRepo;
    public function __construct($userRepo) {
        $this->userRepo = $userRepo;
    }

    /**
     * Create User Account
     */
    public function createAccount(UserCreateRequest $req){
        $this->createValidate($req);
        try{
            $user = new User;
            $user->userId = $req->userId;
            $user->userPassword = password_hash($req->userPassword, PASSWORD_BCRYPT);
            
            // user data
            $data = [
                'fullname' => $req->userFullname,
                'job' => $req->userJobDesk
            ];
            $user->userData = serialize($data);
            $user->userAccsessLevel = $req->userAccsessLevel;

            DotEnv::set_default_timezone();
            $user->tanggalPembuatan = date('Y/m/d H:i:s');

            $this->userRepo->save($user);
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    /**
     * Create Account validate
     */
    private function createValidate(UserCreateRequest $req){
        if($req->userId == null || $req->userId == ''){
            throw new Exception('id user cannot be empty!');
        }else if($this->userRepo->findById($req->userId) != null){
            throw new Exception('id user sudah pernah dipakai!');
        }

        if($req->userPassword == null || $req->userPassword == ''){
            throw new Exception('password user cannot be empty!');
        }

        if($req->userFullname == null || $req->userFullname == ''){
            throw new Exception('fullname user cannot be empty!');
        }

        if($req->userJobDesk == null || $req->userJobDesk == ''){
            throw new Exception('jobdesk user cannot be empty!');
        }

        if($req->userAccsessLevel == null || $req->userAccsessLevel == '' || is_string($req->userAccsessLevel)){
            throw new Exception('level user user cannot be empty!');
        }
        else if($req->userAccsessLevel > 4){
            $req->userAccsessLevel = 0;
        }
    }

    /**
     * Login Account
     */
    public function login(UserLoginRequest $req): UserLoginResponse{
        $this->userValidation($req);

        try{
            $user = $this->userRepo->findById($req->username);
            if($user != null){
                if(password_verify($req->password, $user->userPassword)){
                    $response = new UserLoginResponse;
                    $response->userId = $user->userId;
                    $response->userAccsessLevel = $user->userAccsessLevel;

                    return $response;
                }else{
                    throw new Exception('username or password is wrong');
                }
            }else{
                throw new Exception('username or password is wrong');
            }
        } catch(Exception $ex){
            throw $ex;
        }
    }

    /**
     * Login validation
     */
    private function userValidation(UserLoginRequest $req){
        if($req->username == null || $req->username == ''){
            throw new Exception('username cannot be empty!');
        }

        if($req->password == null || $req->password == ''){
            throw new Exception('password cannot be empty!');
        }
    }
}