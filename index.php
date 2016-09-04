<?php
    ini_set('display_errors', '1');
    
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