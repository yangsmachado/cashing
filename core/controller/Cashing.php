<?php

    // Checa se classe ja existe antes de defini-la
    if (!class_exists('Cashing')):
    
    /**
     *
     * Classe Principal do mini-app. Ela representa um controller
     *
     * @version 1.0
     * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
     *
     */
    class Cashing {
        // Receitas
        private $incomes = [];
        
        // Despesas
        private $expenses = [];
        
        public function __construct () {
            // Estabelece uma nova conexao com o Banco de Dados
            $conn = new Connection();
            
            /*
            Array Multidimensional com 3 Niveis (Despesas)
            
            $expenses = [
                'Despesa01' => [
                    'Ano01' => [
                        'Mes01' => 'Valor',
                        'Mes02' => 'Valor',
                        'MesN' => 'Valor',
                    ],
                    
                    'AnoN' => [
                        'MesN' => 'Valor
                    ]
                ],
                
                ...
            ];
            */
            // Carrega as Despesas no array multidimencional
            $this->expenses = FinancialSituation::getExpenses(1, $conn);
            
            
            /*
            Array Multidimensional com 3 Niveis (Receitas)
            
            $incomes = [
                'Receita01' => [
                    'Ano01' => [
                        'Mes01' => 'Valor',
                        'Mes02' => 'Valor',
                        'MesN' => 'Valor',
                    ],
                    
                    'AnoN' => [
                        'MesN' => 'Valor
                    ]
                ],
                
                ...
            ];
            */
            // Carrega as Receitas no array multidimencional
            $this->incomes = FinancialSituation::getIncomes(1, $conn);
            
            
            // Chama a visao adequada
            $view = substr(__FILE__, 0, stripos(__FILE__, 'controller/' . basename(__FILE__))) . 'view/results.php';
            
            require $view;
        }
    }
    
    endif;