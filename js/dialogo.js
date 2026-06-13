// Espera a página carregar completamente
document.addEventListener("DOMContentLoaded", function () {
    
    // Procura o modal pelo ID dele
    var excluirModal = document.getElementById('excluirModal');
    
    if (excluirModal) {
        // Dispara uma função SEMPRE que o modal estiver prestes a abrir
        excluirModal.addEventListener('show.bs.modal', function (event) {
            
            // Descobre qual botão "Apagar" específico foi clicado na tabela
            var botaoDisparador = event.relatedTarget;
            
            // Pega o ID (base64) que está guardado no 'data-gerente' desse botão
            var idGerente = botaoDisparador.getAttribute('data-gerente');
            
            // Procura o botão "Sim" (confirmar) dentro do modal
            var botaoConfirmar = excluirModal.querySelector('#confirmar');
            
            // Altera o link do botão "Sim" adicionando o ID do gerente selecionado
            // Como excluir.php está na pasta crud/, passamos o caminho 'crud/excluir.php'
            botaoConfirmar.setAttribute('href', 'crud/excluir.php?id=' + idGerente);
        });
    }
});