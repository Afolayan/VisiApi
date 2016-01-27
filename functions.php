<?php

/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 2:42 PM
 */
class functions{
    var $config;
    var $mysql;

    function __construct() {
        include_once './config.php';
        $this->config = new config();
        $this->mysql = $this->config->getDBConnection();

    }

    function __destruct() {

    }

    /**
     * @param $userId
     * @param $email
     * @param $regId
     * @return mixed
     */
    public function registerUser($userId, $email, $regId){
        $json = array();

        $time = date('Y-m-d H:i:s');
        $mysql = $this->config->getDBConnection();

        if(!$mysql){
            die('MySQL connection failed'.$mysql->error);
        }
        $email = $mysql->real_escape_string( $email );
        $userName = $this->getUserFromId( $userId );

        $sql = "INSERT INTO appRegistration (userName, registration_id, email, time) VALUES ('$userName','$regId', '$email', '$time')";

        $result = $mysql->query($sql, MYSQLI_ASSOC);
        if(! $result ){
            die('MySQL query failed'.$mysql->error);
        }

        $last_id = $mysql->insert_id;

        $json["status"] = "success";

        $json["id"] = $last_id;

        $mysql->close();

        return $last_id;
    }


    /**
     * @param $email
     * @return array
     */
    public function validateUserEmail($email){
        $mysqli = $this->config->getDBConnection();
        $response = array();

        if( !$mysqli)echo "Cannot established connection"."<br/>";

        $email = $mysqli->real_escape_string($email);

        $query = sprintf("SELECT * FROM naas WHERE email='%s'", $email);

        $result = $mysqli->query( $query );

        if (! $result ) die ( "Invalid query ".$result->error);

        if ( $result->num_rows > 0 ){
            while($row = $result->fetch_array()){

                $tmp["id"] = $mysqli->real_escape_string($row["id"]);
                $tmp["name"] = $mysqli->real_escape_string($row["name"]);
                $tmp["gender"] = $mysqli->real_escape_string($row["gender"]);
                $tmp["school"] = $mysqli->real_escape_string($row["school"]);
                $tmp["course"] = $mysqli->real_escape_string($row["course"]);
                $tmp["email"] = $mysqli->real_escape_string($row["email"]);
                $tmp["phone_number"]  = $mysqli->real_escape_string($row["phone_number"]);
                $tmp["date_of_birth"]  = $mysqli->real_escape_string($row["date_of_birth"]);
                $tmp["isAlumni"]  = $mysqli->real_escape_string($row["isAlumni"]);
                $tmp["dobNumber"]  = $mysqli->real_escape_string($row["dobNumber"]);


            }
            array_push($response, $tmp);
        } else {
            $response["status"] = "404";
        }
        return $response;
    }

    /**
     * @param $chapter
     * @return array
     */
    public function returnUserChapter($chapter){
        $mysqli = $this->config->getDBConnection();
        $response = array();

        if( !$mysqli)echo "Cannot established connection"."<br/>";

        $chapter = $mysqli->real_escape_string($chapter);

        $query = sprintf("SELECT * FROM naas WHERE school='%s'", $chapter);

        $result = $mysqli->query( $query );

        if (! $result ) die ( "Invalid query ".$result->error);

        if ( $result->num_rows > 0 ){
            while($row = $result->fetch_array()){

                $tmp["id"] = $mysqli->real_escape_string($row["id"]);
                $tmp["name"] = $mysqli->real_escape_string($row["name"]);
                $tmp["gender"] = $mysqli->real_escape_string($row["gender"]);
                $tmp["school"] = $mysqli->real_escape_string($row["school"]);
                $tmp["course"] = $mysqli->real_escape_string($row["course"]);
                $tmp["email"] = $mysqli->real_escape_string($row["email"]);
                $tmp["phone_number"]  = $mysqli->real_escape_string($row["phone_number"]);
                $tmp["isAlumni"]  = $mysqli->real_escape_string($row["isAlumni"]);
                $tmp["date_of_birth"]  = $mysqli->real_escape_string($row["date_of_birth"]);
                $tmp["dobNumber"]  = $mysqli->real_escape_string($row["dobNumber"]);

                array_push($response, $tmp);
            }
        }
        return $response;
    }

    /**
     * @return array
     */
    public function returnAll(){
        $mysqli = $this->config->getDBConnection();
        $response = array();

        if( !$mysqli)echo "Cannot established connection"."<br/>";

        $query = sprintf("SELECT * FROM naas");

        $result = $mysqli->query( $query );

        if (! $result ) die ( "Invalid query ".$result->error);

        if ( $result->num_rows > 0 ){
            while($row = $result->fetch_array()){

                $tmp["id"] = $mysqli->real_escape_string($row["id"]);
                $tmp["name"] = $mysqli->real_escape_string($row["name"]);
                $tmp["gender"] = $mysqli->real_escape_string($row["gender"]);
                $tmp["school"] = $mysqli->real_escape_string($row["school"]);
                $tmp["course"] = $mysqli->real_escape_string($row["course"]);
                $tmp["email"] = $mysqli->real_escape_string($row["email"]);
                $tmp["phone_number"]  = $mysqli->real_escape_string($row["phone_number"]);
                $tmp["date_of_birth"]  = $mysqli->real_escape_string($row["date_of_birth"]);
                $tmp["dobNumber"]  = $mysqli->real_escape_string($row["dobNumber"]);
                $tmp["isAlumni"]  = $mysqli->real_escape_string($row["isAlumni"]);

                array_push($response, $tmp);
            }
        }
        return $response;
    }


