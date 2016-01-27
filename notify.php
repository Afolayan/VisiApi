<?php
/**
 * Created by PhpStorm.
 * User: Adedeji
 * Date: 27/1/2016
 * Time: 2:32 PM
 */
 
/*
TAKE NOTE:
-support multiple number of birthdays
-save the data where the dob == today into an array
-if array size is greater than 1, get the names of each, and send

*/
    header('Content-Type: application/json');
    include_once './functions.php';
    include_once './config.php';

    $func = new functions();
    $con = new config();

    $mysqli = $con->getDBConnection();

	 if ($mysqli->connect_errno) {
         printf("Connect failed: %s\n", $mysqli->connect_error);
         exit();
     }
	 $result = $mysqli->query("SELECT * FROM naas");

    $names = array();
    $phone_number = array();

	 if( $result->num_rows > 0){
         $index = 0;

         while( $row = $result->fetch_array() ){

             $tmp["date"]  = $row["dobNumber"];
             $tmp["name"] = $row["name"];
             $tmp["phone"] = $row["phone_number"];

             $today = date('Y-m-d');
             $date4 = $tmp["date"];

            /* if (date('m-d', strtotime($today)) > date('m-d', strtotime($date4))){
                 echo $today." is after $date4 <br/>";
             }
             else */
                 if (date('m-d', strtotime($today)) === date('m-d', strtotime($date4))) {
                     //echo $today ." is the same as $date4 <br/>";
                     $name = $tmp["name"] ."";
                     $phone = $tmp["phone"];

                     $message = "Today is ".$name ."'s birthday";

                     $notif = $func->notify( $message, $phone );

                     echo $notif;


                }
                /*else {
                 echo $today ." is the before $date4 <br/>";
             }*/
         }
     }

