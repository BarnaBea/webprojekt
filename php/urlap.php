<?php
session_start();
if (!isset($_SESSION["active_user"])) {
	header("Location: regisztralj.php");
}
?>


<!DOCTYPE html>
<html lang="hu">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/urlap.css">
	<link rel="icon" href="images/pagelines-brands.svg">
	<title>Javaslatok, észrevételek, értékelések</title>
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
				<li><a href="urlap.php"><u>Kapcsolat</u></a></li>
				<li><a href="profil.php"><img src="../images/user.png" alt="felhasználó" width="23" style="border-radius:12px;background-color:white;"></a></li>
			</ul>
		</nav>
	</div>
	<div class="tartalom">
		<form action="" method="post">
			<fieldset>
				<legend>Személyes adatok</legend>
				<label for="username">Név:</label><br><input id="username" type="text" name="username" maxlength="60"><br>
				<label for="email">E-mail cím:</label><br><input id="email" type="email" name="email" maxlength="60"><br>
			</fieldset>
			<fieldset>
				<legend>Melyik oldalunk tetszett a legjobban?</legend><br>
				<select>
					<option>---Válassz!--- </option>
					<option>Esőerdők</option>
					<option>Tengerek</option>
					<option>Sarkvidékek</option>
					<option>Sivatag</option>
				</select>
				<h3>Oldalak értékelése összességében:</h3><br>

				<input class="ertekeles" type="radio" name="education" value="elementary" checked><img src="../images/face-laugh-solid.svg" alt="">
				<input class="ertekeles" type="radio" name="education" value="elementary2"><img src="../images/face-smile-solid.svg" alt="">
				<input class="ertekeles" type="radio" name="education" value="secondary"><img src="../images/face-meh-solid.svg" alt="">
				<input class="ertekeles" type="radio" name="education" value="higher"><img src="../images/face-frown-solid.svg" alt="">

			</fieldset>
			<fieldset>
				<legend>Melyik élőhelyről olvasnál még szívesen?</legend><br>
				<input type="checkbox" name="hely" value="hegyvidek">hegyvidék<br>
				<input type="checkbox" name="hely" value="mersekelt">mérsékelt öv<br>
			</fieldset>
			<fieldset>
				<legend>Javaslatok</legend>
				<textarea name="velemeny" rows="6" cols="70" placeholder="Írd le ide a javaslatodat, hogy még érdekesebbé tehessük az oldalt!"></textarea><br>
			</fieldset>
			<p id="visszajelzes">Köszönjük a visszajelzéseidet!</p><br>
			<div class="clearfix">
				<input type="reset" value="Alaphelyzetbe állít">
				<input type="submit" value="Űrlap küldése">
			</div>
		</form>
	</div>
</body>

</html>