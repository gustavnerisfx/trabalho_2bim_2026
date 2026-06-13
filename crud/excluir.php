<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Gerente</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="../img/letra-n.png">
</head>

<body>
    <main class="container">

        <?php

        try {
            include "conexao.php";

            if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
                $id = base64_decode($_GET['id']);
            } else {
                header("Location: ../index.php");
                exit;
            }

            $sql = "DELETE FROM gerentes WHERE id = $id";
            $resultado = $conexao->query($sql);

            header("Location: ../index.php");
            exit;

        } catch (Exception $e) {

            header("Location: ../index.php?erro=" . urlencode($e->getMessage()));
            exit;
        }

        ?>

    </main>
</body>
<script src="../js/smoothscroll.js"></script>

</html>