<?php

function createConnection()
{
// Informations de connexion à la base de données
    $host = 'be820041-001.eu.clouddb.ovh.net'; // Remplace par le nom d'hôte de ta base de données
    $username = 'technique'; // Remplace par le nom d'utilisateur de ta base de données
    $password = 'Awxcert1999'; // Remplace par le mot de passe de ta base de données
    $dbname = 'drinksaverDB'; // Remplace par le nom de ta base de données
    $port = '35718';

// Crée une connexion à la base de données
    $conn = new mysqli($host, $username, $password, $dbname, $port);

// Vérifie si la connexion a échoué
    if ($conn->connect_error) {
        return null;
    }else{
        return $conn;
    }
}

function selectTest()
{

    $conn = createConnection();

    if ($conn != null) {

        $sql = 'SELECT * FROM produits ORDER BY name';

        foreach ($conn->query($sql) as $row) {
            print $row['Name'] . "\t";
            print  $row['Image'] . "\n";
        }
    }


}