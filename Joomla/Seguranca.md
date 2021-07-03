# Seguranca na web

https://github.com/ribafs/seguranca

Segurança

Vulnerabilidade de Extensões

http://docs.joomla.org/Vulnerable_Extensions_List

Exploits em Geral
http://www.milw0rm.com/

Antes de instalar extensões de terceiros seria recomendado varrer estes sites para ver se o que estamos entregando ao cliente não está furado.

Dicas de segurança:

1) Escolher o melhor Host do mercado, não o mais barato;
2) Arquivos usam permissão 0644 e diretórios 0755;
3) Utilizar sempre a última versão do CMS e das extensões;
4) Instalar extensões conhecidas, que possuam um bom "core" de desenvolvimento; e
5) Ter a convicção de que não existe sistema seguro, a diferença está no tempo de resposta.

Com relação aos ataques em sites usando Joomla:
O Joomla possui uma equipe que em 4 horas consegue lançar uma versão estável do produto após uma invasão.

A maioria dos ataques ocorre pelo fato dos arquivos estarem com 777 ou usuário instalou componentes "não confiaveis".

Existe o Security Strike no Joomla! que cuida somente deste assunto
http://www.semecd.com.br/portal/index.php?option=com_newsfeeds&view=newsfeed&id=1&feedid=1&Itemid=18

Para verificar sites que foram hackeados/defaced:
http://www.zone-h.org/archive?zh=1

-------------------------


Recomendações sobre segurança

- Usar senhas de no mínimo 6 caracteres. Quanto mais melhor, mas de 8 a 10 tá bom.
- Misturar caracteres alfabéticos maiúsculas, minúsculas, números e caracteres especiais como:
  -, _, *, $, !, %
- Não use senhas fáceis como data de nascimento, número de identidade, nomes de filhos e cônjuges.
- Procure não usar palavras do mundo real
- Pense num eposódio que apenas você conhece ou lembra e forme uma frase com suas iniciais
- Crie senhas posicionais, por exemplo: primeira letra da última fila, primeira letra da primeira fila,
última letra da última fila, última letra da primeira fila e assim por diante.
- Mesmo que ilógicas as senhas devem ser, para você, de fácil memorização, pois você deve evitar anotar as senhas
- Evite usar a mesma senha para todos os esus acessos
- Atualize com uma certa frequeência suas senhas


Segurança no Joomla (parte 1)

Dicas de segurança no joomla.
Muitas pessoas utilizam o CMS Joomla, no entanto a maior parte destas "esquece-se" do fator segurança nos seus sites. Existem pequenos pormenores extremamente fáceis de implementar que aumentarão consideravelmente a segurança do teu site Joomla.

Desligar os relatórios de erro

Um deles é desligar os relatórios de erros, os relatórios de erros alem de diminuírem a velocidade do site indicarão também ao "hackers" falhas na segurança deste. Isto pode ser desativado em 'Configuração Geral -> Sistema'.

Depois de desativada esta função não te será permitido visualizar os erros gerados pelo Joomla, o que é uma coisa boa uma vez que o utilizador comum não os vê (o que não era muito profissional) e os hackers não podem forçar erros de forma a descobrirem métodos de comprometer o sistema.

Utilizar um componente SEF

A maioria dos hackers utilizam o comando 'inurl:' do Google para procurarem por falhas em websites. Uma boa solução para contrariar este potencial risco é instalar um componente que re-escreva os Url, aconselho o SH404SEF ou o Artio-JoomSef.

O componente SEF irá trazer-lhe também bastantes vantagens a nível de SEO (rank mais elevado aos "olhos" do Google).

 
Mover o ficheiro configuration.php para fora da raiz mova simplesmente o ficheiro de configuração para qualquer pasta que você queira dentro do site e atribua-lhe um novo nome. No exemplo utilizei 'joom.conf'.
Crie um novo ficheiro de configuração na raiz com o nome de configuration.php contendo o seguinte código:

<?php
require( dirname( __FILE__ ) . '/../joom.conf' );
?>
Realize backups regulares
Esta tarefa pode ser feita através do Cpanel de qualquer conta de alojamento, no entanto existem também alguns componente muito bons que realizam esta tarefa. O meu favorito é o JoomlaPack. Um backup semanal caso atualize o seu site regularmente é uma boa opção, ou então backups mensais.

 
Não mostrar que versões das extensões utiliza
Em primeiro lugar qualquer admin de um website deveria ter uma lista de todas as extensões que utiliza e fazer o update a estas quando sai-se uma nova versão. No entanto todos nos sabemos que o tempo não chega para tudo e muitas vezes fazer um update a uma extensão pode ser um bocado moroso. É então boa política remover a versão da extensão que utiliza a quando da instalação desta, isto pode ser feito editando os ficheiros da extensão com o notepad por exemplo.

Mudar o prefixo da base de dados (jos_) a maioria dos hack escritos para comprometer um site Joomla, tentaram adquirir informação da tabela jos_users. E desta maneira podem adquirir a password e username do administrador do website. Mudar o nome do prefixo para algo aleatório era impedir a maioria destes ataques, se não todos.

