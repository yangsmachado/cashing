<?php
    
    // Checa se classe ja existe antes de defini-la
    if (!class_exists('System')):
    
    /**
     *
     * Serve de modelo de classe de configuracao para a instalacao criar a verdadeira "System.php"
     * 
     * @version 1.0
     * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
     *
     */
    abstract class System {
        const NAME = 'Cashing';
        
        const VERSION = [
            'number' => 1.0,
            'string' => '1.0',
            'array' => [1, 0]
        ];
        
        const CHARSET = 'UTF-8';
        
        const DATABASE = [
            'version' => [
                'number' => 1.0,
                'string' => '1.0',
                'array' => [1, 0]
            ],
            
            'release' => [
                'date' => '2016-08-02',
                'time' => '23:43:56'
            ]
        ];
        
        const RELEASE = [
            'date' => '2016-08-02',
            'time' => '23:43:56'
        ];
        
        const SETUP = [
            'version' => [
                'number' => 1.0,
                'string' => '1.0',
                'array' => [1, 0]
            ],
            
            'release' => [
                'date' => '2016-08-02',
                'time' => '23:43:56'
            ],             
        ];
        
        const DEVELOPER = [
            'name' => 'Yan Gabriel da Silva Machado',
            'url' => 'https://github.com/yangsmachado'
        ];
        
        const CONFIG = [
            'mysql' => [
                'user' => '$user',
                'password' => '$password'
            ],
            
            'database' => [
                'dsn' => 'mysql:dbname=$dbname; charset=utf8; host=$host'
            ]
        ];
    }
    
    endif;