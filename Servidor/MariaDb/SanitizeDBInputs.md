# Sanitize Database Inputs

https://css-tricks.com/snippets/php/sanitize-database-inputs/

Antes de armazenar dados de formulário no banco use a função sanitize abaixo com

  $_POST = sanitize($_POST);

  $_GET  = sanitize($_GET);

Ou qualquer outra entrada com:

$limpo = sanitize($input);

## Função para stripping e remover bits maliciosos
```php
<?php
function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
  }
?>
```
## Função de Sanitização
```php

<?php
function escape($value) {
    $return = '';
    for($i = 0; $i < strlen($value); ++$i) {
        $char = $value[$i];
        $ord = ord($char);
        if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
            $return .= $char;
        else
            $return .= '\\x' . dechex($ord);
    }
    return $return;
    // https://www.it-swarm.dev/pt/php/alternativa-ao-mysql-real-escape-string-sem-conectar-ao-db/967389299/
}

function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = escape($input);
    }
    return $output;
}
?>
```
## Usando
```php
<?php
  $bad_string = "Hi! <script src='http://www.evilsite.com/bad_script.js'></script> It's a good day!";
  $good_string = sanitize($bad_string);
  // $good_string returns "Hi! It\'s a good day!"

  // Also use for getting POST/GET variables
  $_POST = sanitize($_POST);
  $_GET  = sanitize($_GET);
?>
```
