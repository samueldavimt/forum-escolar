<?php

class User{

    public $id;
    public $name;
    public $email;
    public $password;
    public $avatar;
    public $grade;
    public $shift;
    public $created_at;
    public $token;

    public function shortName(){   
        $nameSplit = explode(' ', $this->name);
        return $nameSplit[0] . " " . $nameSplit[1];
    }
}

interface UserDao {

    public function insert(User $user);
    public function delete($id);
    public function update(User $user);
    public function findByToken($token);
}