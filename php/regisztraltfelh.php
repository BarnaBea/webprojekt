<?php
require_once 'fuggvenyek.php';
session_start();
if (!isset($_SESSION["active_user"])) {
    header("Location: regisztralj.php");
}
$people_json = file_get_contents('felhasznalok.txt');
$felhasznalok = json_decode($people_json, true);
$felhasznalok = array_values($felhasznalok);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profil.css">
    <title>Document</title>
</head>

<body>
    <div class="center">
        <nav>
            <ul>
                <li><a href="../index.html">Főoldal</a></li>
                <li><a href="../esoerdo.html">Esőerdő</a></li>
                <li><a href="../sarkvidek.html">Sarkvidékek</a></li>
                <li><a href="../tengerek.html">Tengerek</a></li>
                <li><a href="../sivatag.html">Sivatag</a></li>
                <li><a href="urlap.php">Kapcsolat</a></li>
                <li><a href="profil.php"><img src="../images/user.png" width="25" style="border-radius:10px; padding: 5px; background-color: white" ;><u></u></a></li>
            </ul>
        </nav>
    </div>
    <div class="clearfix">
        <h2>Regisztrált felhasználóink</h2>
        <?php

        foreach ($felhasznalok as $key) {
            if (strcmp($key["nev_lathatosag"], "igen") === 0) {
                echo '<div class="card">
                            <img src="' . $key["kep_id"] . '" alt="Avatar" style="width:100%">
                            <div class="container">
                                <h4><b>' . $key["nev"] . '</b></h4> 
                                <p>' . $key["email"] . '</p> <a href="messenger.php?email=' . $key["email"] . '"><div class="kuldes-gomb"><img  src="../images/email.svg" alt="email" title="levelezés">Üzenet</a></div>
                            </div>
                    </div>';
            } else {
                echo '<div class="card">
                            <img src="' . $key["kep_id"] . '" alt="Avatar" style="width:100%">
                            <div class="container">
                                <h4><b>Nem publikus adat</b></h4> 
                                <p>' . $key["email"] . '</p> <a href="messenger.php?email=' . $key["email"] . '"><div class="kuldes-gomb"><img  src="../images/email.svg" alt="email" title="levelezés">Üzenet</a></div>
                            </div>
                    </div>';
            }
        }







        ?>
    </div>
</body>

</html>