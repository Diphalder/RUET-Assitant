<?php

session_start();
$id =    $_SESSION['id'];
$email=$_SESSION['email'];
$pass=$_SESSION['pass'];
$type=$_SESSION['type'];
$name=$_SESSION['name'];
$dept=$_SESSION['dept'];
$phone=$_SESSION['phone'];

echo $id."<br>";
echo $email."<br>";
echo $pass."<br>";
echo $type."<br>";
echo $name."<br>";
echo $dept."<br>";
echo $phone."<br>";


?>