<?php
session_start();

$people_json = file_get_contents('felhasznalok.txt');
$felhasznalok = json_decode($people_json, true);
$felhasznalok = array_values($felhasznalok);

    $tmp = array();

        foreach ($felhasznalok as $key) {
            if(strcmp($key["email"], $_SESSION["active_user"]) !== 0){
                $tmp[]=$key;
            }
        }
    
    $json = json_encode($tmp);
    file_put_contents("felhasznalok.txt", $json);
    session_destroy();
    header("Location: signup.php");
   

?>