<?php
	require 'core/model/Checkup.php';

	// Verifica as configuracoes do servidor
	$checkup = new Checkup(['pass' => 'index.php', 'notPass' => '']);
	$exam = $checkup->results();
	
	// Usado para trazer informacoes de configuracoes do mini-app
	require '../config/System.model.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
        <meta name="robots" content="noindex, nofollow" />
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="author" content="Yan Gabriel da Silva Machado" />
        
		<title>Checkup &raquo; <?php echo System::NAME;?></title>
		<link rel="stylesheet" type="text/css" href="css/setup.css?v=1" />
	</head>

	<body>
		<div class="container container--main">
			<h1>Instalador <span class="destaque"><?php echo System::NAME;?></span></h1>
			<h3><span class="destaque"><?php echo System::NAME;?></span> - Versão <?php echo System::VERSION['string'];?></h3>

			<h1>Veja abaixo Quais Requisitos do Sistema Não foram Atendidos</h1>
			<h3>Legenda</h3>
			<ul class="list">
				<li class="list-item list-item--green"> <b>Atendido:</b> &#10004;</li>
				<li class="list-item list-item--red"> <b>NÃO Atendido:</b> &#10008;</li>
			</ul>

			<h3>Requisitos Necessários</h3>
			<ul class="list">
			<?php if (!$exam['server']['apache']): ?>
				<li class="list-item list-item--status-red"> Apache</li>
			<?php else: ?>
				<li class="list-item list-item--status-green"> Apache</li>
			<?php endif;?>

			<?php if (!$exam['language']['php']['pdo']): ?>
				<li class="list-item list-item--status-red"> MySql PDO</li>
			<?php else: ?>
				<li class="list-item list-item--status-green"> MySql PDO</li>
			<?php endif;?>

			<?php if (!$exam['language']['php']['version']): ?>
				<li class="list-item list-item--status-red"> PHP >= <?php echo $checkup->getPHPRequiredVersion(); ?></li>
			<?php else: ?>
				<li class="list-item list-item--status-green"> PHP >= <?php echo $checkup->getPHPRequiredVersion(); ?></li>
			<?php endif;?>
			</ul>
			
			<button class="button button--reload">Recarregar Página</button>
		</div>
		
		<script src="js/setup.js?v=1"></script>
	</body>
</html>