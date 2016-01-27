<?php
/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 2:33 PM
 */
    include_once './functions.php';


    $json = array();
    $func = new functions();


// to register new device/user
if ( isset($_GET['userId']) && isset($_GET['regId']) && isset($_GET['email']) ) {
        $regId = $_GET['regId'];
        $email = $_GET['email'];
        $userId = $_GET['userId'];

    $time = date('Y-m-d H:i:s');

        $f = $func->registerUser( $userId, $email, $regId );

        $json["id"] = $f;

        echo json_encode( $json );

    }



