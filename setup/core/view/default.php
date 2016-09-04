<?php
	// Visao Padrao para a instalacao
?>
<form name="setup" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<section<?php echo count($messages['error']['mysql']) > 0 ? ' class="section--error"' : '';?>>
        <h3>Servidor do Banco de Dados <u><span class="destaque">MySql</span></u></h3>

        <?php for ($i = 0, $l = count($messages['error']['mysql']); $i < $l; $i++):?>
        <span class="error">&#10008; <?php echo $messages['error']['mysql'][$i];?></span>
		<?php endfor;?>
		
		<?php if (!empty($messages['error']['fields']['app']['db'])): ?>
		<span class="error">&#10008; <?php echo $messages['error']['fields']['app']['db'];?></span>
		<?php endif;?>

		<div class="container container--field">
			<input id="db-server" type="text" name="db-server" data-error-message="Digite o Nome do Servidor do Banco de Dados" class="field-text required" placeholder="Nome do Servidor. Exemplo: localhost" <?php echo (empty($server['host']) ? '' : 'value="' . $server['host'] . '" ');?>/>
		</div>
		
		
		<div class="container container--field">
			<input id="db-user" type="text" name="db-user" data-error-message="Digite o Usuário do Servidor do Banco de Dados" class="field-text required" placeholder="Usuário MySql" <?php echo (empty($server['user']) ? '' : 'value="' . $server['user'] . '" ');?>/>
		</div>
		
		
		<div class="container container--field">
			<input id="db-password" type="text" name="db-password" class="field-text" placeholder="Senha MySql" />
		</div>
	</section>

	<section>
		<h3>Nome do Banco de Dados <u><span class="destaque"><?php echo System::NAME;?></span></u></h3>
		
		<div class="container container--field">
			<input id="cashing-db" type="text" name="cashing-db" data-error-message="Digite o Nome do Banco de Dados <?php echo System::NAME;?>" class="field-text required" placeholder="Nome do Banco de Dados <?php echo System::NAME;?>" <?php echo (empty($app['db']) ? '' : 'value="' . $app['db'] . '" ');?>/>
		</div>
	</section>

	<button type="submit" class="button">Salvar Configurações e Instalar</button>
</form>