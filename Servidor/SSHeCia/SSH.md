# SSH

##Gerar a chave pública no desktop

ssh-keygen -t ed25519 -C "USERNAME@shell.sf.net"

## Mostrar a chave

cat ~/.ssh/id_rsa.pub

Copiar a chave. Selecione e com o botão direito do mouse - Copiar

Vá até este site

https://sourceforge.net/auth/shell_services

Caso exista algo na caixa SSH Public Keys:, remova

E tecle Ctrl+V

Não está liberado atualmene o SSH, mas como está na documentação, seguem exemplos.

Os outros softwares como sftp, scp, etc conectam agora sem senha.

ssh -t ribafs,joomlar@shell.sourceforge.net create

ssh -t ribafs@shell.sourceforge.net create

ssh -t ribafs@shell.sourceforge.net read

Cheguei a acessar algumas vezes mas não mais.

php -v
7.1.24

mysql --version
mysql  Ver 15.1 Distrib 5.5.64-MariaDB, for Linux (x86_64) using readline 5.1

cat /etc/os-release
CentOS 7


cd /home/project-web/joomlar/htdocs/
unzip mydocs.zip

ssh ribafs@git.code.sf.net
/p/joomlar/code

## Host Access Authorization

All SSH-based services at SourceForge.net (including shell service and CVS write access) are provided solely to members of Open Source software development projects hosted on SourceForge.net.

## Interactive Shell Service

Project developers can access an Interactive Shell if they have been granted shell access for the project. The Interactive Shell provides a command line interface that can be used to manage the following:

    Project web content
    Developer web content
    Project uploads

ssh -t USERNAME@shell.sourceforge.net create

ssh -t ribafs@shell.sourceforge.net create

ssh -t USERNAME@shell.sourceforge.net read


