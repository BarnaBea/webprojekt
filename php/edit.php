<?php
session_start();
$email = $_SESSION["active_user"];
$errorMSG = "";
$nev = "";
$telefon = "";
$info = "";
$szuldatum = "";

if (isset($_POST["mentes"])) {
    if (isset($_POST["nev"])) {
        $nev = $_POST["nev"];
    } else {
        $nev = "";
    }
    if (isset($_POST["telefon"])) {
        $telefon = $_POST["telefon"];
    } else {
        $telefon = "";
    }
    if (isset($_POST["info"])) {
        $info = $_POST["info"];
    } else {
        $info = "";
    }
    if (isset($_POST["szul_datum"])) {
        $szuldatum = $_POST["szul_datum"];
    } else {
        $szuldatum = "";
    }

    if (isset($_FILES['kep']['name'])) {
        if ($_FILES['kep']['tmp_name'] != '') {
            if ($_FILES['kep']['type'] == 'image/jpeg') {
                $from = $_FILES['kep']['tmp_name'];
                $to = $_SESSION["active_user"] . '/' . $_FILES['kep']['name'];

                if (!move_uploaded_file($from, $to)) {
                    $error = true;
                    $errorMSG .= '<p>A file feltöltése sikertelen! (tmp->folder)</p>';
                }
            } else {
                $error = true;
                $errorMSG = '<p>A kép formátum nem jpg/jpeg!S</p>';
            }
        } else {
            $error = true;
            $errorMSG .= ' <p> Sikertelena  kép tallózása! (empty value)</p> ';
        }
    } else {
        $error = true;
        $errorMSG .= '<p>Sikertelena  kép tallózása(not isset)</p>';
    }

    $people_json = file_get_contents('felhasznalok.txt');
    $felhasznalok = json_decode($people_json, true);
    $felhasznalok = array_values($felhasznalok);

    foreach ($felhasznalok as $key => $value) {
        if (strcmp($value["email"], $_SESSION["active_user"]) === 0) {
            if ($szuldatum != "") {
                $felhasznalok[$key]["szuletesidatum"] =  $szuldatum;
            }
            if ($telefon != "") {
                $felhasznalok[$key]["telefon"] =  $telefon;
            }
            if ($nev != "") {
                $felhasznalok[$key]["nev"] =  $nev;
            }
            if ($info != "") {
                $felhasznalok[$key]["bemutatkozas"] =  $info;
            }
            if ($_FILES['kep']['tmp_name'] != '') {
                $felhasznalok[$key]["kep_id"] =  $_SESSION["active_user"] . '/' . $_FILES['kep']['name'];
            }
        }
    }

    $json = json_encode($felhasznalok);
    file_put_contents("felhasznalok.txt", $json);

    header("Location: profil.php");
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
                <li><a href="profil.php"><img src="../images/user.png" width="25" style="border-radius:10px; padding: 5px; background-color: white" ;><u></u></a></li>
            </ul>
        </nav>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td class="picture" rowspan="4"><label for="kepfeltolt"><img width="30" src="../images/upload.svg" alt="upload"></label><input type="file" name="kep" id="kepfeltolt" hidden><br>(*.jpeg)</td>
                <td colspan="2">Információ</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>Telefon</td>
            </tr>
            <tr>
                <td><?php echo $email; ?></td>
                <td><input type="tel" name="telefon" placeholder="06308880000" id=""></td>
            </tr>
            <tr>
                <td colspan="2">Bemutatkozás</td>
            </tr>
            <tr>
                <td><input type="text" name="nev" id="" placeholder="név"></td>
                <td colspan="2" rowspan="3"><textarea name="info" id="" cols="30" rows="10"></textarea></td>
            </tr>
            <tr>
                <td><input type="date" name="szul_datum" id=""></td>
            </tr>
            <tr>
                <td class="opciok"><input type="submit" name="mentes" value="Mentés"></td>
            </tr>
        </table>
    </form>
</body>

</html>