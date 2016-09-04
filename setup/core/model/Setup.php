<?php

    // Checa se classe ja existe antes de defini-la
    if (!class_exists('Setup')):
    
	/**
	 *
	 * Classe responsavel por toda a instalacao e utilizacao de recursos para a mesma
	 * 
	 * @version 1.0
	 * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
	 * 
	 */
    class Setup {
        private $server = [];
        private $app = [];
		private $file = [];
		
		private $messages = [
			'error' => [
				'mysql' => [],
				
				'file' => []
			],
			
			'success' => []
		];
		
        private $encryptionKeys = [];
        private $installed = false;
        
        public function __construct (
            array $server = [
                'host' => '',
                'user' => '',
                'password' => ''
            ],
            
            array $app = [
                'db' => ''
            ],
            
			array $file = [
				'config' => [
					'model' => '',
					'destination' => ''
				],
				
				'db' => [
					'new' => ''
				]
			]
        ) {
            
			$serverArrKeys = array_keys($server);
            array_search('host', $serverArrKeys, true)!==false && array_search('user', $serverArrKeys, true)!==false && array_search('password', $serverArrKeys, true)!==false ? '' : exit;
            
            
            $appArrKeys = array_keys($app);
            array_search('db', $appArrKeys, true)!==false ? '' : exit;
            
            
			$fileArrKeys = array_keys($file);
			if (array_search('config', $fileArrKeys, true)!==false) {
				$fileArrConfig = array_keys($file['config']);
			
				if (array_search('model', $fileArrConfig, true)!==false && array_search('destination', $fileArrConfig, true)!==false) {
					if (!file_exists($file['config']['model'])) {
						array_push($this->messages['error']['file'], 'Erro ao Criar Arquivo de Configuração: <br /> <b>Arquivo Modelo de Configuração</b> Não Encontrado!');
				
						exit;
					}
				} else {
					exit;
				}
			} else {
				exit;
			}
			
            
            if (self::checkServerConfig($server['host'], $server['user'], $server['password'])) {
                array_push($this->messages['success'], 'Conectando ao Servidor do Banco de Dados...');
            
                $this->server = $server;
                $this->app = $app;
                $this->file = $file;
                
                $this->install();
            } else {
                array_push($this->messages['error']['mysql'], 'Erro ao Estabelecer Conexão com o Servidor ' . $server['host'] . ' do Banco de Dados <span class="destaque">' . $app['db'] . '</span>: ' . mysqli_connect_error());
                exit;
            }
        }
        
		
        private function install () {
            $conn = mysqli_connect($this->server['host'], $this->server['user'], $this->server['password']);
            
            if (mysqli_set_charset($conn, 'utf8')) {
                array_push($this->messages['success'], 'Alterando CHARSET da Conexão com o Servidor do Banco de Dados para UTF-8...');
            } else {
                array_push($this->messages['error']['mysql'], 'Erro ao mudar CHARSET da Conexão com o Banco de Dados para UTF-8.');
                exit;
            }
            
            
            $this->encryptionKeys = [
				'db' => md5(uniqid(rand(), true)),
			];
            
			
            $this->createDB($conn);
            
            if ($this->installed) {
				$this->createConfigFile();
					
				$this->installed = count($this->messages['error']['file']) === 0 ? true : false;
            }
        }
        
        
        private function createDB (mysqli $conn) {
            if (file_exists($this->file['db']['new'])) {
				require $this->file['db']['new'];
				
				array_push($this->messages['success'], 'Checando arquivos do Banco de Dados...');
				
				if (mysqli_multi_query($conn, $sqlDatabase)) {
					do {
						if (mysqli_store_result($conn)) {
							mysqli_free_result($conn);
						}
					} while (mysqli_next_result($conn));
					
					array_push($this->messages['success'], 'Criando Banco de Dados <span class="destaque">' . $this->app['db'] . '</span>...');
					
					$this->installed = true;
				} else {
					array_push($this->messages['error']['mysql'], 'Erro ao criar Banco de Dados <span class="destaque">' . $this->app['db'] . '</span>: '. mysqli_error($conn));
				}
			} else {
				array_push($this->messages['error']['file'], 'Erro ao encontrar Arquivo de Implementação do Banco de Dados!');
			}
        }
        
        
        private function createConfigFile (): bool {
            array_push($this->messages['success'], 'Criando Arquivo de Configuração...');	
			
			$content = file_get_contents($this->file['config']['model']);
			
			$content = str_replace('$host', $this->server['host'], $content);
			
			$content = str_replace('$user', $this->server['user'], $content);
			
			$content = str_replace('$password', $this->server['password'], $content);
            
			$content = str_replace('$dbname', $this->app['db'], $content);
			
            $configFile = fopen($this->file['config']['destination'], 'w');
			if (fwrite($configFile, $content)) {
                array_push($this->messages['success'], 'Escrevendo no Arquivo de Configuração...');

                if (fclose($configFile)) {
                    array_push($this->messages['success'], 'Salvando Arquivo de Configuração...');
                    return true;
                } else {
                    array_push($this->messages['error']['file'], 'Erro ao Fechar Arquivo de Configuração');
				}
			} else {
                array_push($this->messages['error']['file'], 'Erro ao Escrever Arquivo de Configuração');
			}
            
            return false;
        }
        
        
        public static function checkServerConfig (string $host, string $user, string $password): bool {
            
            $conn = mysqli_connect($host, $user, $password);
            if ($conn) {
                mysqli_close($conn);
            }
            
            return $conn ? true : false;
        }
		
		public static function dbExists (mysqli $conn, string $dbName): bool {
			
            return mysqli_select_db($conn, $dbName) ? true : false;
        }
		
		public function isInstalled (): bool {
			return $this->installed;
		}
		
		public function getSuccessMgs (): array {
			return $this->messages['success'];
		}
		
		public function getMysqlMsgs (): array {
			return $this->messages['error']['mysql'];
		}
		
		public function getFileMsgs (): array {
			return $this->messages['error']['file'];
		}
    }
    
    endif;