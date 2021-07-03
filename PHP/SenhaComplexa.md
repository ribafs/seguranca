# Checar senha complexa com regex

## Requisitos

- 1 algarismo ou mais (\d)
- 8 a 20 dígitos ({8,20})
- 1 símbolo ou mais ([@#\-_$%^&+=§!\?])
- 1 maiúscula ou mais (*[A-Z])
- 1 minúscula ou mais (*[a-z])

$password = 'senha2343A8@';
```php
if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)){
    echo 'A senha não atende aos requisitos: 1 algarismo ou mais, 8 a 20 dígitos, 1 símbolo, 1 maiúscula, 1 imaiúscula';
}else{
    echo 'Senha ok';
}
```

## Uma função
```php
function password_strength_check($password, $min_len = 8, $max_len = 20, $req_digit = 1, $req_lower = 1, $req_upper = 1, $req_symbol = 1) {
    // Build regex string depending on requirements for the password
    $regex = '/^';
    if ($req_digit == 1) { $regex .= '(?=.*\d)'; }              // Match at least 1 digit
    if ($req_lower == 1) { $regex .= '(?=.*[a-z])'; }           // Match at least 1 lowercase letter
    if ($req_upper == 1) { $regex .= '(?=.*[A-Z])'; }           // Match at least 1 uppercase letter
    if ($req_symbol == 1) { $regex .= '(?=.*[^a-zA-Z\d])'; }    // Match at least 1 character that is none of the above
    $regex .= '.{' . $min_len . ',' . $max_len . '}$/';

    if(preg_match($regex, $password)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

print password_strength_check($password, $min_len = 8, $max_len = 20, $req_digit = 1, $req_lower = 1, $req_upper = 1, $req_symbol = 1);
```
## Crédito

https://stackoverflow.com
