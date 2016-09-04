<?php
    
    // Checa se classe ja existe antes de defini-la
    if (!class_exists('Connection')):
    
    /**
     *
     * Classe PDO para Conexão com Banco de Dados.
     * Usa informações da Classe Abstrata System (Arquivo de Configuração), criada a partir da instalação, para fazer a conexão
     * 
     * @version 1.0
     * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
     * 
     */
    final class Connection extends PDO {
        private $handle = null;
        
        /**
         *
         * @var $dsn String 
         * @var $user String Usuario do Banco de Dados
         * @var $password String Senha do Banco de dados
         */
        public function __construct (string $dsn = '', string $user = '', string $password = '') {
            if ($this->handle == null) {
                try {
                    if (empty($dsn) || empty($user) || empty($password)) {
                        if (class_exists('System')) {
                            $dsn = System::CONFIG['database']['dsn'];
                            $user = System::CONFIG['mysql']['user'];
                            $password = System::CONFIG['mysql']['password'];
                        }
                    }
                    
                    $this->handle = parent::__construct($dsn, $user, $password, []);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            } else {
                die('<span>Erro Interno. <br />Por favor, entre em contato com o Administrador do Sistema.</span>');
            }
        }
        
        public function __destruct() {
            $this->handle = null;
        }
    }
    
    endif;