<?php

    // Checa se classe ja existe antes de defini-la
    if (!class_exists('FinancialSituation')):
    
    /**
     *
     * Recupera informações do Banco de dados para que sejam exibidas na View results.php
     *
     * @version 1.0
     * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
     *
     */
    class FinancialSituation {
        const EXPENSE = 'expense';
        const INCOME = 'income';
        
        /**
         *
         * Retorna uma string que representa o mes a partir de um inteiro
         *
         * @var $month int 
         * 
         */
        private static function getMonthName (int $month): string {
            switch ($month) {
                case 1: $month = 'Janeiro';
                    break;
                case 2: $month = 'Fevereiro';
                    break;
                case 3: $month = 'Março';
                    break;
                case 4: $month = 'Abril';
                    break;
                case 5: $month = 'Maio';
                    break;
                case 6: $month = 'Junho';
                    break;
                case 7: $month = 'Julho';
                    break;
                case 8: $month = 'Agosto';
                    break;
                case 9: $month = 'Setembro';
                    break;
                case 10: $month = 'Outubro';
                    break;
                case 11: $month = 'Novembro';
                    break;
                case 12: $month = 'Dezembro';
                    break;
            }
            
            return $month;
        }
        
        /**
         *
         * Retorna as Receitas ou Despesas de um Usuario
         *
         * @var $type String Pode ser as constantes INCOME ou EXPENSE
         * @var $userId int Identificador do Usuario
         * @var $conn PDO Link da Conexao
         * 
         */
        private static function getData (string $type, int $userID, PDO $conn): array {
            $data = [];
            $sql = '';
            
            if ($type === self::EXPENSE) {
                $sql = 'SELECT b.name AS `expense`, a.year, a.month, a.value FROM users__expenses a INNER JOIN expenses b ON a.expense_id=b.id WHERE a.user_id=' . $userID . ' ORDER BY `expense`, `year`, `month`;';
            } else if ($type === self::INCOME) {
                $sql = 'SELECT b.name AS `income`, a.year, a.month, a.value FROM users__incomes a INNER JOIN incomes b ON a.income_id=b.id WHERE a.user_id=' . $userID . ' ORDER BY `income`, `year`, `month`;';
            } else {
                return [];
            }
            
            
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                
                if ($stmt->rowCount() > 0) {
                    foreach ($stmt->fetchAll() as $row) {
                        if (array_key_exists($row[$type], $data)) {
                            if (array_key_exists($row['year'], $data[$row[$type]])) {
                                // Insere MES e VALOR dentro do array Ano
                                $data[$row[$type]][$row['year']][self::getMonthName((int)$row['month'])] = $row['value'];
                            } else {
                                // Insere MES, VALOR e ANO dentro do array Despesas
                                $data[$row[$type]][$row['year']][self::getMonthName((int)$row['month'])] = $row['value'];
                            }
                        } else {
                            // Insere MES, VALOR, ANO E DESPESA dentro do array Despesas
                            $data[$row[$type]][$row['year']][self::getMonthName((int) $row['month'])] = $row['value'];
                        }
                    }
                }
            }
            
            return $data;
        }
        
        
        /**
         *
         * Retorna as Despesas de um Usuario
         *
         * @var $userId int Identificador do Usuario
         * @var $conn PDO Link da Conexao
         * 
         */
        public static function getExpenses (int $userID, PDO $conn): array {
            return self::getData(self::EXPENSE, $userID, $conn);
        }
        
        
        /**
         *
         * Retorna as Receitass de um Usuario
         *
         * @var $userId int Identificador do Usuario
         * @var $conn PDO Link da Conexao
         * 
         */
        public static function getIncomes (int $userID, PDO $conn): array {
            return self::getData(self::INCOME, $userID, $conn);
        }
    }
    
    endif;