<?php

/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 2:40 PM
 */
class config{

    /**
     * @var string Google API (server) key
     */
    var $GOOGLE_API_KEY = "AIzaSyDzHveYbmrrMkLd9-TK-K4rWLWtqtsSnFQ";

    /**
     *
     */
    function __construct() {

    }

    /**
     *
     */
    function __destruct() {
    }


    /**
     * @return mysqli  (combines mysql database
     * connection stuff
     */
    public function getDBConnection(){
        $DB_HOST =  "localhost";
        $DB_USER = "root";
        $DB_PASSWORD = "";
        $DB_DATABASE = "jcedarco_works";

        // connecting to mysql
        $con = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
        // selecting database
        mysqli_select_db($con, $DB_DATABASE);

        // return database handler
        return $con;
    }

    /**
     * @param $con (mysql connection)
     */
    public function close($con) {
        mysqli_close($con);
    }

    /**
     * @param $string
     * @return mixed (pure string)
     */
    public function real_escape_string($string) {
        return $this->con->real_escape_string($string);
    }

    /*
     * add.php == returns 101
     * update.php == returns 201
     *
     */
}