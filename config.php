<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "storecsv";

    $con = mysqli_connect($host, $user, $password, $dbname);
    $sql_start = ' INSERT INTO `csvdata` VALUES';

    set_time_limit(36000);

    if(!$con){
        die('Connection failed :' .mysqli_connect_error());
    }
?>