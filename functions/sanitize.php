<?php
// Função chamada 'escape' que recebe um valor ($value) como parâmetro
function escape($value){
    
    // A função 'htmlentities' converte caracteres especiais em suas representações HTML
    // ENT_QUOTES: Converte tanto aspas simples quanto aspas duplas para suas entidades HTML correspondentes
    // 'UTF-8': Define a codificação de caracteres para UTF-8 (uma codificação amplamente utilizada na web)
    // Retorna o valor convertido para ser seguro em HTML, prevenindo injeções de código ou XSS
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
}
