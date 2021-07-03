# SFTP

## Alguns comandos do sftp

get 	Copy a file from the remote host to the local computer. -r para enviar recursivamente
put 	Copy a file from the local computer to the remote host. -r para receber recursivamente 
lcd 	Change the directory on the local computer.
lls 	List the contents of the current directory on the local computer.
lmkdir 	Create a directory on the local computer. 
mkdir
lpwd 	Show the present working directory on the local computer. 
pwd 	Show the present working directory on the remote host. 
cd
ls
chmod

## Copiar pastas e recursivamente

Tenho uma pasta no desktop "teste" e dentro dela a pasta "tein".

/home/ribafs/sf/teste

Acesso o servidor com sftp

Preciso criar a pasta teste com o sftp

mkdir teste
Então
put -r /home/ribafs/sf/teste

Ok

## Removendo diretórios com SFTP

Tenho o diretório teste no servidor, com alguns arquivos dentro.

rm teste/*
rmdir teste

Prontinho.
Com a ajuda dos amigos do StackOverflow e SuperUser.com


## Configurações para o FileZilla

Arquivo
Gerenciador de sites
New site - SF
Protocolo - SFTP
Host - frs.sourceforge.net
Porta - 2
Usuário - ribafs
Avançado
Pasta remota padrão - /home/project-web/joomlar/htdocs
Conectar

Host: web.sourceforge.net

Features

    Common web server features are provided, 
    - mod_rewrite, 
    - Server-Side Includes (SSI), 
    - HTTP Basic Auth, and custom error handler support.

    Service usage is not restricted by quotas, ou seja. espaço ilimitado.


Management

To begin using project web, simply upload new content or scripts to your project web space.
Uploads may be performed using SFTP
Until you upload an index page to your project web space, it will redirect to your project's Summary page on SourceForge.


## Usando o sftp para enviar arquivos para o SF

Criar a pasta local "/home/ribafs/sf"
cd /home/ribafs/sf

Copiar no desktop para esta pasta todos os arquivos que desejo enviar para o SF, usando o comando put

sftp ribafs@web.sourceforge.net
Conecta para /home/users/r/ri/ribafs

cd /home/project-web/joomlar/htdocs
put index.html

Levar do desktop para o SF
put /home/ribafs/sf/*
cd ..
chmod 0775 -R htdocs

pwd
ls
Enviar arquivos zip
put /home/ribafs/sf/releases/*zip

Listar os arquivos do desktop, da pasta /home/ribafs/sf
lls
put /home/ribafs/sf

Acessar o site para testar os arquivos enviados

https://joomlar.sourceforge.io

Adicionar arquivos pelo site do SF

Faça login no SF
Acesse o projeto
Clique em Admin
Clique em Files

Então podemos criar pastas (Add Folder)
Criar a pasta Rel_1

## SFTP
User ribafs enviar o arquivo file.zip para a pasta Rel_1 do seu projeto joomlar:

sftp ribafs@frs.sourceforge.net
sftp> cd /home/frs/project/joomlar/Rel_1
sftp> put file.zip
Uploading file.zip to /home/frs/project/joomlar/Rel_1/file.zip
ws                                            100% 1573     1.5KB/s   00:00 

Página de download, onde os usuários podem baixar os arquivos/Files do projeto joomlar
https://sourceforge.net/projects/joomlar/

Quando ele clica em Files
https://sourceforge.net/projects/joomlar/files/

Quando clica em Code
https://sourceforge.net/p/joomlar/code/ci/master/tree/


All file releases should be a single file. 
Multiple files for the same release should be archived together (tar, deb, zip, etc.). 
We recommend using rsync for all uploads over 20 megabytes in size, as rsync allows for resuming canceled or interrupted transfers.


