<?php
//Assunzione dei dati dell'utente in arrivo da registrazione.php tramite metodo POST
$nome = $_POST['nome'];  
$cognome = $_POST['cognome'];
$datanascita = $_POST['data_di_nascita'];
$email = $_POST['email'];
$passwordC = $_POST['password'];

try
{
    $host = 'mysql:Mysql@127.0.0.1:3306';      // identifica l'host
    $user = 'rox';                            // nome dell'istanza
    $database = 'db_termostato';             // nome del database
    $psw = 'root';                          // password di accesso al database
    $pdo = new PDO($host,$user, $psw);     // tentativo di connessione
    
    $db = 'USE db_termostato'; //utilizzo del database 
    $pdo ->exec($db);

    //Query per contare il numero di utenti associati all'email inserita dall'utente nella pagina regisrazione.php
    $query = "SELECT nome FROM tbl_utente WHERE email = '$email';";
    $res = $pdo->query($query);
    $count = $res->rowCount(); // Conta il numero di righe restituite dalla query

    //Se non esiste alcun utente associato all'email(count<=0) effettua la query di inserimento dati nella tabella utente
    if($count <= 0) 
    {
        //Se non trova email registra l'utente normalmente
        $query = "INSERT INTO tbl_utente(nome, cognome, data_nascita, email, passw) ".
             "VALUES('$nome', '$cognome', '$datanascita', '$email', '$passwordC')";
        $pdo->query($query); //Eseguo la query

        header("Location: ./login.php"); /*L'utente ora che è registrato correttamente nel database
                                            viene indirizzato di nuovo alla pagina di login*/
        exit;
    }

    /*Se viene trovata un'email già registrata nel database, l'utente rimane nella pagina di registrazione 
    e visualizza il messaggio di errore(Esiste già un account associato a questa email)
    */
    else if($count > 0)
    {
        session_start(); //Viene creata una sessione per comunicare alla pagina il messaggio di errore 
        $_SESSION["resultRegistrazione"] = "false";
        header("Location: ./registrazione.php"); //Reindirizzamanto alla pagina registrazione.php
    } 
} 
    catch(Exception $ex) 
    {
        echo $ex;
    }
    
    $pdo = null; // chiusura della connessione
