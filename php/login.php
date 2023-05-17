<?php
session_start();
$errorMessage = null;
$email = "";
$pwd = "";

if (isset($_POST['login'])) {

  $email = $_POST['email'];
  $pwd = $_POST['pwd'];

  if (strlen($pwd) == 0) {
    $errorMessage = $errorMessage . "Kérjük adja meg jelszavát! ";
  }

  if (empty($email)) {
    $errorMessage = $errorMessage . "Kérjük adja meg az email címét! ";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errorMessage = $errorMessage . "Helytelen email cím! ";
    }
  }

  if (!$errorMessage) {

    $people_json = file_get_contents('felhasznalok.txt');
    $felhasznalok = json_decode($people_json, true);
    if (!empty($felhasznalok)) {
      $felhasznalok = array_values($felhasznalok);
      foreach ($felhasznalok as $key) {
        if (strcmp($key["email"], $email) === 0) {
          if (password_verify($pwd, $key["pwd"])) {
            $_SESSION["active_user"] = $key["email"];
            header("Location: ../index.html");
            exit();
          } else {
            $errorMessage = $errorMessage . "Helytelen jelszó! ";
          }
        } else {
          $errorMessage = "Helytelen email cím! ";
        }
      }
    }
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
  <title>Bejelentkezés</title>
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
      <h1>Bejelentkezés</h1>
      <p>Bejelentkezéshez kérem adja meg a szükséges adatokat!</p>
      <hr>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="valami@valami.com" name="email" id="email" required>

      <label for="psw"><b>Jelszó</b></label>
      <input type="password" placeholder="minimum 8 karakter" name="pwd" id="pwd" required>
      <hr>

      <?php if ($errorMessage) { ?>
        <div class="error-message">
          <?php
          echo $errorMessage;
          ?>
        </div>
      <?php }
      ?>
      <button type="submit" name="login" class="registerbtn">Bejelentkezés</button>
    </div>

    <div class="container signin">
      <p><a href="signup.php">Regisztáció</a></p>
    </div>
  </form>
</body>

</html>