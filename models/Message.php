<?php

class Message{

    public function return($type, $msg, $data=false){

        $data = ['type' => $type, 'msg' => $msg, 'data' => $data];
        
        echo json_encode($data);
        exit;
    }
}