<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Gerente</title>
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

        $mensagem_sucesso = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome     = $_POST['nome'];
            $endereco = $_POST['endereco'];
            $depto    = $_POST['depto'];
            $data     = $_POST['datanasc'];

            if (!empty($_FILES["foto"]["name"])) {
                $target_dir  = "../img/";
                $arquivo     = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $arquivo;

                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $sql  = "UPDATE gerentes SET nome=?, endereco=?, depto=?, datanasc=?, foto=? WHERE id=?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute([$nome, $endereco, $depto, $data, $arquivo, $id]);
                } else {
                    throw new Exception("Erro ao enviar o novo arquivo de imagem.");
                }
            } else {
                $sql  = "UPDATE gerentes SET nome=?, endereco=?, depto=?, datanasc=? WHERE id=?";
                $stmt = $conexao->prepare($sql);
                $stmt->execute([$nome, $endereco, $depto, $data, $id]);
            }

            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Alterações salvas com sucesso!</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <a href='../index.php' class='btn btn-primary btn-sm ms-2'>Ver listagem</a>
                  </div>";
        }

        $sql      = "SELECT * FROM gerentes WHERE id = $id";
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {
            $dados    = $resultado->fetch_assoc();
            $nome     = $dados['nome'];
            $endereco = $dados['endereco'];
            $depto    = $dados['depto'];
            $dt       = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
            $data     = $dt->format("Y-m-d");
            $imagem   = empty($dados['foto']) ? "imagenotfound.png" : $dados['foto'];
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

    $id_enc = base64_encode($id);
    ?>

    <main class="container" style="padding-top:40px; padding-bottom:60px; max-width:820px;">

        <a href="../index.php" class="voltar-link">← Voltar para a listagem</a>

        <div class="perfil-card">

            <div class="incluir-foto-wrap">
                <img src="../img/<?php echo $imagem; ?>" id="preview" class="incluir-foto"
                     alt="<?php echo htmlspecialchars($nome); ?>">
                <div class="incluir-foto-overlay">
                    <label for="imagemnova" class="incluir-foto-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        Trocar foto
                    </label>
                    <input type="file" id="imagemnova" name="foto" accept="image/*"
                           form="form-editar" style="display:none;">
                </div>
            </div>

            <div class="perfil-body">

                <div class="perfil-header">
                    <div>
                        <p class="perfil-id"># <?php echo $id; ?></p>
                        <h1 class="perfil-nome" id="preview-nome"><?php echo htmlspecialchars($nome); ?></h1>
                        <span class="perfil-badge" id="preview-depto"><?php echo htmlspecialchars($depto); ?></span>
                    </div>
                </div>

                <div class="perfil-divider"></div>

                <form id="form-editar" action="editar.php?id=<?php echo $id_enc; ?>" method="post" enctype="multipart/form-data">

                    <div class="incluir-grid">

                        <div class="incluir-campo incluir-campo-full">
                            <label class="info-label" for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                   maxlength="80" required value="<?php echo htmlspecialchars($nome); ?>">
                        </div>

                        <div class="incluir-campo">
                            <label class="info-label" for="depto">Departamento</label>
                            <input type="text" class="form-control" id="depto" name="depto"
                                   maxlength="50" required value="<?php echo htmlspecialchars($depto); ?>">
                        </div>

                        <div class="incluir-campo">
                            <label class="info-label" for="datanasc">Data de Nascimento</label>
                            <input type="date" class="form-control" id="datanasc" name="datanasc"
                                   required value="<?php echo $data; ?>">
                        </div>

                        <div class="incluir-campo incluir-campo-full">
                            <label class="info-label" for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco"
                                   maxlength="100" required value="<?php echo htmlspecialchars($endereco); ?>">
                        </div>

                    </div>

                    <div class="card-acoes" style="margin-top:28px;">
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        <a href="../index.php" class="btn btn-outline-danger">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>

    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/smoothscroll.js"></script>
    <script>
        document.getElementById('imagemnova').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => document.getElementById('preview').src = ev.target.result;
            reader.readAsDataURL(file);
        });

        document.getElementById('nome').addEventListener('input', function () {
            document.getElementById('preview-nome').textContent = this.value || 'Nome do gerente';
        });

        document.getElementById('depto').addEventListener('input', function () {
            document.getElementById('preview-depto').textContent = this.value || 'Departamento';
        });
    </script>
</body>
</html>