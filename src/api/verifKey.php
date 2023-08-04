<?php

function verifKey($conn,$keyUrl): bool
{


    $stmt = $conn->prepare("SELECT * FROM api_key");
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $rows = $result->fetch_all();
        // Parcours des résultats
        foreach ($rows as $row) {
            if($row[0] == $keyUrl){
                return true;
            }
        }

    } else {
        echo 'no row database';
        return false;
    }

    echo  'error sql';
    return false;
}