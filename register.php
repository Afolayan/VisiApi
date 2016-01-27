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

    if ( isset($_GET['name']) && isset($_GET['gender']) && isset($_GET['school']) && isset($_GET['course']) &&
        isset($_GET['email']) && isset($_GET['phone_number']) && isset($_GET['dobNumber']) && isset($_GET['userId'])
        && isset($_GET['isAlumni']) ) {

        $userId = $_GET['userId'];
        $name = $_GET['name'];
        $email = $_GET['email'];
        $gender = $_GET['gender'];
        $school = $_GET['school'];
        $course = $_GET['course'];
        $phone_number = $_GET['phone_number'];
        $dobNumber = $_GET['dobNumber'];
        $isAlumni = $_GET['isAlumni'];

        $time = date('Y-m-d H:i:s');

        $json = $func->addNewStudent( $userId, $name, $gender,
            $school, $course, $email, $phone_number, $dobNumber, $isAlumni);


        echo json_encode( $json );

    }


if ( isset($_GET['userId']) && isset($_GET['regId']) && isset($_GET['email']) ) {
        $regId = $_GET['regId'];
        $email = $_GET['email'];
        $userId = $_GET['userId'];

    $time = date('Y-m-d H:i:s');

        $f = $func->registerUser( $userId, $email, $regId );

        $json["id"] = $f;

        echo json_encode( $json );

    }


