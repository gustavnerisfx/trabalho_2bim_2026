<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Gerente</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    try {
        include "conexao.php";

        if (isset($_GET['id']) && is_numeric(base64_decode($_GET['id']))) {
            $id = base64_decode($_GET['id']);
        } else {
            header("Location: ../index.php");
            exit;
        }

        $sql = "SELECT * FROM gerentes WHERE id = $id";
        $query = $conexao->query($sql);

        if ($query->num_rows > 0) {
            $dados = $query->fetch_assoc();
            $nome     = $dados["nome"];
            $endereco = $dados["endereco"];
            $depto    = $dados["depto"];
            $dt       = new DateTime($dados["datanasc"], new DateTimeZone("America/Sao_Paulo"));
            $data     = $dt->format("d/m/Y");
            $imagem   = empty($dados['foto']) ? "imagenotfound.png" : $dados['foto'];
            $id_enc   = base64_encode($id);
        } else {
            throw new Exception("Gerente não encontrado!");
        }
    } catch (Exception $e) {
        echo "<main class='container' style='padding-top:40px'>
                <div class='alert alert-danger'>{$e->getMessage()}</div>
                <a href='../index.php' class='btn btn-primary'>Voltar</a>
              </main>";
        exit;
    }
    ?>

    <main class="container" style="padding-top: 40px; padding-bottom: 60px; max-width: 820px;">

        <a href="../index.php" class="voltar-link">← Voltar para a listagem</a>

        <div class="perfil-card">

            <div class="perfil-foto-wrap">
                <img src="../img/<?php echo $imagem; ?>" alt="<?php echo $nome; ?>" class="perfil-foto">
            </div>

            <div class="perfil-body">

                <div class="perfil-header">
                    <div>
                        <p class="perfil-id"># <?php echo $id; ?></p>
                        <h1 class="perfil-nome"><?php echo $nome; ?></h1>
                        <span class="perfil-badge"><?php echo $depto; ?></span>
                    </div>
                    <div class="perfil-acoes">
                        <a href="editar.php?id=<?php echo $id_enc; ?>" class="btn btn-primary">Editar</a>
                    </div>
                </div>

                <div class="perfil-divider"></div>

                <div class="perfil-info-grid">
                    <div class="info-item">
                        <span class="info-label">Departamento</span>
                        <span class="info-valor"><?php echo $depto; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Data de Nascimento</span>
                        <span class="info-valor"><?php echo $data; ?></span>
                    </div>
                    <div class="info-item info-item-full">
                        <span class="info-label">Endereço</span>
                        <span class="info-valor"><?php echo $endereco; ?></span>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/smoothscroll.js"></script>
</body>
</html>