<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Gerente</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../img/letra-n.png">
</head>

<body>

    <header
        style="background:#1a2b4a; padding:0 40px; display:flex; align-items:center; justify-content:space-between; height:64px;">

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

        $mensagem_sucesso = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['nome'];
            $endereco = $_POST['endereco'];
            $depto = $_POST['depto'];
            $data = $_POST['datanasc'];

            if (!empty($_FILES["foto"]["name"])) {
                $target_dir = "../img/";
                $arquivo = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $arquivo;

                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $sql = "UPDATE gerentes SET nome=?, endereco=?, depto=?, datanasc=?, foto=? WHERE id=?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute([$nome, $endereco, $depto, $data, $arquivo, $id]);
                } else {
                    throw new Exception("Erro ao enviar o novo arquivo de imagem.");
                }
            } else {
                $sql = "UPDATE gerentes SET nome=?, endereco=?, depto=?, datanasc=? WHERE id=?";
                $stmt = $conexao->prepare($sql);
                $stmt->execute([$nome, $endereco, $depto, $data, $id]);
            }

            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Alterações salvas com sucesso!</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <a href='../index.php' class='btn btn-primary btn-sm ms-2'>Voltar</a>
                  </div>";
        }

        $sql = "SELECT * FROM gerentes WHERE id = $id";
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {
            $dados = $resultado->fetch_assoc();
            $nome = $dados['nome'];
            $endereco = $dados['endereco'];
            $depto = $dados['depto'];
            $dt = new DateTime($dados['datanasc'], new DateTimeZone("America/Sao_Paulo"));
            $data = $dt->format("Y-m-d");
            $imagem = empty($dados['foto']) ? "imagenotfound.png" : $dados['foto'];
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

        <a href="../index.php" class="voltar-link">← Voltar</a>

        <div class="perfil-card">

            <div class="incluir-foto-wrap">
                <img src="../img/<?php echo $imagem; ?>" id="preview" class="incluir-foto"
                    alt="<?php echo htmlspecialchars($nome); ?>">
                <div class="incluir-foto-overlay">
                    <label for="imagemnova" class="incluir-foto-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Trocar foto
                    </label>
                    <input type="file" id="imagemnova" name="foto" accept="image/*" form="form-editar"
                        style="display:none;">
                    <span class="erro" id="erroFoto" style="color:red;"></span>
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

                <form id="form-editar" action="editar.php?id=<?php echo $id_enc; ?>" method="post"
                    enctype="multipart/form-data">

                    <div class="incluir-grid">

                        <div class="incluir-campo incluir-campo-full">
                            <label class="info-label" for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="80" required
                                value="<?php echo htmlspecialchars($nome); ?>">
                            <span class="erro" id="erroNome" style="color:red;"></span>
                        </div>

                        <div class="incluir-campo">
                            <label class="info-label" for="depto">Departamento</label>
                            <input type="text" class="form-control" id="depto" name="depto" maxlength="50" required
                                value="<?php echo htmlspecialchars($depto); ?>">
                            <span class="erro" id="erroDepto" style="color:red;"></span>
                        </div>

                        <div class="incluir-campo">
                            <label class="info-label" for="datanasc">Data de Nascimento</label>
                            <input type="date" class="form-control" id="datanasc" name="datanasc" required
                                value="<?php echo $data; ?>">
                            <span class="erro" id="erroData" style="color:red;"></span>
                        </div>

                        <div class="incluir-campo incluir-campo-full">
                            <label class="info-label" for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" maxlength="100"
                                required value="<?php echo htmlspecialchars($endereco); ?>">
                            <span class="erro" id="erroEndereco" style="color:red;"></span>
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
                    <li><a href="../index.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Listagem de
                            gerentes</a></li>
                    <li><a href="incluir.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Incluir
                            gerente</a></li>
                    <li><a href="../index.php" style="font-size:13px;color:#8fa3be;text-decoration:none;">Editar cadastro</a></li>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('form-editar');
            const inputFoto = document.getElementById('imagemnova');
            const preview = document.getElementById('preview');

            // --- Atualiza pré-visualização da foto ---
            inputFoto.addEventListener('change', function () {
                const erroFoto = document.getElementById('erroFoto');
                erroFoto.textContent = '';
                const arquivo = this.files[0];

                if (!arquivo) return;

                // Valida tipo de arquivo
                const tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!tiposPermitidos.includes(arquivo.type)) {
                    erroFoto.textContent = 'Formato de imagem inválido. Use JPG, PNG, GIF ou WEBP.';
                    this.value = '';
                    return;
                }

                // Valida tamanho (máx 2MB)
                const tamanhoMaximo = 2 * 1024 * 1024;
                if (arquivo.size > tamanhoMaximo) {
                    erroFoto.textContent = 'A imagem deve ter no máximo 2MB.';
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(arquivo);
            });

            // Atualiza nome e departamento no preview enquanto digita
            document.getElementById('nome').addEventListener('input', function () {
                document.getElementById('preview-nome').textContent = this.value || 'Nome do gerente';
            });

            document.getElementById('depto').addEventListener('input', function () {
                document.getElementById('preview-depto').textContent = this.value || 'Departamento';
            });


            function limparErros() {
                document.querySelectorAll('.erro').forEach(el => el.textContent = '');
            }

            // Validação no envio do formulário
            form.addEventListener('submit', function (event) {
                let valido = true;
                limparErros();

                // Nome
                const nome = document.getElementById('nome').value.trim();
                if (nome === '') {
                    document.getElementById('erroNome').textContent = 'O nome é obrigatório.';
                    valido = false;
                } else if (nome.length < 3) {
                    document.getElementById('erroNome').textContent = 'O nome deve ter ao menos 3 caracteres.';
                    valido = false;
                }

                // Departamento
                const depto = document.getElementById('depto').value.trim();
                if (depto === '') {
                    document.getElementById('erroDepto').textContent = 'O departamento é obrigatório.';
                    valido = false;
                } else if (depto.length > 50) {
                    document.getElementById('erroDepto').textContent = 'O departamento excede o tamanho máximo permitido.';
                    valido = false;
                }

                // Endereço
                const endereco = document.getElementById('endereco').value.trim();
                if (endereco === '') {
                    document.getElementById('erroEndereco').textContent = 'O endereço é obrigatório.';
                    valido = false;
                } else if (endereco.length > 100) {
                    document.getElementById('erroEndereco').textContent = 'O endereço excede o tamanho máximo permitido.';
                    valido = false;
                }

                // Data de nascimento
                const dataNasc = document.getElementById('datanasc').value;
                if (dataNasc === '') {
                    document.getElementById('erroData').textContent = 'A data de nascimento é obrigatória.';
                    valido = false;
                } else {
                    const hoje = new Date();
                    const nascimento = new Date(dataNasc);
                    hoje.setHours(0, 0, 0, 0);

                    if (nascimento > hoje) {
                        document.getElementById('erroData').textContent = 'A data de nascimento não pode ser no futuro.';
                        valido = false;
                    }

                    const idadeMinima = 16;
                    const limiteIdade = new Date();
                    limiteIdade.setFullYear(hoje.getFullYear() - idadeMinima);
                    if (nascimento > limiteIdade) {
                        document.getElementById('erroData').textContent = `É necessário ter ao menos ${idadeMinima} anos.`;
                        valido = false;
                    }
                }

                if (!valido) {
                    event.preventDefault();
                }
            });

        });
    </script>

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