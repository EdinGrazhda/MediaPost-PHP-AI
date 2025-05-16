<?php


$user="root";
$pass="";
$server="localhost";
$dbname="mediasociale";

try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Kjo është vetëm për testim
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


 ?>