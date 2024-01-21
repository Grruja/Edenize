<?php


namespace Database;


use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

class Database
{
    private $connection;

    public function __construct()
    {
        $this->loadEnv();
        $this->connect();
    }

    private function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    private function connect()
    {
        $dbHost = $_ENV['DB_HOST'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        $dbName = $_ENV['DB_DATABASE'];

        $this->connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

        if ($this->connection->connect_error) {
            die('Connection failed:'. $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}