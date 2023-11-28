<?php
$serverNAME='localhost'; 
$dbUserName='root' ; 
$dbPassword='';
$dbName='database';
$conn=mysqli_connect($serverNAME,$dbUserName,$dbPassword,$dbName); 
  if(!$conn){     die("connection failed: ".mysqli_connect_error()); }