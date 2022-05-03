<?php

class Redirect{

    public static function local($base, $where){

        if($where == "back"){
            header("Location: ". $_SERVER['HTTP_REFERER']);
            exit;
            
        }else{
            header("Location: ". $base . $where);
            exit;
        }
    }
}