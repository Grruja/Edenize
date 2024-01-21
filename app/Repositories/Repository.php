<?php


namespace App\Repositories;


use Database\Database;

class Repository
{
    protected $dbConnection;

    public function __construct()
    {
        $db = new Database();
        $this->dbConnection = $db->getConnection();
    }
}