<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private $host = 'localhost';
    private $user = 'recipe_user';
    private $pass = 'MyRecipe!@#';
    private $dbName = 'recipe_db';

    public function __construct()
    {
        $connection = new Capsule();
        $connection->addConnection([
            'driver' => 'mysql',
            'host' => $this->host,
            'database' => $this->dbName,
            'username' => $this->user,
            'password' => $this->pass,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);
    }
}
