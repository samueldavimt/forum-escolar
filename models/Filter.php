<?php

class Filter{

    public function input($input){

        $input = strip_tags($input);
        $input = filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS);
        return $input;
    }

    public function id($id){

        $id = strip_tags($id);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $id = addslashes($id);
        return $id;
    }
}