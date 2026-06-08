<?php
    session_start();

    include("infra/db/connect.php");
     // Verifica se o formulário foi enviado via método POST

    if($_SERVER['REQUEST_METHOD'] == "POST"){
// Captura os dados enviados pelo formulário
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
 // Executa a query no banco de dados
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0){
             // Armazena o nome do usuário na sessão para uso nas próximas páginas
            $_SESSION["usuario"] = $usuario;
            header("Location: public/home.php");
            // Encerra o script para evitar que o código abaixo seja executado
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
 <!-- Formulário de login enviado via POST para a própria página -->
    <form method="POST">
        <label>Usuário:</label>
         <!-- Campo de texto para o nome de usuário -->
        <input type="text" name="usuario">
        <br>
        <label>Senha:</label>
          <!-- Campo de senha (oculta os caracteres digitados) -->
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