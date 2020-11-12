<?php


$host = "localhost";
$user = "root";
$password = "";
$base = "prax3";

$db = new mysqli($host, $user, $password, $base);

if ($db->connect_errno) {
    #printf("connection failed: %s\n", $db->connect_error());
    echo "Connection Failed";
    exit();
}

$query = 'SELECT id, name, email, description FROM users LIMIT 10';

$res = $db->query($query);
$rows = $res->fetch_all();

$res->close();

debug($rows);

function debug($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

$db->close();