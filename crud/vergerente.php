<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Gerente</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/letra-n.png">
</head>

<body>

    <header
        style="background:#1a2b4a; padding:0 40px; display:flex; align-items:center; justify-content:space-between; height:64px;">

        <!-- Logo + Nav -->
        <div style="display:flex; align-items:center; gap:32px;">

            <a href="index.php" style="display:flex; align-items:center; gap:10px; text-decoration:none;">
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

            <nav style="display:flex; align-items:center; gap:4px;">
                <a href="index.php"
                    style="font-size:13px; color:#5b9bd5; text-decoration:none; padding:6px 12px; border-radius:6px; background:rgba(91,155,213,0.15);">
                    Gerentes
                </a>
                <a href="#"
                    style="font-size:13px; color:#8fa3be; text-decoration:none; padding:6px 12px; border-radius:6px;">
                    Relatórios
                </a>
                <a href="#"
                    style="font-size:13px; color:#8fa3be; text-decoration:none; padding:6px 12px; border-radius:6px;">
                    Configurações
                </a>
            </nav>

        </div>


        <div style="display:flex; align-items:center; gap:10px;">

            <div style="width:0.5px; height:24px; background:rgba(255,255,255,0.12);"></div>
            <div
                style="width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,0.08); border:0.5px solid rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; color:#8fa3be; cursor:pointer;">
                &#128100;
            </div>
        </div>

    </header>

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
            $nome = $dados["nome"];
            $endereco = $dados["endereco"];
            $depto = $dados["depto"];
            $dt = new DateTime($dados["datanasc"], new DateTimeZone("America/Sao_Paulo"));
            $data = $dt->format("d/m/Y");
            $imagem = empty($dados['foto']) ? "imagenotfound.png" : $dados['foto'];
            $id_enc = base64_encode($id);
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

    <footer style="background:#1a2b4a; color:#e0e6f0; font-family:sans-serif; padding:48px 40px 0 40px;">
        <div
            style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:32px; padding-bottom:40px; border-bottom:0.5px solid rgba(255,255,255,0.12);">

            <div>
                <p style="font-size:22px; font-weight:600; color:#fff; margin:0 0 4px;">Nexora Tech</p>
                <p
                    style="font-size:11px; letter-spacing:1.5px; color:#5b9bd5; text-transform:uppercase; margin:0 0 14px;">
                    Soluções em Tecnologia</p>
                <p style="font-size:13px; line-height:1.7; color:#8fa3be; margin:0 0 20px; max-width:260px;">
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

            <div>
                <div style="width:32px;height:3px;background:#5b9bd5;border-radius:2px;margin-bottom:16px;"></div>
                <p style="font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:#fff;margin:0 0 16px;">
                    Sistema</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="index.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Listagem de
                            gerentes</a></li>
                    <li><a href="crud/incluir.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Incluir
                            gerente</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Editar cadastro</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Relatórios</a></li>
                </ul>
            </div>

            <div>
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

            <div>
                <div style="width:32px;height:3px;background:#5b9bd5;border-radius:2px;margin-bottom:16px;"></div>
                <p style="font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:#fff;margin:0 0 16px;">
                    Contato</p>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:10px;">
                    <li><a href="#"
                            style="font-size:13px;color:#8fa3be;text-decoration:none;">contato@nexoratech.com.br</a>
                    </li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">(11) 9 8765-4321</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">São Paulo, SP</a></li>
                    <li><a href="#" style="font-size:13px;color:#8fa3be;text-decoration:none;">Seg–Sex, 08h–18h</a></li>
                </ul>
            </div>

        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;padding:20px 0;">
            <p style="font-size:12px;color:#5b7495;margin:0;">© 2026 Nexora Tech. Todos os direitos reservados.</p>
            <div style="display:flex;gap:8px;">
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

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/smoothscroll.js"></script>
</body>

</html>