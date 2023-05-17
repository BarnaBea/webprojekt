<?php
session_start();
unset($_SESSION["active_user"]);
header("Location:login.php");
