<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title>Termostato</title>
<link rel="stylesheet" href="termostato.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>
<link rel="icon" type="image/x-icon" href="logo.png">
</head>
<?php
session_start(); //Sessione per l'identificazione dell'utente registrato tramite l'email 
if (!isset($_SESSION["Utente"])){
  header("Location: ./login.php");
  $utente=$_SESSION["Utente"];
}
?>
<body>
<div class="container">
  <div class="logo">
    <img src="logo.png" alt="Logo">
  </div>
  <div class="title">
    THERMOTEST S.P.A.
  </div>
  <div class="login">
    <label for="email"><?php
    if (isset($_SESSION["Utente"])){
      echo $_SESSION["Utente"];
    }
    ?>
    </label>
    <button type="submit" id="loginBtn" onclick="window.location.href='login.php'">cambia utente</button>
  </div>
</div>
<div id="orario">
        <p class="text" id="timestamp">[TIME STAMP MISURAZIONE]</p>
    </div>
<div class="wrapper">
  <div class="card">
    <div class="circle">
      <div class="bar temperature-bar"></div>
      <div class="box"><span></span></div>
    </div>
    <div class="text">Temperatura</div>
  </div>
  <div class="card js">
    <div class="circle">
      <div class="bar humidity-bar"></div>
      <div class="box"><span></span></div>
    </div>
    <div class="text">Umidità</div>
  </div>
  <div class="card react">
    <div class="circle">
      <div class="bar smoke-bar"></div>
      <div class="box"><span></span></div>
    </div>
    <div class="text">Fumo</div>
  </div>
</div>
    <footer class="visible">
        <div id="dati-azienda">
        <h2>Thermotest S.P.A.</h1>
        <ul>
            <li>Via Nasolini 2</li>
            <li>29121 Piacenza(PC) Italy</li>
            <li>Telefono: +39 373 851 3367</li>
            <li>Fax: +39 0523 52 40 12</li>
        </ul>
        </div>
        <div>
            <a href="privacy.html" id="privacy">Privacy Policy</a>
        </div>
        <div id="other-info">
                <ul>
                    <li>Copyright © 2024</li>
                    <li>All rights reserved - Thermotest S.P.A.</li>
                </ul>
        </div>
    </footer>
    <script>

// Funzione per aggiornare i valori delle progressbar circolari di temperatura, umidità e fumo
function updateValues() {
  $.ajax({ 

    //Effettua richiesta GET a querydati.php per ottenere i dati tramite json
    url: 'querydati.php', 
    type: 'GET',
    dataType: 'json',
    success: function(data) {
       /*Se la richiesta ha successo esegue tutta la funzione che aggiorna il valore di progresso
       delle barre circolari, in base a data proveniente dal json*/

      const minTemperature = -30; //Temperatura minima 
      const maxTemperature = 70; //Temperatura massima

      // Valore di temperatura da rappresentare
      const temperaturaCelsius = data.temperatura;

      /*Il valore di progresso delle barre è compreso nell'intervallo [0, 1], quindi converto il valore di temperatura
      in nuovo valore accettabile per il progresso delle barre*/

      const normalizedTempValue = (temperaturaCelsius - minTemperature) / (maxTemperature - minTemperature);
      //Opzioni di valori e stili della progressbar temperatura
      let temperatureOptions = {
        startAngle: -1.55,
        size: 150,
        value: normalizedTempValue,
        fill: { gradient: ['#f1515e', '#1dbde6'] }
      };

      // Inizializzazione della barra di temperatura
      $(".temperature-bar").circleProgress(temperatureOptions).on('circle-animation-progress', function (event, progress, stepValue) {

        // Conversione del valore normalizzato in Celsius
        const temperatureCelsius = stepValue * (maxTemperature - minTemperature) + minTemperature;

        //  valore della temperatura con precisione di due cifre decimali
        $(this).parent().find("span").text(temperatureCelsius.toFixed(2) + "°C");
      });

      //Converto il valore di percentuale di umidita in base al range del cerchio [0,1]
      let normalizedUmiValue = data.umidita / 100;

      //Opzioni di valori e stili della progressbar umidità
      let humidityOptions = {
        startAngle: -1.55,
        size: 150,
        value: normalizedUmiValue,
        fill: {gradient: ['#2c6cbc','#71c3f7','#6CB4EE']}
      }

      // Inizializzazione della barra di umidità
      $(".humidity-bar").circleProgress(humidityOptions).on('circle-animation-progress', function(event, progress, stepValue){
        $(this).parent().find("span").text(String(stepValue.toFixed(2).substr(2)) + "%");
      });

      //Opzioni di valori e stili della progressbar umidità
  let smokeOptions = {
  startAngle: -1.55,
  size: 150,
  value: data.fumo == 1 ? 1 : 0, // Se il valore del fumo è 1, progress bar al 100%, altrimenti 0%
  fill: {gradient: data.fumo == 1 ? ['#FF0800'] : ['#00FF00']}//Se il valore del fumo è 1, colore barra rosso, altrimenti grigio
};
$(".smoke-bar").circleProgress(smokeOptions).on('circle-animation-progress', function(event, progress, stepValue){
  let smokeLabel = data.fumo == 1 ? "SI" : "NO"; // Se fumo è 1, impostiamo l'etichetta a "SI", altrimenti "NO"
  $(this).parent().find("span").text(smokeLabel);
});

      // Aggiorna il timestamp
      document.getElementById("timestamp").innerHTML = data.time_stamp;
    },
    error: function(xhr, status, error) {
      console.error('Errore durante il recupero dei dati:', error);
    }
  });
}
$(document).ready(function() {
  updateValues();
  setInterval(updateValues, 60000); // Aggiorna le barre con i loro valori ogni 6 minuti (60000 millisecondi)
});
</script>
  </body>
</html>


