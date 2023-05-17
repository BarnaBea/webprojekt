<?php
function felhasznalokBeolvas(){
    $file = fopen("felhasznalok.txt", "r");
    $felhasznalok = [];
    while (($line = fgets($file)) !== false) {
        $felhasznalok[] = unserialize($line);
    }
    fclose($file);
    return $felhasznalok;
}

function felhasznalokKiir($tomb){
    $filename = "felhasznalok.txt";
    $file = fopen($filename, "w");
    foreach ($tomb as $felhasznalo) {
      fwrite($file, serialize($felhasznalo."\n"));
    }
    fclose($file);
}
