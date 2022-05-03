<?php

class Answer{

    public $id;
    public $id_user;
    public $id_topic;
    public $body;
    public $created_at;

    public function getBody(){

        $body = str_replace("&#13;", "\n", $this->body);
        return $body;
    }
    
}

interface AnswerDao{
    
}