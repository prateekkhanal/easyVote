<?php
/* echo 'hellow'; */
$host="localhost";
$user="admin";
$password="admin";
$db="easyvote";

$conn = mysqli_connect($host,$user,$password,$db);

if(!$conn){
    echo "Database connection failed!";
} 
