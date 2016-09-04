<?php
    
    // Checa se classe ja existe antes de defini-la
    if (!class_exists('Checkup')):
    
    /**
     *
     * Checa algumas configuracoes do servidor antes da instalacao
     * 
     * @version 1.0
     * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
     */
    class Checkup {
        private $phpVersion = '7.0.0';
        
        private $exam =  [
            'server' => [
                'mysql' => false,
                'apache' => false
            ],
            
            'language' => [
                'php' => [
                    'version' => false,
                    'pdo' => false
                ]
            ]
        ];
        
        
        public function __construct (
            $go = [
                'pass' => '',
                'notPass' => ''
            ]
        ) {
            
            if (stripos($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {
                $this->exam['server']['apache'] = true;
            }
    
            if (extension_loaded('pdo_mysql')) {
                $this->exam['server']['mysql'] = true;
                $this->exam['language']['php']['pdo'] = true;
            }
    
            if (version_compare(PHP_VERSION, $this->phpVersion, '>=')) {
                $this->exam['language']['php']['version'] = true;
            }
            
            if (!$this->exam['server']['apache'] || !$this->exam['language']['php']['version'] || !$this->exam['language']['php']['pdo']) {
                if (!empty($go['notPass'])) {
                    header('Location: ' . $go['notPass']);
                    exit();
                }
            } else {
                if (!empty($go['pass'])) {
                    header('Location: ' . $go['pass']);
                    exit();
                }
            }
        }
        
        
        public function getPHPRequiredVersion () {
            return $this->phpVersion;
        }
        
        
        public function results () {
            return $this->exam;
        }
    }
    
    endif;