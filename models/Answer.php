<?php

class Answer{

    public $id;
    public $id_user;
    public $id_topic;
    public $body;
    public $created_at;

    public function getBody(){

        $body = str_replace("&#13;", "\n", $this->body);
        $body = str_replace("&#10;", "\n", $this->body);
        return $body;
    }

    public function replyDate(){

        $firstDate  = new DateTime($this->created_at);
        $secondDate = new DateTime("now");
        $dateMoments = $firstDate->diff($secondDate);

        $year = $dateMoments->y;
        $month = $dateMoments->m;
        $days = $dateMoments->d;
        $hours = $dateMoments->h;
        $minutes = $dateMoments->i;
        $seconds = $dateMoments->s;

        $phraseTime = false;
        $numTime = false;

        if($year){
            $phraseTime = "hora(s)";
            $numTime = $year;
        }else if($month){
            $phraseTime = "mêses";
            $numTime = $month;
        }else if($days){
            $phraseTime = "dia(s)";
            $numTime = $days;
        }else if($hours){
            $phraseTime = "hora(s)";
            $numTime = $hours;
        }else if($minutes){
            $phraseTime = "minuto(s)";
            $numTime = $minutes;
        }else if($seconds){
            $phraseTime = "segundo(s)";
            $numTime = $seconds;
        }else{
            return "Agora Mesmo";
        }

        return "Há $numTime $phraseTime";
    }
    
}

interface AnswerDao{
    
}