<?php
require_once "config.php";
require_once "Database.php";

exec("/Users/ovirchen/MAMP/mysql/bin/mysql --host=". HOST ." -u". USER ." -p". PASSWORD ." < ./". DATAFILE ." 2>&- ");

Database::getInstance();
//$db->insertUser("ovirchen", "Olga", "Virchenko", "kozeroggka@gmail.com", "qwerty");
//$db->insertUser("ovirchen2", "Olga", "Virchenko", "virchenkoolg@gmail.com", "qwerty");

ini_set('display_errors', 1);
require_once 'application/bootstrap.php';



