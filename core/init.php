<?php
session_start();

// Configurações globais armazenadas no array $GLOBALS['config']
$GLOBALS['config'] = array(
    
    // Configurações de conexão com o banco de dados MySQL
    'mysql' => array(
        'host' => '127.0.0.1',    // Endereço do servidor MySQL (localhost)
        'username' => 'root',     // Nome de usuário do banco de dados
        'password' => '',         // Senha do banco de dados (vazia neste caso)
        'db' => 'udemy'              // Nome do banco de dados
    ),
    
    // Configurações para lembrar o usuário (cookie)
    'remember' => array(
        'cookie_name' => 'hash',  // Nome do cookie para lembrar o usuário
        'cookie_expiry' => 604800 // Tempo de expiração do cookie (em segundos, 7 dias)
    ),
    
    // Configurações de sessão
    'session' => array(
        'session_name' => 'user'  // Nome da sessão usada para identificar o usuário logado
    )
);

// Função para carregar automaticamente classes PHP quando necessárias
spl_autoload_register(function($class) {
    require_once 'classes/' . $class . '.php'; // Carrega a classe automaticamente da pasta 'classes'
});

// Inclui o arquivo de funções de sanitização de dados
require_once 'functions/sanitize.php'; // Importa funções de sanitização de entradas (evita injeção de código, etc.)
