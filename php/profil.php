<?php
session_start();
$szul_datum="";
$tel="";
$nev="";
$info="";
$email="";
$kep="";
if (!isset($_SESSION["active_user"])){
    header("Location: regisztralj.php");
}

$people_json = file_get_contents('felhasznalok.txt');
$felhasznalok = json_decode($people_json, true);
$felhasznalok = array_values($felhasznalok);

foreach ($felhasznalok as $key) {
    if(strcmp($key["email"], $_SESSION["active_user"]) === 0){
        $szul_datum=$key["szuletesidatum"];
        $tel=$key["telefon"];
        $nev=$key["nev"];
        $info=$key["bemutatkozas"];
        $email=$key["email"];
        $kep=$key["kep_id"];
    }
}


?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profil.css">
    <title>Profil</title>
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
                <li><a href="profil.php"><img src="../images/user.png" width="25" style="border-radius:10px; padding: 5px; background-color: white";><u></u></a></li>
            </ul>
        </nav>
    </div>
    <table>
        <tr>
            <td rowspan="4"><?php echo '<img src="'.$kep.'" width="150px">';?></td>
            <td colspan="2">Információ</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>Telefon</td>
        </tr>
        <tr>
            <td><?php echo $email; ?></td>
            <td><?php echo $tel; ?></td>
        </tr>
        <tr>
            <td colspan="2">Bemutatkozás</td>
        </tr>
        <tr>
            <td><?php echo $nev; ?></td>
            <td colspan="2" rowspan="3"><?php echo $info; ?></td>
        </tr>
        <tr>
            <td><?php echo $szul_datum; ?></td>
        </tr>
        <tr>
            <td class="opciok"><a href="regisztraltfelh.php"><img src="../images/users.svg" alt="Felhasználók" width="31"></a>
            <a href="messenger.php"><img width="25" src="../images/email.svg" alt="email" title="levelezés"></a>
            <a href="edit.php"><img width="25" src="../images/edit.svg" alt="modosit" title="adatok módosítása"></a>
            <a href="logout.php"><img width="25" src="../images/logout.svg" alt="kijelentkezés" title="kijelentkezés"></a>
            <a href="torles.php" onclick="return confirm('Biztosan törölni szeretné a profilját?');"><img width="22" src="../images/delete.svg" alt="törlés" title="profil törlése"></a></td>
        </tr>
    </table>
    

</body>
</html>