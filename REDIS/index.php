<?php 
echo phpinfo();
$hostname = "myhost";
    $port = 10060;
    $dbname = "tempdb";
        $username = "dbuser";
        $pw = "password";
            $dbh = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$pw");
?>
