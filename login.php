<!DOCTYPE html>
<html>  
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css" >
    <link rel="icon" type="image/x-icon" href="logo.png">
</head>
<body>
    <div class="login-container">
        <h2>Accesso</h2>
            <form action = "trovautente.php" method="post">
                <img src="https://www.pcdc.com.gr/wp-content/uploads/2019/12/login-icon@3x.png" alt="immagine utente">
                <input type="text" class="login-input" name="email" placeholder="Email" required>
                <input type="password" class="login-input" name="password" placeholder="Password" required>
                <button type="submit" class="login-button" >Accedi</button>
                <!-- Ritorno da trovautente.php se account non trovato-->
                <p style="color: red; display:none;" id="Error-utente">Utente non trovato</p>
                <?php
                    echo "<script>let p_err = document.querySelector('#Error-utente');</script>";
                    session_start();
                    
                    /*Se la sessione ["resultLogin"], proveniente da trovautente.php, ritorna false(utente non trovato),
                    visualizzo il paragrafo di errore che di base è nascoscosto
                    */
                    if(isset($_SESSION["resultLogin"]) && $_SESSION["resultLogin"]=="false"){
                        echo "<script>p_err.style.display='block';</script>";
                        unset($_SESSION["resultLogin"]);
                    }
                ?>
                <a href="registrazione.php" class="registartion-container">Non hai un account? Registrati</a>
            </form>
    </div>
</body>
</html>

