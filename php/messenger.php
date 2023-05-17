<?php
session_start();
require_once 'uzenetek.php';
$cimzett = "";
if (!isset($_SESSION["active_user"])) {
    header("Location: regisztralj.php");
}
if (isset($_GET["email"])) {
    $t = new Uzenetek($_SESSION["active_user"], $_GET["email"]);
    $uzenetlista = $t->getMsg();
    if (isset($_POST["send"])) {
        $t->newMsg($_SESSION["active_user"], $_POST["to"], $_POST["msg"]);
        $uzenetlista = $t->getMsg($_SESSION["active_user"], $_POST["to"]);
    }
} else {
    $cimzett = "minden";
    $t = new Uzenetek($_SESSION["active_user"], $cimzett);
    $uzenetlista = $t->getAllMsg($_SESSION["active_user"]);
    if (isset($_POST["send"])) {
        $t->newMsg($_SESSION["active_user"], $_POST["to"], $_POST["msg"]);
        $uzenetlista = $t->getMsg($_SESSION["active_user"], $_POST["to"]);
    }
}

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
    <form action="" method="post">
        <table style="width:50%;">
            <tr>
                <td colspan="2">Új üzenet írása</td>
            </tr>
            <tr>
                <td>Címzett</td>
                <td><input type="text" name="to" id="" value="<?php
                                                                if (isset($_GET["email"])) {
                                                                    echo $_GET["email"];
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>"></td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="msg" id="" cols="75" rows="10"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit" name="send">Küldés</button></td>
            </tr>
        </table>
    </form>
    <table style="width:50%;margin-top:10px;" cellspace="0">
        <tr>
            <td colspan="2">
                <h2>Üzenetek</h2>
            </td>
        </tr>
        <?php
        if (!empty($uzenetlista)) {

            foreach ($uzenetlista as $key) {
                if ((strcmp($key["from"], $_SESSION["active_user"]) === 0) || (strcmp($key["to"], $_SESSION["active_user"]) === 0)) {
                    echo '<tr><td colspan="2" style="text-align:left;background-color:#5eb8b8e0;">Feladó: ' . $key["from"] . ' Címzett: ' . $key["to"] . '</td></tr>';
                    echo '<tr><td colspan="2" style="text-align:left;color:white;">' . $key["msg"] . '</td></tr>';
                } else {
                    echo '<tr><td colspan="2" style="text-align:right;background-color:#5eb8b8e0;">' . $key["from"] . '</td></tr>';
                    echo '<tr><td colspan="2" style="text-align:right;color:white;">' . $key["msg"] . '</td></tr>';
                }
            }
        }
        ?>
    </table>
</body>

</html>