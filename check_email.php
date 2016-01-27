<?php

        include_once './functions.php';
        $db = new functions();

    header('Content-Type: application/json');
    if ( isset($_GET["email"]) ){
        $email = $_GET["email"];
        $json = array();

        if($email == ""){
            $json["status"] = "101";
        }else {
            $json = $db->validateUserEmail($email);
        }

    } else {
        $json["status"] = "101";
    }
echo json_encode($json);