<?php

class DB{
    public $connection;

    public function __construct(){
        $this->connection = mysqli_connect("localhost", "root", "", "php24");
    }
}