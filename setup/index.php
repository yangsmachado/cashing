<?php
	// Checa se o arquivo "System.php" existe para decidir se inicia a instalacao [INICIO] 
	if (file_exists('../config/System.php')) {
		header('Location: ../');
		exit();
	}
	// Checa se o arquivo "System.php" existe para decidir se inicia a instalacao [FIM] 
	
	
	// Checa as configuracoes do servidor [INICIO]
	require 'core/model/Checkup.php';
	new Checkup(['pass' => '', 'notPass' => 'checkup.php']);
	// Checa as configuracoes do servidor [FIM]
	
	
	require '../config/System.model.php';
	
	// Contem todas as mensagens disparadas durante a instalacao [INICIO]
	$messages = [
		'error' => [
			'fields' => [
				'server' => [
					'host' => '',
					'user' => ''
				],
				
				'app' => [
					'db' => ''
				]
			],
			
			'mysql' => [],
			
			'file' => []
		],
		
		'success' => []
	];
	// Contem todas as mensagens disparadas durante a instalacao [FIM]
	
	
	// Contem todas as configuracoes digitadas pelo usuario durante a instalacao [INICIO]
	$server = [
		'host' => '',
		'user' => '',
		'password' => ''
	];
	// Contem todas as configuracoes digitadas pelo usuario durante a instalacao [FIM]
	
	
	$app = [
		'db' => 'cashing'
	];
	
	
	// Visoes para usar durante e pos instalacao [INICIO]
	$views = [
		'core/view/default.php',
		'core/view/success.php'
	];
	// Visoes para usar durante e pos instalacao [FIM]
	
	$view = $views[0];
	

	if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
		// Captura dados do usuario [INICIO]
		$server['host'] = filter_input(INPUT_POST, 'db-server');
		$server['user'] = filter_input(INPUT_POST, 'db-user');
		$server['password'] = filter_input(INPUT_POST, 'db-password');
		
		$app['db'] = filter_input(INPUT_POST, 'cashing-db');
		// Captura dados do usuario [FIM]
		
		
		require 'core/model/Setup.php';
		
		// Checa se os dados das configuracoes do servidor estao ok
		if (!Setup::checkServerConfig($server['host'], $server['user'], $server['password'])) {
			array_push($messages['error']['mysql'], 'Erro ao estabelecer a Conexão com o Servidor do Banco de Dados: ' . mysqli_connect_error());
			
		} else {
			$conn = mysqli_connect($server['host'], $server['user'], $server['password']);
			
			// Checa se o banco de dados existe
			if (!Setup::dbExists($conn, $app['db'])) {
				
				// Cria uma nova instalacao
				$setup = new Setup(
					$server,
					
					$app,
						
					[
						'config' => [
							'model' => '../config/System.model.php',
							'destination' => '../config/System.php'
						],
						
						'db' => [
							'new' => 'core/model/db-1.0.php'
						]
					]
				);
				
				if ($setup->isInstalled()) {
					// Dipara as mensagens de sucesso e as exibe atraves de uma view
					$messages['success'] = $setup->getSuccessMgs();
					$view = $views[1];
				} else {
					// Dispara mensagns de erro devido a nao instalacao do sistema
					$messages['error']['mysql'] = $setup->getMysqlMsgs();
					$messages['error']['file'] = $setup->getFileMsgs();
				}
			} else {
				// Dispara uma mensagem de erro devido a existencia do banco de dados
				$messages['error']['fields']['app']['db'] = 'O Banco de Dados ' . $app['db'] . ' Já Existe!';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
        <meta name="robots" content="noindex, nofollow" />
	    <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="author" content="Yan Gabriel da Silva Machado" />
		
		<title>Instalação &raquo; Cashing</title>
		
		<link rel="stylesheet" type="text/css" href="css/setup.css?v=1" />
 	</head>

	<body>
		<div class="container container--main<?php echo count($messages['error']['file']) > 0 ? ' container--error' : '';?>">
			<h1>Instalador <span class="destaque"><?php echo System::NAME;?></span></h1>
			<h3><span class="destaque"><?php echo System::NAME;?></span> - Versão <?php echo System::VERSION['string'];?></h3>

			
			<!-- Imprime os erros [INICIO] -->
			<?php for ($i = 0, $l = count($messages['error']['file']); $i < $l; $i++):?>
				<span class="error">&#10008; <?php echo $messages['error']['file'][$i];?></span>
			<?php endfor;?>
			<!-- Imprime os erros [FIM] -->

			<?php
				// Imprime a visao adequada
				require $view;
			?>
		</div>


		<div id="background--loading" class="background background--loading"></div>

		<script src="js/setup.js?v=1"></script>
	</body>
</html>