<?php
/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 11:52 PM
 */

include_once './functions.php';

$json = array();
$func = new functions();

//to update existing db entries
if ( isset($_GET['id']) && isset($_GET['name']) && isset($_GET['gender']) && isset($_GET['school']) && isset($_GET['course']) &&
    isset($_GET['email']) && isset($_GET['phone_number']) && isset($_GET['dobNumber']) && isset($_GET['userId'])
    && isset($_GET['isAlumni']) ) {

    $id = $_GET['id'];
    $userId = $_GET['userId'];
    $name = $_GET['name'];
    $email = $_GET['email'];
    $gender = $_GET['gender'];
    $school = $_GET['school'];
    $course = $_GET['course'];
    $phone_number = $_GET['phone_number'];
    $dobNumber = $_GET['dobNumber'];
    $isAlumni = $_GET['isAlumni']; //should be either of 0 or 1;

    $time = date('Y-m-d H:i:s');

    $json["status"] = $func->updateStudent(  $id, $userId, $name, $gender,
        $school, $course, $email, $phone_number, $dobNumber, $isAlumni);

    if ( $json["status"] === "Success") {
        $message = $name . "'s info  from " . $school . " has been updated";
        $func->notifyForUpdate($message);
        $json["code"] = "201"; //update
    }

    $json["id"] = $id;

    echo json_encode( $json );

}