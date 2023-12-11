<?php

namespace MyApp\Model;
use MyApp\Model\Model;

class Chat extends Model
{
    protected $table = "chat_message";
    protected $id = "user_id";

    protected function hasManyCall(){
        return "call_id";
    }
}
?>