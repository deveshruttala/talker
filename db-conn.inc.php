<?php

require 'db-pswd.inc.php';

try {
     
    //DOCKER
    //$connection = new PDO('mysql:host=mysql;dbname=talker_db', DOCKER[0], DOCKER[1]);
    
    //VAGRANT
    //$connection = new PDO('mysql:host=localhost;dbname=talker_db', VAGRANT[0], VAGRANT[1]);

    //XAMPP
    $connection = new PDO('mysql:host=localhost;dbname=talker_db', XAMPP[0], XAMPP[1]);

    //000WEBHOST
    //$connection = new PDO('mysql:host=localhost;dbname=id8122230_talker_db', WEBHOST[0], WEBHOST[1]);

    //print "Success! Connected to the database!";

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>