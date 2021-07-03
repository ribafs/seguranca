# Restringir informações mostradas do Apache

## Lembrar de ativar o módulo headers e depois reiniciar o apache

a2enmod headers

## Edite

sudo nano /etc/apache2/conf-available/security.conf

Mude desta forma alguns parâmetros:
```bash
ServerTokens Prod
ServerSignature Off
Header unset ETag
Header always unset X-Powered-By
FileETag None
```
Reiniciar o apache

sudo service apache2 restart

