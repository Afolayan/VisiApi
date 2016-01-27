<?php
/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 2:32 PM
 */

    header('Content-Type: application/json');
    include_once './functions.php';

    $db = new functions();
    if (isset($_GET["chapter"])){
        $chapter = $_GET["chapter"];
        $json = array();
        $func = new functions();

        $json = $func->returnUserChapter( $chapter );

        echo json_encode($json);
        }


