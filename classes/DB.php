<?php
class DB
{
    // Propriedade estática para armazenar uma instância única (Singleton)
    private static $_instance = null;

    // Propriedades privadas da classe
    private $_pdo;         // Armazena a instância da conexão PDO
    private $_query;       // Armazena a última query SQL executada
    private $_error = false; // Armazena o estado de erro após a execução de uma query
    private $_results;     // Armazena os resultados da query executada
    private $_count = 0;   // Armazena o número de registros retornados pela query

    // Construtor privado: responsável por estabelecer a conexão com o banco de dados
    // É privado para impedir que a classe seja instanciada diretamente de fora (padrão Singleton)
    private function __construct()
    {
        try {
            // Cria uma nova instância da classe PDO para a conexão com o banco de dados MySQL
            // Utiliza a configuração global definida na classe Config
            $this->_pdo = new PDO(
                'mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'),
                Config::get('mysql/username'),
                Config::get('mysql/password')
            );
        } catch (PDOException $e) {
            // Se ocorrer um erro na conexão, exibe a mensagem de erro e encerra o script
            die($e->getMessage());
        }
    }

    // Método estático 'getInstance' para implementar o padrão Singleton
    // Garante que apenas uma instância da classe DB seja criada e reutilizada
    public static function getInstance()
    {
        // Verifica se a instância da classe DB já foi criada
        if (!isset(self::$_instance)) {
            // Se não, cria uma nova instância
            self::$_instance = new DB();
        }
        // Retorna a instância da classe (a mesma instância sempre que for chamada)
        return self::$_instance;
    }

    // Método público 'query' para executar uma query SQL
    public function query($sql, $params = array())
    {
        // Inicializa o erro como 'false', assumindo que não haverá erros
        $this->_error = false;

        // Prepara a query SQL usando PDO
        // Se a preparação for bem-sucedida, continua
        if ($this->_query = $this->_pdo->prepare($sql)) {
            // Variável auxiliar para contagem dos parâmetros
            $x = 1;

            // Se houver parâmetros na query (evitar SQL injection)
            if (count($params)) {
                // Para cada parâmetro, faz o bind (ligação) com a query
                foreach ($params as $param) {
                    // Vincula o valor do parâmetro à query preparada
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            // Executa a query
            if ($this->_query->execute()) {
                // Se a execução for bem-sucedida, armazena os resultados como objetos
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                // Armazena o número de linhas retornadas
                $this->_count = $this->_query->rowCount();
            } else {
                // Se houver erro na execução da query, define o erro como 'true'
                $this->_error = true;
            }
        }

        // Retorna o objeto da própria classe, permitindo encadeamento de métodos
        return $this;
    }
    
    private function action($action, $table, $where = array()) {
        // Verifica se o array $where possui exatamente 3 elementos
        if (count($where) === 3) {
            // Define os operadores permitidos para comparação
            $operators = array('=', '>', '<', '>=', '<=');
    
            // Atribui os elementos de $where para variáveis locais
            $field    = $where[0]; // Campo da tabela
            $operator = $where[1]; // Operador de comparação
            $value    = $where[2]; // Valor a ser comparado
    
            // Verifica se o operador fornecido é válido
            if (in_array($operator, $operators)) {
                // Constrói a query SQL dinamicamente
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
    
                // Executa a query e verifica se há erros
                if (!$this->query($sql, array($value))->error()) {
                    // Retorna a própria instância em caso de sucesso (padrão Fluent Interface)
                    return $this;
                }
            }
        }
    
        // Retorna false caso as condições não sejam satisfeitas
        return false;
    }
    
    public function get($table, $where) {
        // Método que chama 'action' para fazer uma consulta SELECT
        return $this->action('SELECT *', $table, $where);
    }
    
    public function delete($table, $where) {
        // Método que chama 'action' para fazer uma consulta DELETE
        return $this->action('DELETE', $table, $where);
    }

    public function result(){
        return $this->_results;
    }
    
    // Método público 'error' para retornar o estado de erro
    public function error()
    {
        // Retorna o valor da variável $_error (true ou false)
        return $this->_error;
    }

    public function count(){
        return $this-> _count;
    }

}
