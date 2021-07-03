## Copiar um arquivo do desktop para o servidor

Abrir a pasta Scripts e acessar o terminal

scp -P 65522 install.sh ribafs@165.232.148.216:/home/ribafs

Executar no servidor, na apsta /home/ribafs para instalar o LAMP

sudo sh install.sh

Uma opção confortável é conectar ao servidor com o gerenciador de arquivos nemo/nautilus ou outro com suporte. No Windows pode usar o FileZilla

