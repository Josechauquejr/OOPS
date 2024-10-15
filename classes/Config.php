<?php
class Config {
    // Método estático 'get' que busca um valor de configuração com base em um caminho fornecido
    public static function get($path = null) {
        
        // Verifica se um caminho foi fornecido
        if($path) {
            
            // Obtém o array de configuração global
            $config = $GLOBALS['config'];
            
            // Divide o caminho fornecido em partes (separadas por '/')
            // Isso permite acessar configurações aninhadas (subarrays)
            $path = explode('/', $path);

            // Itera sobre cada parte do caminho (subarrays ou chaves)
            foreach($path as $bit) {
                
                // Verifica se a parte atual ($bit) existe no array de configuração
                if(isset($config[$bit])) {
                    
                    // Se existir, redefine $config para o valor correspondente àquela chave
                    $config = $config[$bit];
                }
            }

            // Retorna o valor final encontrado na configuração
            return $config;
        }

        // Se nenhum caminho for fornecido ou o caminho não existir, retorna 'false'
        return false;
    }
}
