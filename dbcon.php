<?php


$con = mysqli_connect("localhost","root","","inventorydb");

if(!$con){
    die('Connection Failed' . mysqli_connect_error());
}
 
?>