<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerentes</title>
    <link rel="icon" type="image/png" href="img/letra-n.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header
        style="background:#1a2b4a; padding:0 40px; display:flex; align-items:center; justify-content:space-between; height:64px; position:relative;">

        <!-- Logo -->
        <a href="index.php" style="display:flex; align-items:center; gap:10px; text-decoration:none; flex-shrink:0;">
            <div
                style="width:34px; height:34px; background:#5b9bd5; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px;">
                &#9776;
            </div>
            <div style="line-height:1;">
                <div style="font-size:16px; font-weight:600; color:#fff; letter-spacing:-0.2px;">Nexora Tech</div>
                <div
                    style="font-size:10px; color:#5b9bd5; letter-spacing:1px; text-transform:uppercase; margin-top:2px;">
                    Gestão de Gerentes</div>
            </div>
        </a>

        <!-- Nav desktop (centralizada) -->
        <nav class="d-none d-md-flex align-items-center gap-1"
            style="position:absolute; left:50%; transform:translateX(-50%);">
            <a href="index.php"
                style="font-size:13px; color:#5b9bd5; text-decoration:none; padding:6px 12px; border-radius:6px; background:rgba(91,155,213,0.15);">Gerentes</a>
            <a href="#"
                style="font-size:13px; color:#8fa3be; text-decoration:none; padding:6px 12px; border-radius:6px;">Relatórios</a>
            <a href="#"
                style="font-size:13px; color:#8fa3be; text-decoration:none; padding:6px 12px; border-radius:6px;">Configurações</a>
        </nav>

        <!-- Direita: avatar + hambúrguer -->
        <div class="d-flex align-items-center gap-2" style="flex-shrink:0;">
            <div
                style="width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,0.08); border:0.5px solid rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; color:#8fa3be; cursor:pointer;">
                &#128100;
            </div>
            <button class="d-md-none navbar-toggler border-0 p-0 ms-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileNav" style="background:transparent; box-shadow:none;">
                <span style="display:flex; flex-direction:column; gap:5px; padding:4px;">
                    <span style="display:block; width:22px; height:2px; background:#8fa3be; border-radius:2px;"></span>
                    <span style="display:block; width:22px; height:2px; background:#8fa3be; border-radius:2px;"></span>
                    <span style="display:block; width:22px; height:2px; background:#8fa3be; border-radius:2px;"></span>
                </span>
            </button>
        </div>

        <!-- Menu mobile colapsável -->
        <div class="collapse d-md-none" id="mobileNav"
            style="position:absolute; top:64px; left:0; right:0; background:#1a2b4a; border-top:0.5px solid rgba(255,255,255,0.1); z-index:100;">
            <div class="d-flex flex-column p-3 gap-1">
                <a href="index.php"
                    style="font-size:14px; color:#5b9bd5; text-decoration:none; padding:10px 12px; border-radius:6px; background:rgba(91,155,213,0.15);">Gerentes</a>
                <a href="#"
                    style="font-size:14px; color:#8fa3be; text-decoration:none; padding:10px 12px; border-radius:6px;">Relatórios</a>
                <a href="#"
                    style="font-size:14px; color:#8fa3be; text-decoration:none; padding:10px 12px; border-radius:6px;">Configurações</a>
            </div>
        </div>

    </header>

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
                <input type="search" maxlength="50" placeholder="🔍  Pesquisar por nome..." id="busca" name="filtro"
                    class="form-control search-input">
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

    <footer style="background:#1a2b4a; color:#e0e6f0; font-family:sans-serif; padding:48px 40px 0 40px;">

        <div class="row g-4 pb-4" style="border-bottom:0.5px solid rgba(255,255,255,0.12);">

            <!-- Marca -->
            <div class="col-12 col-md-5 col-lg-4">
                <p style="font-size:22px; font-weight:600; color:#fff; margin:0 0 4px;">Nexora Tech</p>
                <p
                    style="font-size:11px; letter-spacing:1.5px; color:#5b9bd5; text-transform:uppercase; margin:0 0 14px;">
                    Soluções em Tecnologia</p>
                <p style="font-size:13px; line-height:1.7; color:#8fa3be; margin:0 0 20px;">
                    Desenvolvemos sistemas inteligentes para empresas que querem crescer com eficiência, segurança e
                    inovação.
                </p>
                <div style="display:flex; gap:10px;">
                    <a href="#"
                        style="width:34px;height:34px;border-radius:8px;border:0.5px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#8fa3be;text-decoration:none;">in</a>
                    <a href="#"
                        style="width:34px;height:34px;border-radius:8px;border:0.5px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#8fa3be;text-decoration:none;">ig</a>
                    <a href="#"
                        style="width:34px;height:34px;border-radius:8px;border:0.5px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#8fa3be;text-decoration:none;">gh</a>
                </div>
            </div>

            <!-- Sistema -->
            <div class="col-6 col-md-2 offset-md-1 col-lg-2 offset-lg-2">
                <div style="width:32px;height:3px;background:#5b9bd5;border-radius:2px;margin-bottom:16px;"></div>
                <p style="font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:#fff;margin:0 0 16px;">
                    Sistema</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="index.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Listagem de
                            gerentes</a></li>
                    <li><a href="crud/incluir.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Incluir
                            gerente</a></li>
                    <li><a href="index.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Editar cadastro</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Relatórios</a></li>
                </ul>
            </div>

            <!-- Empresa -->
            <div class="col-6 col-md-2 col-lg-2">
                <div style="width:32px;height:3px;background:#5b9bd5;border-radius:2px;margin-bottom:16px;"></div>
                <p style="font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:#fff;margin:0 0 16px;">
                    Empresa</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Sobre nós</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Nossos serviços</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Cases de sucesso</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Blog</a></li>
                </ul>
            </div>

            <!-- Contato -->
            <div class="col-12 col-md-2 col-lg-2">
                <div style="width:32px;height:3px;background:#5b9bd5;border-radius:2px;margin-bottom:16px;"></div>
                <p style="font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:#fff;margin:0 0 16px;">
                    Contato</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="#"
                            style="font-size:13px;color:#8fa3be;text-decoration:none;">contato@nexoratech.com.br</a>
                    </li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">(11) 9 8765-4321</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">São Paulo, SP</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Seg–Sex, 09-19h</a></li>
                </ul>
            </div>

        </div>

        <div
            class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 py-3">
            <p style="font-size:12px;color:#5b7495;margin:0;">© 2026 Nexora Tech. Todos os direitos reservados.</p>
            <div class="d-flex gap-2 flex-wrap">
                <span
                    style="font-size:11px;color:#5b7495;border:0.5px solid rgba(255,255,255,0.1);border-radius:8px;padding:4px 10px;">Privacidade</span>
                <span
                    style="font-size:11px;color:#5b7495;border:0.5px solid rgba(255,255,255,0.1);border-radius:8px;padding:4px 10px;">Termos
                    de uso</span>
                <span
                    style="font-size:11px;color:#5b7495;border:0.5px solid rgba(255,255,255,0.1);border-radius:8px;padding:4px 10px;">LGPD</span>
            </div>
        </div>

    </footer>

    <?php include "modal.php"; ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/dialogo.js"></script>
    <script src="js/smoothscroll.js"></script>

</body>

</html>