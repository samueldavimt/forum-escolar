<?php

class Topic{

    public $id;
    public $id_user;
    public $category;
    public $body;
    public $state;
    public $created_at;

    public function getBody(){

        $body = str_replace("&#13;", "\n", $this->body);
        return $body;
    }

}

interface TopicDao{

    
}