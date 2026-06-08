<?php
    session_start();

    include("infra/db/connect.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0){
            $_SESSION["usuario"] = $usuario;
            header("Location: public/home.php");
            exit();
        }else{
            $erro = "Usuário ou senha inválidos!";
        }
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Sitema de Login Simples</h1>

    <form method="POST">
        <label>Usuário:</label>
        <input type="text" name="usuario">
        <br>
        <label>Senha:</label>
        <input type="password" name="senha">
        <br>
        <?php
        
            if(isset($erro)){
                echo $erro;
            };

            // esse erro serve ara alguma coisa
        
        ?>
        <br>
        <button type="submit">Entrar</button>
    </form>

</body>
</html>