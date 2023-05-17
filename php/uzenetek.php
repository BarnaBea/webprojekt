<?php
class Uzenetek
{
    private $from = "";
    private $to = "";
    private $msg = "";
    private $uzenet;


    public function __construct($ki, $kinek)
    {
        $this->from = $ki;
        if ($kinek == "minden") {
            $this->to = "minden";
        } else {
            $this->to = $kinek;
        }
    }
    public function newMsg($ki, $kinek, $mit)
    {
        $this->from = $ki;
        $this->to = $kinek;
        $this->msg = $mit;
        $this->saveMsg();
    }
    public function uzenetekBeolvas()
    {
        $people_json = file_get_contents('uzenetek.txt');
        $felhasznalok = json_decode($people_json, true);
        if (!is_null($felhasznalok)) {
            $this->uzenet = array_values($felhasznalok);
        }
    }
    public function getAllMsg($felado)
    {
        $this->uzenetekBeolvas();

        if (!empty($this->uzenet)) {
            foreach ($this->uzenet as $key) {
                if ((strcmp($key["from"], $this->from) === 0) || (strcmp($key["to"], $this->from) === 0)) {
                    $tmp[] = $key;
                }
            }
        }
        unset($this->uzenet);
        if (!empty($tmp)) {
            return $tmp;
        } else {
            return 0;
        }
    }
    public function getMsg()
    {

        $this->uzenetekBeolvas();

        if (!empty($this->uzenet)) {
            foreach ($this->uzenet as $key) {
                if (((strcmp($key["from"], $this->from) === 0) && (strcmp($key["to"], $this->to) === 0)) || ((strcmp($key["from"], $this->to) === 0) && (strcmp($key["to"], $this->from) === 0))) {
                    $tmp[] = $key;
                }
            }
        }
        unset($this->uzenet);
        if (!empty($tmp)) {
            return $tmp;
        } else {
            return 0;
        }
    }

    public function saveMsg()
    {
        $people_json = file_get_contents('uzenetek.txt');
        $uzenetek = json_decode($people_json, true);
        if (!empty($uzenetek)) {
            $uzenet = array_values($uzenetek);
        } else {
            $uzenet = array();
        }


        if (is_null($uzenet)) {
            $msg_count = 0;
        } else {
            $msg_count = count($uzenet);
        }

        $uzenet[$msg_count + 1] =
            [
                "from" => $this->from,
                "to" => $this->to,
                "msg" => $this->msg,
                "date" => date("YmdHm")
            ];
        $json = json_encode($uzenet);
        file_put_contents("uzenetek.txt", $json);
        
    }
}