O prefixo pode ser escolhido no momento da instalação de um site Joomla. Se você já instalou o seu site e pretende modificar o prefixo faça o seguinte:
1. Faça o login no painel de administrador do Joomla!.
2. Vá à configuração global e procure por bases de dados
3. Mude o prefixo para qualquer coisa aleatoria (Ex: asfdg_) e guarde.
4. Vá ao phpMyAdmin e aceda à base de dados.
5. Faça export, deixe os valores pré-definidos e faça Start.
6. Selecione todo o codigo e cole no notepad.
7. No phpMyAdmin, selecione todas as tabelas e apage-as.
8. No notepad, faça um Search & replace (Ctrl + H). Com os termos de procura para jos_e mude para o seu novo prefixp (Exemplo: asfdg_). Pressione para substituir todos.
9. Selecione tudo o que estiver no seu notepad. No phpMyAdmin, vá a SQL, e cole as queries.

Em breve traremos mais dicas para deixar seu site em joomla o mais seguro possível.
 
 
Bom, primeiramente dou os meus parabéns para todos os colaboradores deste portal.

Estou a meses procurando algúm material em português que ensina-se a criar templates para o Joomla 1.5.
Felizmente encontrei e por sinal de ótimo conteúdo.

Estou iniciando em Joomla agora neste mês de Fevereiro. Ja fiz muita coisa em meu website, porém as templates que uso não são de minha autoria.

Adorei este website, com certeza será uma grande referência aos iniciantes, principalmente como eu que sou do Rio de Janeiro.

Assim que eu estiver apto e ter criado a minha 1° template farei questão de entrar em contato e disponibilizar versões grátis para que as pessoas que não saibam possam fazer como eu fiz, buscar na internet e utlizar ao menos uma para iniciar seu desenvolvimento.
Muitas das coisas em qeu eu implantei em meu website, eu consegui traduzir, não que eu seja bilingue ou expert. Uso o óbvio, se não sei uso tradutor online mesmo e assim consegui editar muits coisas nos arquivos de configurações dos componentes que utilizei em meu website.

Pesso que se possível entre em contato, pois desejo disponibilizar não só a vocês, mais para todos que precisarem de alguma tradução, porém nem sempre sei onde encontrar o arquivo que eu editei dentro de meu servidor. Meu website não é localhost (talvez use agora, devido as coisas que irei aprender nas videos aulas).

Mais uma vez agradeço por disponibilizare m todo este conteúdo para nós iniciantes. Principalmente os recursos de segurança.
descritos nesta página. 


Segunda parte

Dando continuidade aos nossos artigos sobre segurança no joomla!, aproveito o espaço deste segundo texto para transcrever abaixo um e-mail muito interessante que recebi de um grupo do yahoo. O  e-mail foi enviado pelo programador Roberto Jonikaites.

INICIO DA TRANSCRIÇÃO

"Olá Bruno, Olá Colegas do curso.

Bom Bruno, vendo as primeiras mensagens do pessoal aí, senti uma forte preocupação com o site dos clientes desses futuros profissionais em Joomla!.

Um site em Joomla! é muito mais do que instalá-lo no servidor, mover alguns módulos de posição, instalar componentes, plugins e pronto! Já temos um site completo, feito em três dias e podemos ganhar mais de mil reais do nosso cliente. 

Sinceramente, pessoal, o Joomla é tão complicado de usar quanto se programar um site do zero. Claro que você não terá mais a necessidade de digitar todas as linhas de código, mas eventuais alterações serão necessárias e é importante saber o que, onde e por que está sendo feita aquela mudança.

Além disso, a segurança é muito importante. Hoje existe uma gama enorme de componentes e módulos para Joomla, mas antes de usarem, perguntem-se: "este componente é seguro?". A maioria das invasões em sites Joomla! é feita através do próprio cms mal configurado ou de seus componentes desatualizados. Experiência própria: é muito mais difícil você contornar uma invasão do que prevenir que ela não aconteça.

Trabalho com o Joomla há mais de três anos, desde a versão 1.0.12, e desde lá já aprendi muito, tomei muito na cabeça e hoje me viro tranqüilo, tanto é que tenho mais de 20 clientes em minha região e todos utilizam o Joomla!, mas a cada nova atualização de componentes, preciso dar atenção a estes sites, pois é a segurança dos dados e informações dos mesmos que estão em jogo.

Por isso minha gente, tenho um sério conselho a dar a vocês: Estudem!

Estudem muito o Joomla, pesquisem sobre servidores web (apache), sobre dicas de segurança no PHP, informações sobre servidores de e-mail, segurança de arquivo, permissões de acesso a pastas e arquivos, etc...

Mostrei apenas o caminho das pedras, agora é Google na veia e tempo e disciplina para estudar. Hoje existem mil vezes mais materiais sobre esse assunto do que quando comecei. Inclusive a maioria mais detalhada e em português, no "meu tempo" os bons artigos e tutoriais eram em inglês.

Este e-mail foi escrito como um alerta aos desavisados, para não saírem por ai usando o Joomla! sem considerar o uso de medidas sobre segurança. 

Isso evitará os seus sites de serem invadidos e assim o indivíduo não vai sair por ai xingando todo mundo em qualquer fórum destinado ao Joomla!, falando mal do sistema para qualquer um que aparecer, alegando que "não é seguro". 

Quem faz o Joomla ser seguro é você".

FIM DA TRANSCRIÇÃO

Escrito por Roberto Jonikaites para o Yahoogrupos – Curso de Design para Joomla! De Bruno Ávila.

Até a próxima.
Este artigo foi encontrado no sitea baixo, que não mais foi encontrado em minha última tentativa de visita:
http://www.joomlarj.com.br/site/index.php?option=com_content&view=article&id=26:seguranca-no-joomla-parte-2&catid=15:seguranca-no-joomla&Itemid=15


Dica: sempre antes de instalar uma extensão de terceiros, consulta a lista abaixo:
http://docs.joomla.org/Vulnerable_Extensions_List