    /**
     * @param $message
     * @param $phone
     * @return mixed
     */
    public function notify($message, $phone){
        $mysqli = $this->config->getDBConnection();
        $con = new config();

        $registration_ids = array();

        $sql = "SELECT * FROM appRegistration";
        $result1 = $mysqli->query($sql);


        while($row = $result1->fetch_array()){
            array_push($registration_ids, $row['registration_id']);
        }

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $message = array("Notice" => $message, 'phone' => $phone);
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,

        );

        $headers = array(
            'Authorization: key='.$con->GOOGLE_API_KEY,
            //'Authorization: key=AIzaSyDzHveYbmrrMkLd9-TK-K4rWLWtqtsSnFQ',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result;
    }

    /**
     * @param $message
     * @return mixed
     */
    public function notifyForUpdate($message){
        $mysqli = $this->config->getDBConnection();
        $con = new config();

        $registration_ids = array();

        $sql = "SELECT * FROM appRegistration";
        $result1 = $mysqli->query($sql);


        while($row = $result1->fetch_array()){
            array_push($registration_ids, $row['registration_id']);
        }

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $message = array("Notice" => $message);
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $message,

        );

        $headers = array(
            'Authorization: key='.$con->GOOGLE_API_KEY,
            //'Authorization: key=AIzaSyDzHveYbmrrMkLd9-TK-K4rWLWtqtsSnFQ',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result;
    }

    /**
     * @param $userId
     * @param $name
     * @param $gender
     * @param $school
     * @param $course
     * @param $email
     * @param $phone_number
     * @param $dobNumber
     * @param $isAlumni
     * @return array
     */
    public function addNewStudent($userId, $name, $gender, $school,
                                  $course, $email, $phone_number,
                                  $dobNumber, $isAlumni){
        $json = array();

        $time = date('Y-m-d H:i:s');
        $userName = $this->getUserFromId( $userId );

        $updater = $userName ." ".$time ;


        $mysql = $this->config->getDBConnection();

        if(!$mysql){
            die('MySQL connection failed'.$mysql->error);
        }
        $name = $mysql->real_escape_string( $name );
        $email = $mysql->real_escape_string( $email );
        $gender = $mysql->real_escape_string( $gender );
        $school = $mysql->real_escape_string( $school );
        $course = $mysql->real_escape_string( $course );
        $phone_number = $mysql->real_escape_string( $phone_number );
        $dobNumber = $mysql->real_escape_string( $dobNumber );

        $newDate = date("d-m-Y", strtotime($dobNumber));

        $sql = "INSERT INTO naas (name, gender, school, course, email, phone_number, date_of_birth, dobNumber, update_info, isAlumni)
                VALUES ('$name','$gender', '$school', '$course', '$email', '$phone_number', '$newDate', '$dobNumber', '$updater', $isAlumni)";

        $result = $mysql->query($sql, MYSQLI_ASSOC);
        if(! $result ){
            die('MySQL query failed'.$mysql->error);
        }

        $last_id = $mysql->insert_id;

        $json["status"] = "success";

        $json["id"] = $last_id;

        $mysql->close();

        return $json;
    }


    /**
     * @param $id
     * @param $userId
     * @param $name
     * @param $gender
     * @param $school
     * @param $course
     * @param $email
     * @param $phone_number
     * @param $dobNumber
     * @param $isAlumni
     * @return string
     */
    public function updateStudent( $id, $userId, $name, $gender, $school,
                                  $course, $email, $phone_number,
                                  $dobNumber, $isAlumni){

        $mysql = $this->config->getDBConnection();

        if(!$mysql){
            die('MySQL connection failed'.$mysql->error);
        }
        $newDate = date("d-m-Y", strtotime($dobNumber));
        $time = date('Y-m-d H:i:s');
        $userName = $this->getUserFromId( $userId );

        $updater = $userName ." ".$time ;

        $name = $mysql->real_escape_string( $name );
        $email = $mysql->real_escape_string( $email );
        $gender = $mysql->real_escape_string( $gender );
        $school = $mysql->real_escape_string( $school );
        $course = $mysql->real_escape_string( $course );
        $phone_number = $mysql->real_escape_string( $phone_number );
        $dobNumber = $mysql->real_escape_string( $dobNumber );
        $isAlumni = $mysql->real_escape_string( $isAlumni );

        $sql = "UPDATE naas
                SET name = '$name', gender = '$gender', school = '$school',
                course = '$course', email = '$email', phone_number = '$phone_number',
                dobNumber = '$dobNumber', date_of_birth = '$newDate', update_info = '$updater',
                isAlumni = '$isAlumni'
                WHERE id = '$id'
                ";

        $result = $mysql->query($sql, MYSQLI_ASSOC);
        if(! $result ){
            return "Failure";
            //die('MySQL query failed'.$mysql->error);
        } else {
            return "Success";
        }
    }

    /**
     * @param $userId
     * @return string
     */
    public function getUserFromId($userId){
        $mysql = $this->config->getDBConnection();
        if(!$mysql){
            die('MySQL connection failed'.$mysql->error);
        }
        $query = "SELECT name FROM naas WHERE id='$userId'";
        $result = $mysql->query($query);

        if(!$result){
            die('MySQL query failed when getting questions for subject '.$mysql->error);
        }
        $subject = $result->fetch_row();

        return $mysql->real_escape_string($subject[0]);
    }
}