# OpenSSL

Criptografar um arquivo texto ou tar. O arquivo é criptografado com uma senha e quem a conhecer poderá descriprografar

## Criptografar o arquivo.txt para arquivo.aes

openssl aes-128-cbc -salt -in arquivo.txt -out arquivo.aes

## Descriptografar o arquivo.aes para arquivo.txt

openssl aes-128-cbc -d -salt -in arquivo.aes -out arquivo.txt


## Empacotar com tar e criptografar todo um diretório

tar -cf - pasta | openssl aes-128-cbc -salt -out pasta.tar.aes

## Desempacotar e descriptografar

openssl aes-128-cbc -d -salt -in pasta.tar.aes | tar -x -f -


## Empacotar e zipar todo um diretório  criptografar

tar -zcf - pasta | openssl aes-128-cbc -salt -out pasta.tar.gz.aes

## Deszipar e descriptografar

openssl aes-128-cbc -d -salt -in pasta.tar.gz.aes | tar -xz -f -

Use -k senha após aes-128-cbc para evitar a requisição interativa da senha

Use aes-256-cbc ao invés de aes-128-cbc para ter uma criptografia mais forte, mas exigirá mais CPU


## GPG

O arquivo é criptografado com uma senha e quem a conhecer poderá descriprografar

GPG adiciona uma extensão .gpg ao arquivo criptografado

## Criptografar o arquivo file

gpg -c file

## Descriptografar

gpg file.gpg

## Usando chaves

gpg --gen-key

Isso pode demorar
```bash
~/.gnupg/pubring.gpg                 # Contains your public keys and all others imported
~/.gnupg/secring.gpg                 # Can contain more than one private key
```
## Opções mais usadas
```bash
-e encrypt data
-d decrypt data
-r NAME encrypt for recipient NAME (or 'Full Name' or 'email@domain')
-a create ascii armored output of a key
-o use as output file
```
## Criptografia apenas para uso pessoal

gpg -e -r 'Your Name' file                  # Encrypt with your public key

gpg -o file -d file.gpg                     # Decrypt. Use -o or it goes to stdout

## Criptografar e Descriptografar com chave
```bash
gpg -a -o alicekey.asc --export 'Alice'     # Alice exported her key in ascii file.
gpg --send-keys --keyserver subkeys.pgp.net KEYID   # Alice put her key on a server.
gpg --import alicekey.asc                   # You import her key into your pubring.
gpg --search-keys --keyserver subkeys.pgp.net 'Alice' # or get her key from a server.
```
Logo que a chave é importada fica fácil de criptografar e descriptografar
```bash
gpg -e -r 'Alice' file                      # Encrypt the file for Alice.
gpg -d file.gpg -o file                     # Decrypt a file encrypted by Alice for you.
```
## Administração de chaves

Key administration
```bash
# gpg --list-keys                             # list public keys and see the KEYIDS
    The KEYID follows the '/' e.g. for: pub   1024D/D12B77CE the KEYID is D12B77CE
# gpg --gen-revoke 'Your Name'                # generate revocation certificate
# gpg --list-secret-keys                      # list private keys
# gpg --delete-keys NAME                      # delete a public key from local key ring
# gpg --delete-secret-key NAME                # delete a secret key from local key ring
# gpg --fingerprint KEYID                     # Show the fingerprint of the key
# gpg --edit-key KEYID                        # Edit key (e.g sign or add/del email)
```

OpenSSL


Criptografar um arquivo texto ou tar. O arquivo é criptografado com uma senha e quem a conhecer poderá descriprografar

Criptografar o arquivo.txt para arquivo.aes

openssl aes-128-cbc -salt -in arquivo.txt -out arquivo.aes

Descriptografar o arquivo.aes para arquivo.txt
openssl aes-128-cbc -d -salt -in arquivo.aes -out arquivo.txt


Empacotar com tar e criptografar todo um diretório

tar -cf - pasta | openssl aes-128-cbc -salt -out pasta.tar.aes

Desempacotar e descriptografar

openssl aes-128-cbc -d -salt -in pasta.tar.aes | tar -x -f -


Empacotar e zipar todo um diretório  criptografar

tar -zcf - pasta | openssl aes-128-cbc -salt -out pasta.tar.gz.aes

Deszipar e descriptografar

openssl aes-128-cbc -d -salt -in pasta.tar.gz.aes | tar -xz -f -

Use -k senha após aes-128-cbc para evitar a requisição interativa da senha
Use aes-256-cbc ao invés de aes-128-cbc para ter uma criptografia mais forte, mas exigirá mais CPU


GPG

O arquivo é criptografado com uma senha e quem a conhecer poderá descriprografar

GPG adiciona uma extensão .gpg ao arquivo criptografado

Criptografar o arquivo file
gpg -c file

Descriptografar
gpg file.gpg

Usando chaves
gpg --gen-key

Isso pode demorar

~/.gnupg/pubring.gpg                 # Contains your public keys and all others imported
~/.gnupg/secring.gpg                 # Can contain more than one private key

Opções mais usadas

-e encrypt data
-d decrypt data
-r NAME encrypt for recipient NAME (or 'Full Name' or 'email@domain')
-a create ascii armored output of a key
-o use as output file

Criptografia apenas para uso pessoal

gpg -e -r 'Your Name' file                  # Encrypt with your public key
gpg -o file -d file.gpg                     # Decrypt. Use -o or it goes to stdout

Criptografar e Descriptografar com chave

gpg -a -o alicekey.asc --export 'Alice'     # Alice exported her key in ascii file.
gpg --send-keys --keyserver subkeys.pgp.net KEYID   # Alice put her key on a server.
gpg --import alicekey.asc                   # You import her key into your pubring.
gpg --search-keys --keyserver subkeys.pgp.net 'Alice' # or get her key from a server.

Logo que a chave é importada fica fácil de criptografar e descriptografar

gpg -e -r 'Alice' file                      # Encrypt the file for Alice.
gpg -d file.gpg -o file                     # Decrypt a file encrypted by Alice for you.

Administração de chaves

Key administration

# gpg --list-keys                             # list public keys and see the KEYIDS
    The KEYID follows the '/' e.g. for: pub   1024D/D12B77CE the KEYID is D12B77CE
# gpg --gen-revoke 'Your Name'                # generate revocation certificate
# gpg --list-secret-keys                      # list private keys
# gpg --delete-keys NAME                      # delete a public key from local key ring
# gpg --delete-secret-key NAME                # delete a secret key from local key ring
# gpg --fingerprint KEYID                     # Show the fingerprint of the key
# gpg --edit-key KEYID                        # Edit key (e.g sign or add/del email)


