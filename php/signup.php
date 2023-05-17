<?php
require_once 'fuggvenyek.php';
$errorMessage = null;
$email = "";
$pwd = "";
$pwd2 = "";
$lathatosag = "";

if (isset($_POST['register'])) {

  $email = $_POST['email'];
  $pwd = $_POST['pwd'];
  $pwd2 = $_POST['pwd-repeat'];
  if (isset($_POST["email_lathatosag"]) && $_POST["email_lathatosag"] == "igen") {
    $lathatosag = $_POST['email_lathatosag'];
  } else {
    $lathatosag = "nem";
  }

  if ((strlen($pwd) == 0) && (strlen($pwd2) == 0)) {
    $errorMessage = $errorMessage . "Nem írtál be jelszót! ";
  }
  if (strlen($pwd) < 8) {
    $errorMessage = $errorMessage . "Nem elég hosszú a jelszó! ";
  }
  if (strcmp($pwd, $pwd2) !== 0) {
    $errorMessage = $errorMessage . "A két jelszó nem egyezik! ";
  }

  if (empty($email)) {
    $errorMessage = $errorMessage . "Email cím megadása kötelező! ";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errorMessage = $errorMessage . "Helytelen email cím! ";
    }
  }

  if (file_exists("felhasznalok.txt")) {
    $people_json = file_get_contents('felhasznalok.txt');
    $felhasznalok = json_decode($people_json, true);
    if (!is_null($felhasznalok)) {
      $felhasznalok = array_values($felhasznalok);
      foreach ($felhasznalok as $key) {
        if (strcmp($key["email"], $email) === 0) {
          $errorMessage = $errorMessage . "Ezzel az email címmel már regisztráltak! ";
        }
      }
    }
  } else {
    echo "nincs meg a file.";
  }

  if (!$errorMessage) {
    $user_count = count($felhasznalok);
    $felhasznalok[$user_count + 1] =
      [
        "email" => $email,
        "email_lathatosag" => $lathatosag,
        "pwd" => password_hash($pwd, PASSWORD_DEFAULT),
        "szuletesidatum" => "Nincs megadva",
        "szuletesidatum_lathatosag" => "nem",
        "telefon" => "Nincs megadva",
        "telefon_lathatosag" => "nem",
        "bemutatkozas" => "Nincs megadva",
        "bemutatkozas_lathatosag" => "nem",
        "nev" => "Nincs megadva",
        "nev_lathatosag" => "nem",
        "kep_id" => $email . "/user.png"
      ];
    $json = json_encode($felhasznalok);
    file_put_contents("felhasznalok.txt", $json);


    if (!file_exists($email)) {
      mkdir($email, 0777, true);
      copy("../userphotos/user.png", $email . "/user.png");
    }
    header("Location: sikeresreg.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/signup.css">
  <title>Kezdo oldal</title>
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
        <li><a href="profil.php"><img src="../images/user.png" width="23" style="border-radius:12px;background-color:white" ;></a></li>
      </ul>
    </nav>
  </div>
  <form action="" method="post">
    <div class="container">
      <h1>Regisztráció</h1>
      <p>Új fiók regisztrálásához, kérem töltse ki az alábbi űrlapot.</p>
      <hr>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="valami@valami.com" name="email" id="email" required>

      <input type="checkbox" name="email_lathatosag" id="" value="igen"><label for="email_lathatosag"><b>Publikus</b></label>
      <br><br><br>
      <label for="psw"><b>Jelszó</b></label>
      <input type="password" placeholder="minimum 8 karakter" name="pwd" id="pwd" required>

      <label for="psw-repeat"><b>Jelszó ismét</b></label>
      <input type="password" placeholder="" name="pwd-repeat" id="pwd-repeat" required>
      <hr>

      <?php if ($errorMessage) { ?>
        <div class="error-message">
          <?php
          echo $errorMessage;
          ?>
        </div>
      <?php }
      ?>
      <button type="submit" name="register" class="registerbtn">Regisztálás</button>
    </div>

    <div class="container signin">
      <p>Van már fiókja? <a href="login.php">Bejelentkezés</a>.</p>
    </div>
  </form>
</body>

</html>