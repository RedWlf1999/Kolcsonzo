<?php

 $host="localhost";
 $user="root";
 $pass="";
 $db="kolcsonzo";

 $conn=mysqli_connect($host,$user,$pass,$db);
 if(!$conn){
    echo "hiba";
}