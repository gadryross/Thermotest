<?php
$host = 'mysql:Mysql@127.0.0.1:3306';      // identifica l'host
$user = 'rox';                            // nome dell'istanza
$database = 'db_termostato';             // nome del database
$psw = 'root';                          // password di accesso al database
$pdo = new PDO($host,$user, $psw);     // tentativo di connessione

//Utilizzo del database
$sql = 'USE db_termostato;';
$pdo -> exec($sql);

//Controlla se la richiesta è avvenuta tramite POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = $_POST['email'];  // Recupera i valori inseriti nel form
    $password = $_POST['password'];

    //query che seleziona l'utente che ha email e password corrispondenti a quelle che ha inserito nella pagina di login
    $query = "SELECT nome FROM tbl_utente WHERE passw = '$password' AND email = '$email'"; 
    $res = $pdo->query($query);

    // Conta il numero di righe restituite dalla query
    $count = $res->rowCount(); 

    if ($count > 0) 
    {
        /*Se il numero delle righe risultanti è > 0, l'utente esiste e la password è corretta, 
        l'utente viene indirizzato alla homepage dove potrà visualizzare le misurazioni*/
        session_start();

        //Manda l'email dell'utente loggato alla homepage per identificarlo, attravreso una label
        $_SESSION["Utente"] = $email; 
        header("Location: ./termostato.php");
        exit;
    } 
    else 
    {
        //Se il login è sbagliato, l'utente viene reindirizzato alla pagina di login dove visualizzerà un errore 
        session_start();
        $_SESSION["resultLogin"] = "false";
        header("Location: ./login.php");
        exit;
    }
}
$pdo= null; //chiusura della connessione
?>