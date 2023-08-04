<?php

function createConnection()
{
    function loadEnv($path = '.env') {
        // Obtient le chemin absolu du fichier .env en fonction de l'emplacement du script en cours d'exécution
        $envFilePath = __DIR__ . DIRECTORY_SEPARATOR . $path;

        if (!file_exists($envFilePath)) {
            throw new \Exception('The .env file not found.');
        }

        $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            putenv($line);
        }
    }


    loadEnv('../.env');

    $host = getenv("DB_HOST");
    $username = getenv("DB_USERNAME");
    $password = getenv("DB_PASSWORD");
    $dbname = getenv("DB_DBNAME");
    $port = getenv("DB_PORT");


// Vérifie si la connexion a échoué
    try{
        $conn = new mysqli($host, $username, $password, $dbname, $port);
        if ($conn->connect_error) {
            return null;
        }else{
            return $conn;
        }
    } catch(Exception  $error){
        echo $error ;
    }



}