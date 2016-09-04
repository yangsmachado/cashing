<?php
    // Visao utilizada quando a instalacao e feita com sucesso
?>
<h1>Sistema Instalado com Sucesso!</h1>

<h3>Log de Instalação</h3>
<div class="success">
    <ul class="list">
    <?php
        for ($i = 0, $l = count($messages['success']); $i < $l; $i++) {
            echo '<li class="list-item list-item--status-green"> ' . $messages['success'][$i] . '</li>';
        }
    ?>
    </ul>
</div>

<button type="button" class="button" onclick="window.location.reload(true);">Ir para o Sistema</button>