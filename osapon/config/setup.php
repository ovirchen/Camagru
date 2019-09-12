<?php
    exec("/Users/ovirchen/MAMP/mysql/bin/mysql -uroot -pqwerty < database.sql  2>&- ");
    echo "Camagru database was created.\n";
?>