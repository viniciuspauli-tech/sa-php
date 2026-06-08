<?php

session_start();
if(!isset($_SESSION["usuario"])){
    header("Location: ../index.php");
    exit();
}

include("../infra/db/connect.php");

$id = $_GET["id"];

$sql = " DELETE FROM usuarios WHERE id = $id ";

if($conn->query($sql) === TRUE){
    header("Location: home.php");
    exit();
}

?>