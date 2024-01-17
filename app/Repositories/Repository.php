<?php


namespace App\Repositories;


use Database\Database;

class Repository
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }
}