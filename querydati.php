<?php
    $host = 'mysql:Mysql@127.0.0.1:3306';     // identifica l'host
    $user = 'rox';                           // nome dell'istanza
    $database = 'db_termostato';            // nome del database
    $psw = 'root';                         // password di accesso al database
    $pdo = new PDO($host,$user, $psw);    // tentativo di connessione

    $db = 'USE db_termostato'; //utilizzo del database
    $pdo ->exec($db);
   
    // Setta l'intestazione Content-Type per indicare che la risposta è in formato JSON
    header('Content-Type: application/json');
 
    //Query che prende l'ultima misurazione salvata dal database
    $sql = "SELECT temperatura, umidita, fumo, time_stamp FROM tbl_misurazione ORDER BY id_misurazione DESC LIMIT 1";
    $result = $pdo -> query($sql);

    //Salvo i dati in arrivo dalla query in un array associativo
    $dati = $result->fetch(PDO::FETCH_ASSOC);

    /*Restituisco il valore dei dati in formato json, nella pagina termostato.php 
    attravrso jquery viene effettuata la get per prendere i dati in formato json*/
    echo json_encode($dati);
?>
