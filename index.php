<?php
require_once 'core/init.php';

// Usa o método estático 'get' da classe 'Config' para obter o valor associado à chave 'mysql/host' do array de configuração
// Nesse exemplo, ele tenta buscar o valor da chave 'host' dentro de 'mysql' na configuração global
//echo Config::get('mysql/host/'); // Exibe (com echo) o valor da chave 'host' dentro de 'mysql', por exemplo, '127.0.0.1'

//DB::getInstance();

/*$user = DB::getInstance()->get('users',array('username','=','jose'));

if($user->count()){
    echo "User found";
}else{
    echo "User not found";
}
*/

/*$user = DB::getInstance()->insert('users',array(
    'username' => 'josejr',
    'password' => '123',
    'salt' => 'salt',
    'group' => '2'
));*/

$user = DB::getInstance()->update('users',2,array(
    'username' => 'josejr',
    'password' => 'chauque',
));