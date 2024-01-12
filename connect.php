<?php

$servername = "localhost";
$username = "root";
$password = "";
$db="project";

$connection = mysqli_connect($servername, $username, $password,$db);

if($connection){

}
else {
    header("Location:index.php?error=1");
}


?>