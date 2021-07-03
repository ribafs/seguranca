# Permissões no /var/www/html

Atualmente a melhor solução que encontrei para deixar as permissões no /var/www/html ajustadas para os softwares web, foi a criação do script abaixo

sudo nano /usr/local/bin/perms

Veja que adiciono o user administrador ao www-data
```bash
#!/bin/sh
# sudo adduser ribafs www-data
clear;
echo "Aguarde enquanto configuro as permissões do /var/www/html/$1";
echo "";
find /var/www/html/$1/ -type d -exec chmod 775 {} \;
find /var/www/html/$1/ -type d -exec chmod ug+s {} \;
find /var/www/html/$1/ -type f -exec chmod 664 {} \;
chown -R ribafs:www-data /var/www/html/$1/
echo "";
echo "Concluído!";
```
## Usando para varrer a pasta /var/www/html/joomla

sudo perms joomla

## Usando para varrer toda a pasta /var/www/html

sudo perms



