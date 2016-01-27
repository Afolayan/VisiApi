<?php
/**
 * Created by PhpStorm.
 * User: Afolayan
 * Date: 27/1/2016
 * Time: 2:30 PM
 */
    header('Content-Type: application/json');
    include_once './functions.php';
    $func = new functions();

    $response = $func->returnAll();

    echo json_encode($response);
