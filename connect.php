<?php

$host="localhost";
$user="admin";
$password="admin";
$db="easyVote";

$conn = mysqli_connect($host,$user,$password,$db);

if(!$conn){
    echo "Database connection failed!";
} 
