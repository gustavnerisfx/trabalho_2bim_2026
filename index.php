<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerentes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <main class="container">

        <div class="page-header">
            <div>
                <h1 class="page-title">Gerentes</h1>
                <p class="page-subtitle">Gerencie os cadastros da equipe</p>
            </div>
            <a href="crud/incluir.php" class="btn btn-primary">+ Incluir gerente</a>
        </div>

        <div class="search-bar">
            <form action="#" method="post" class="d-flex align-items-center gap-2 w-100">
                <input type="search" maxlength="50" placeholder="🔍  Pesquisar por nome..." id="busca"
                    name="filtro" class="form-control search-input">
                <input type="submit" value="Pesquisar" class="btn btn-secondary">
            </form>
        </div>

        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro ao excluir:</strong> <?php echo htmlspecialchars($_GET['erro']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php
        try {
            include "crud/conexao.php";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $filtro = $_POST["filtro"];
                $sql = "SELECT * FROM gerentes WHERE nome LIKE '%$filtro%' ORDER BY nome";
            } else {
                $sql = "SELECT * FROM gerentes ORDER BY nome";
            }

            $query = $conexao->query($sql);

            if ($query->num_rows === 0) {
                echo "<div class='empty-state'>
                        <div class='empty-icon'>👤</div>
                        <p>Nenhum gerente encontrado.</p>
                        <a href='crud/incluir.php' class='btn btn-primary'>Cadastrar o primeiro</a>
                      </div>";
            } else {
                echo "<div class='cards-grid'>";

                while ($dados = mysqli_fetch_array($query)) {
                    $imagem = empty($dados['foto']) ? "imagenotfound.png" : $dados['foto'];
                    $id = base64_encode($dados['id']);
                    $datanasc = date("d/m/Y", strtotime($dados['datanasc']));

                    echo "
                    <div class='gerente-card'>
                        <a href='crud/vergerente.php?id=$id' class='card-foto-link'>
                            <img src='img/$imagem' class='card-foto' alt='{$dados['nome']}'>
                        </a>
                        <div class='card-info'>
                            <span class='card-id'># {$dados['id']}</span>
                            <h2 class='card-nome'>{$dados['nome']}</h2>
                            <div class='card-detalhe'>
                                <span class='detalhe-label'>Departamento</span>
                                <span class='detalhe-valor'>{$dados['depto']}</span>
                            </div>
                            <div class='card-detalhe'>
                                <span class='detalhe-label'>Nascimento</span>
                                <span class='detalhe-valor'>$datanasc</span>
                            </div>
                            <div class='card-detalhe'>
                                <span class='detalhe-label'>Endereço</span>
                                <span class='detalhe-valor endereco'>{$dados['endereco']}</span>
                            </div>
                            <div class='card-acoes'>
                                <a href='crud/vergerente.php?id=$id' class='btn btn-outline-primary btn-sm'>Ver</a>
                                <a href='crud/editar.php?id=$id' class='btn btn-outline-secondary btn-sm'>Editar</a>
                                <a href='#' class='btn btn-outline-danger btn-sm'
                                   data-bs-toggle='modal' data-bs-target='#excluirModal' data-gerente='$id'>
                                    Apagar
                                </a>
                            </div>
                        </div>
                    </div>";
                }

                echo "</div>";
            }

        } catch (Exception $e) {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Erro:</strong> {$e->getMessage()}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

    </main>

    <?php include "modal.php"; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/dialogo.js"></script>
    <script src="js/smoothscroll.js"></script>
</body>
</html>