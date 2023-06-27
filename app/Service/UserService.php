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
            $user->userFullname = $req->userFullname;

            // user data
            $data = [
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

    /**
     * Pagination, default 10/halaman
     */
    public function getStaffPag(int $halaman): array{
        if(is_string($halaman)){
            throw new Exception('page number must type of string');
        }else if($halaman < 0){
            throw new Exception('invalid page number');
        }else if($halaman > ceil($this->userRepo->totalRow()/10)){
            throw new Exception('invalid page number');
        }

        try{
            $page = ($halaman * 10) - 10;
            foreach ($this->userRepo->pagination($page, 10) as $dataDB) {
                $data[] = [
                    'number' => ++$page,
                    'id' => $dataDB['id'],
                    'fullname'=> $dataDB['fullname'],
                    'data' => unserialize($dataDB['data'])
                ];
            }
            return $data;
        } catch(Exception $ex){
            throw $ex;
        }
    }

    /**
     * Search User Name Service
     * 
     * Mencari berdasarkan fullname yang mirip (LIKE)
     */
    public function searchFullname(string $name): ?array{
        if($name == null || $name == ''){
            throw new Exception('name search cannot be empty');
        }

        try{
            $number = 1;
            $dataDB = $this->userRepo->searchByFullname($name);
            if($dataDB != null){
                foreach($dataDB as $row){
                    $data[] = [
                        'number' => $number++,
                        'id' => $row['id'],
                        'fullname'=> $row['fullname'],
                        'data' => unserialize($row['data'])
                    ];
                }

                return $data;
            }else{
                return null;
            }
        } catch(Exception $ex){
            throw $ex;
        }
    }
}