<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="registrazione.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <title>Registrazione e Login</title>
</head>
<body>
    <div class="registration-container">
        <h2>Registrazione</h2>
            <form action="registrautente.php" method="post">
                <input type="text" class="registration-input" name="nome" placeholder="Nome" required>
                <input type="text" class="registration-input" name="cognome" placeholder="Cognome" required>
                <input type="email" class="registration-input" name="email" placeholder="Email" required>
                <input type="password" class="registration-input" name="password" placeholder="Password" required>
                <input type="date" class="registration-input" name="data_di_nascita" placeholder="Data di Nascita" required><br>
                <?php
                    //Ritorno da pagina registrautente.php e stampo email già esistente nel caso l'email fosse già registrata
                    session_start();
                    if (isset($_SESSION["resultRegistrazione"]) && $_SESSION["resultRegistrazione"] == "false") {
                        echo '<p style="color: red;">Esiste già un account associato a questa email</p>';
                }
                ?>
                <button type="submit" class="registration-button">Registrati</button>
            </form>
    </div>
</body>
</html>
