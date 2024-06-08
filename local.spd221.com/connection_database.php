<?php
include $_SERVER["DOCUMENT_ROOT"]."/options.php";
try {
    $dbh = new PDO( DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
//    echo"Connection is good";
} catch (PDOException $e) {
    echo"Connection is BAD";
    exit();
    // attempt to retry the connection after some timeout for example
}