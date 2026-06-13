<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Gerente</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        include "conexao.php";

        $nome     = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $depto    = $_POST['depto'];
        $datanasc = $_POST['datanasc'];

        $target_dir  = "../img/";
        $arquivo     = basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $arquivo;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $sql  = "INSERT INTO gerentes (nome, endereco, depto, datanasc, foto) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$nome, $endereco, $depto, $datanasc, $arquivo]);

            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Gerente cadastrado com sucesso!</strong> " . htmlspecialchars($arquivo) . " foi salvo.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <a href='../index.php' class='btn btn-primary btn-sm ms-2'>Ver listagem</a>
                  </div>";
        } else {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Erro ao enviar imagem.</strong> O gerente não foi salvo.
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Erro:</strong> " . $e->getMessage() . "
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
    }
}
?>

    <main class="container" style="padding-top:40px; padding-bottom:60px; max-width:820px;">

        <a href="../index.php" class="voltar-link">← Voltar para a listagem</a>

        <div class="perfil-card">

            <div class="incluir-foto-wrap">
                <img src="../img/imagenotfound.png" id="preview" class="incluir-foto" alt="Preview">
                <div class="incluir-foto-overlay">
                    <label for="imagemnova" class="incluir-foto-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        Escolher foto
                    </label>
                    <input type="file" id="imagemnova" name="foto" accept="image/*" required
                           form="form-gerente" style="display:none;">
                </div>
            </div>

            <div class="perfil-body">

                <div class="perfil-header">
                    <div>
                        <p class="perfil-id">Novo cadastro</p>
                        <h1 class="perfil-nome" id="preview-nome">Nome do gerente</h1>
                        <span class="perfil-badge" id="preview-depto">Departamento</span>
                    </div>
                </div>

                <div class="perfil-divider"></div>

                <form id="form-gerente" action="incluir.php" method="post" enctype="multipart/form-data">

                    <div class="incluir-grid">

                        <div class="incluir-campo incluir-campo-full">
                            <label class="info-label" for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                   maxlength="80" required placeholder="Nome completo">
                        </div>

                        <div class="incluir-campo">
                            <label class="info-label" for="depto">Departamento</label>
                            <input type="text" class="form-control" id="depto" name="depto"
                                   maxlength="50" required placeholder="Ex: Financeiro">
                        </div>

                        <div class="incluir-campo">
                            <label class="info-label" for="datanasc">Data de Nascimento</label>
                            <input type="date" class="form-control" id="datanasc" name="datanasc" required>
                        </div>

                        <div class="incluir-campo incluir-campo-full">
                            <label class="info-label" for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco"
                                   maxlength="100" required placeholder="Rua, número, bairro, cidade">
                        </div>

                    </div>

                    <div class="card-acoes" style="margin-top:28px;">
                        <button type="submit" class="btn btn-primary">Salvar gerente</button>
                        <button type="reset" class="btn btn-outline-secondary"
                                onclick="document.getElementById('preview').src='../img/imagenotfound.png';
                                         document.getElementById('preview-nome').textContent='Nome do gerente';
                                         document.getElementById('preview-depto').textContent='Departamento';">
                            Limpar
                        </button>
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
            const el = document.getElementById('preview-nome');
            el.textContent = this.value || 'Nome do gerente';
        });

        document.getElementById('depto').addEventListener('input', function () {
            const el = document.getElementById('preview-depto');
            el.textContent = this.value || 'Departamento';
        });
    </script>
</body>
</html>