<?php
namespace Mahatech\AlindoExpress\Model\User;
class UserCreateRequest{
    public ?string $userId;
    public ?string $userPassword;
    public ?string $userFullname;
    public ?string $userJobDesk;
    public ?int $userAccsessLevel;
}