<?php
    session_start();
// Inclui o arquivo de conexão com o banco de dados
    include("infra/db/connect.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
// Executa a query no banco de dados
        $resultado = $conn->query($sql);
 // Verifica se algum usuário foi encontrado com as credenciais informadas
        if ($resultado->num_rows > 0){
             // Armazena o nome do usuário na sessão para uso nas próximas páginas
            $_SESSION["usuario"] = $usuario;
            // Redireciona para a página inicial após login bem-sucedido
            header("Location: public/home.php");
            // Encerra o script para evitar que o código abaixo seja executado
            exit();
        }else{
            // Define a mensagem de erro caso as credenciais sejam inválidas
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