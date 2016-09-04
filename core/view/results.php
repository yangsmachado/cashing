<?php
    /*
    
    Carrega os dados vindos do banco nas tabelas correspondentes (Receitas e Despesas)
    
    */
    function tableContentOfExpensesOrIncomes (array $data): string {
        $content = '';
        
        // Cria um array com informacoes para permitir a aplicacao dos rowspans nas Tabelas [INICIO]
        $rowspans =  [];
        foreach ($data as $d=>$years) {
            // Armazena a quantidade de rowspan que sera usada para o dado
            $e = 0;
            
            // Armazena para os Anos
            $temp = [];
            
            foreach ($years as $year=>$months) {
                // Armazena a quantidade de rowspan que sera usada para o dado
                $y = 0;
                foreach ($months as $month=>$value) {
                    $e++;
                    $y++;
                }
                
                $temp[] = $y; 
            }
            
            $rowspans[] = [
                $e,
                $temp
            ];
        }
        // Cria um array com informacoes para permitir a aplicacao dos rowspans nas Tabelas [FIM]

        
        // Constroi as linhas e colunas das tabelas aplicando os rowspans [INICIO]
        $i = $k = $sum = 0;
        
        // $isFirstRowWithData -> Data pode ser Receita ou Despesa
        $isFirstRowWithData = $isFirstRowWithYear = true;
        
        foreach ($data as $d=>$years) {
            $isFirstRowWithData = true;
            
            foreach ($years as $year=>$months) {
                $isFirstRowWithYear = true;
                
                foreach ($months as $month=>$value) {
                    $tempData = '';
                    if ($isFirstRowWithData) {
                        $tempData = '<td rowspan="' . $rowspans[$i][0] . '">' . $d . '</td>';
                        $isFirstRowWithData= false;
                    }
                    
                    $tempYear = '';
                    if ($isFirstRowWithYear) {
                        $tempYear = '<td rowspan="' . $rowspans[$i][1][$k] . '">' . $year . '</td>';
                        $isFirstRowWithYear = false;
                    }
                    
                    $content .= '<tr>' . $tempData . $tempYear . '<td>' . $month . '</td><td>' . str_replace('.', ',', $value) . '</td></tr>';
                    
                    $sum += $value;
                }
                
                $k++;
            }
            
            $i++; $k=0;
        }
        // Constroi as linhas e colunas das tabelas aplicando os rowspans [FIM]
        
        return $content .'<tr><td colspan="3">Total (Todos Meses e Anos)</td><td>' . str_ireplace('.', ',', $sum) . '</td></tr>';
    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <!-- Motores de Busca [INICIO] -->
        <meta name="robots" content="index, follow" />
        <meta name="description" content="Protótipo de um Sistema para Controle de Finanças Pessoais" />
        <meta name="keywords" content="Prova Remota, cashing, descontar, cash, dinheiro, finanças, yan gabriel, yan gabriel da silva machado, yangsmachado" />
        <meta name="author" content="Yan Gabriel da Silva Machado" />
        <!-- Motores de Busca [FIM] -->
        
        <!-- Configuracoes da Pagina [INICIO] -->
        <meta charset="<?php echo System::CHARSET;?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Receitas e Despesas &raquo; Cashing</title>
        <link rel="stylesheet" type="text/css" href="css/core.css?v=1" />
        <!-- Configuracoes da Pagina [FIM] -->
    </head>
    
    <body>
        <h1>Receitas e Despesas do Usuário Yan Gabriel nos Últimos Anos</h1>
        
        <?php if (count($this->incomes) > 0): ?>
        <!-- Receitas [INICIO] -->
        <div class="table-wrapper">
            <h1>Receitas</h1>
            <table>
                <tr class="tr--blue">
                    <th>Receita</th>
                    <th>Ano</th>
                    <th>Mês</th>
                    <th>Valor (R$)</th>
                </tr>
                
                <?php echo tableContentOfExpensesOrIncomes($this->incomes);?>
                
            </table>
        </div>
        <!-- Receitas [FIM] -->
        <?php endif;?>
        
        
        <?php if (count($this->expenses) > 0): ?>
        <!-- Despesas [INICIO] -->
        <div class="table-wrapper">
            <h1>Despesas</h1>
            <table>
                <tr class="tr--red">
                    <th>Despesa</th>
                    <th>Ano</th>
                    <th>Mês</th>
                    <th>Valor (R$)</th>
                </tr>
                
                <?php echo tableContentOfExpensesOrIncomes($this->expenses);?>
                
            </table>
        </div>
        <!-- Despesas [FIM] -->
        <?php endif;?>
    </body>
</html>