<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit();
}

include("../infra/db/connect.php");

// ── Etapa 2: confirmação via POST → executa o DELETE ──────────────────────
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = (int) $_POST["id"];

    $sql = "DELETE FROM usuarios WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
        exit();
    } else {
        $erro = "Erro ao excluir o usuário.";
    }
}

// ── Etapa 1: clique em "Excluir" via GET → busca dados e exibe confirmação ─
if (!isset($_GET["id"])) {
    header("Location: home.php");
    exit();
}

$id = (int) $_GET["id"];
$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = $conn->query($sql);

if ($resultado->num_rows === 0) {
    header("Location: home.php");
    exit();
}

$usuario = $resultado->fetch_assoc();
?>


</head>
<body>

<div class="card">
    <div class="icone-aviso">⚠️</div>
    <h2>Confirmar Exclusão</h2>
    <p>Você está prestes a excluir o usuário:</p>
    <p class="destaque"><?php echo htmlspecialchars($usuario['usuario']); ?></p>

    <div class="aviso">
        Esta ação é permanente e não poderá ser desfeita.
    </div>

    <div class="acoes">
        <!-- Cancelar: volta para a home sem fazer nada -->
        <a href="home.php" class="btn btn-cancelar">Cancelar</a>

        <!-- Confirmar: submete POST com o id para executar o DELETE -->
        <form method="POST" action="excluir.php">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
            <button type="submit" class="btn btn-confirmar">Sim, excluir</button>
        </form>
    </div>

    <?php if (isset($erro)): ?>
        <p class="erro"><?php echo $erro; ?></p>
    <?php endif; ?>
</div>

</body>
</html>