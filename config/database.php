<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "password";
$dbName = "test";
$conn = mysqli_connect($hostName,$dbUser ,$dbPassword,$dbName);
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}
// else{
//     echo "success";
// }
?>