<?php
/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 11:50 PM
 */

include_once './functions.php';


$json = array();
$func = new functions();


// to add new name
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

     if ( $json["status"] === "success" ) {
         $message = "A new user, " . $name . " from " . $school . " has been added";
         $func->notifyForUpdate($message);
         $json["code"] = "101"; //add
     }
     echo json_encode( $json );

 }