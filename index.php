<?php
    // Os codigos e comentarios podem ficar muitos longos em uma mesma linha pois a ide que utilizei possui o recurso de Word Wrap que as quebra para mim.

    // Checa se o sistema ja esta instalado antes de tentar a instalacao
    if (!file_exists('config/System.php')) {
        header('Location: setup');
        exit();
    }
    
    
    require 'config/System.php';
    require 'core/model/Connection.php';
    require 'core/model/FinancialSituation.php';
    require 'core/controller/Cashing.php';
    
    new Cashing();