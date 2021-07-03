# Segurança na web

Trabelhei por alguns anos administrando servidores linux, também administrei meus servidores VPS algum tempo e durante muitos anos tenho trabalhado com programação com PHP e guardei muitas receitinhas de bolo sobre segurança durante este tempo. Estou trazendo o resultado disso, mas desta vez não tive disposição para converter os txt em markdown. Espero queu ainda assim seja útil aos que procuram por segurança na web.

Me parece que em geral programadores web se comportam como se não tivessem nada com segurança nem com a falta dele. Mas é bom lembrar que ela é ou deveria ser um item do seu trabalho, para que então se torne um diferencial.

Os cuidados com a segurança colaboram para que os sites e aplicativos instalados em servidores sejam executados de forma esperada, rápida e sem interrumpção.

## Princípios e cuidados básicos da segurança

### Os cuidados abaixo se dividem nos voltados para servidores de hospedagem compartilhada e servidores tipo VPS

- Hospede seu site em servidor seguro. Sei que é difícil mas tenha critério e não hospede no mais barato esperando a melhor hospedagem
- Efetue backup regularmente, especialmente a cada alteração no site
	A melhor opção atualmente para backup de site em Joomla/Wordpress é o Akeeba Backup - https://www.akeebabackup.com/download.html
	Caso tenha dificuldade de usar o formato JPA, altere em Configuration - Archiver engine para ZIP format
	Pode usar o Generic Backup (https://github.com/ribafs/generic-backup) para criar backup de um site qualquer
	Faça também backup dos scripts de configuração do servidor para o caso de uma reinstalação e de VPS
	Lembre de fazer o backup do servidor com os recursos da hospedagem ou crie um snapshot (VPS)
- Também faça teste de restore de vez em quando para garantir que o backup está integro
- A quantidade de cópias de backup a ser guardada depende da importância do site. Se mais importante mais cópias
- As cópias devem ser armazenadas em mídia confiável: HD, DVD ou pendrive
- Efetue atualização com frequência (VPS). Mantenha o aviso de atualização ativo para que receba um aviso por e-mail e atualize imediatamente
- Após a primeira atualização reinicie o servidor (VPS)
- Acessar de forma segura usando SSH (enxuto e configurado para salvar a senha) e nunca via FTP (VPS)
- Manter seu desktop seguro, usando um sistema operacional seguro no mesmo, com firewall e outros cuidados
- Use e abuse da comunidade com seus conhecimentos e generosidade para manter-se atualizado em termos de segurança e proteger seu site
- Use senhas fortes
- Cuidados com a configuração no php.ini. Usar o phpsecinfo para ajudar
- Cuidados para proteger contra SQL injections e contra ataques de XSS. Sempre use PDO nas suas conexões
- A aplicação foi projetada com segurança em mente?
- Atente para o tratamento de erros com try/catch
- Use o SSL para proteger seu site
- Use boas extensões para reforçar a segurança, no caso do Joomla e Wordpress ou outro CMS
- Remova todas as extensões que não estiver usando e não somente desabilite Joomla e (Wordpress ou outro CMS)
- Evite instalar pacotes para desenvolvimento como gcc, make, etc e evite também instalar repositórios instáveis.
- Monitorar frequentemente os logs à procura de algo suspeito em todos os serviços ativos (linux)
- Use softwares tipo IDS que detectam intrusões (VPS)
- Instalar um bom firewall de aplicativos como o mod_security (VPS)
- Ficar bem atento, estudando, se informando sempre sobre o assunto de que cuida
- Logo após a configuração final do servidor já crie um backup ou snapshot e fique atento para criar outro logo que o servidor esteja concluído e bem configurado. (VPS)
- Uma boa ideia é ter uma box no Vagrant com a distribuição e versão do servidor em seu desktop
- Filtrar todas as entradas e escapar as saídas
- Não confiar nos cookies.  Não usar em áreas sensíveis de aplicativos
- Limitar no banco os privilégios de cada usuário da aplicação. Geralmente quando se instala um CMS no Cpanel se consede todos os privilégios ao usuário criado, quando não há necessidade
- Evite acesso remoto ao banco. Se permitir filtre o IP
- E sempre usar prepared statments nas consultas
- Não deixar arquivo de configuração do banco de dados no raiz
- Não fechar o php ao final do arquivo (tag ?> de fechamento), caso esteja usando somente PHP no mesmo.
Fechar somente se estiver misturando HTML com PHP
- Usar sempre HTTPS. Se num VPS use o lets encrypt - https://letsencrypt.org/
- Usar password_hash() para proteger as senhas. Não requer definição de salt. Usa bluefish por padrão
- Use filter_var()
- Monitorar logs
- Manter php atualizado
- Use frameworks
- Cuide da segurança física dos servidores
- Cuidar das permissões do sistema de arquivos
- Cuidado Injeção CSS 
Arquivos CSS que contenham 
expression()
url()
metodos específicos

## Tools
https://beefproject.com/
https://chrome.google.com/webstore/detail/bishop-vulnerability-scan/cbkdeoaaclnbidadjimofnhpbfhjakoe
http://sqlmap.org/
https://webgoat.github.io/WebGoat/

- E use alguns softwares que reforçam a segurança como:
fail2ban
denyhosts
lynis
rhhunter
mod_evasive
...

## Referências

https://geek.linuxman.pro.br/geek/ubuntu-pronto-para-guerra
https://www.thefanclub.co.za/how-to/how-secure-ubuntu-1604-lts-server-part-1-basics 
https://linux-audit.com/ubuntu-server-hardening-guide-quick-and-secure/
https://hostpresto.com/community/tutorials/how-to-install-and-use-lynis-on-ubuntu-14-04/


## Outras dicas importantes

[PHPFiltros.txt](PHPFiltros.txt)

[phpini.txt](phpini.txt)

[SanitizeDBInputs.md](SanitizeDBInputs.md)

[seguranca.md](seguranca.md)

[usando_password_verify.txt](usando_password_verify.txt)

[Apostila sobre Segurança na web com 40 páginas](seguranca_web.pdf)
