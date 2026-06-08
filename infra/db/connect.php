<?php

    $host = "localhost";
    $user = "root";
    $pass = "root";
    $db = "sistema_simples_m1";

    $conn = new mysqli($host,$user,$pass,$db);

    if($conn->connect_error){
        die("Erro na conexão!");
    }else{
        echo "<script>console.log('Banco conectado com sucesso!')</script>";
    };

?>