<h1>Módulo de Etiquetas</h1>

**Compatível com a plataforma Magento CE versão 1.6 a 1.9**

[Necessário módulo Gamuza_Utils](https://github.com/gamuzabrasil/gamuza_utils-magento)

Junto com o nosso módulo de fretes, você pode fazer ainda mais.

Imprimir as etiquetas para os seus envios de uma maneira simples e descomplicada. Gerar os relatórios dos Correios em poucos cliques. Tudo funcionando nos padrões dos Correios.

<img src="https://dl.dropboxusercontent.com/s/fu4gj05mct7hqdl/gamuza-etiquetas-box.png" alt="" title="Gamuza Etiquetas - Magento - Box" />

<h2>Instalação</h2>

<img src="https://dl.dropboxusercontent.com/s/pqpp0x62kqov683/sempre-faca-backup.png" alt="" title="Atenção! Sempre faça um backup da sua loja antes de realizar qualquer modificação!" />

**Instalar usando o modgit:**

    $ cd /path/to/magento
    $ modgit init
    $ modgit add gamuza_labels https://github.com/gamuzabrasil/gamuza_labels-magento.git

**Instalação manual dos arquivos**

Baixe a ultima versão aqui do pacote Gamuza_Labels-xxx.tbz2 e descompacte o arquivo baixado para dentro do diretório principal do Magento

<img src="https://dl.dropboxusercontent.com/s/ir2vm6cyo3gl1v8/pos-instalacao.png" alt="Após a instalação, limpe os caches, rode a compilação, faça logout e login." title="Após a instalação, limpe os caches, rode a compilação, faça logout e login." />

<h2>Conhecendo o módulo</h2>

**1 - Ajustes padrões**

Neste painel você pode alterar o logotipo da empresa que será impressa na etiqueta,
ou adicionar uma URL customizada para a geração das etiquetas, etc ...

<img src="https://dl.dropboxusercontent.com/s/50edjhj021rhiu1/gamuza-etiquetas-config-admin-padrao.png" alt="" title="Gamuza Etiquetas - Magento - Configuração no Painel Administrativo - Ajustes padrões" />

**2 - Ajustes para transportadoras**

Você precisa preencher as informações obtidas através dos Correios:

    Número do Contrato,
    Número do Cartão,
    Código da Unidade
    Unidade de Postagem

<img src="https://dl.dropboxusercontent.com/s/o2wsxcshww3ywvx/gamuza-etiquetas-config-admin-transportadoras.png" alt="" title="Gamuza Etiquetas - Magento - Configuração no Painel Administrativo - Ajustes para Transportadoras" />

**3 - Gerenciando intervalos de etiquetas**

Nesse painel você configura os ranges que foram obtidos através dos Correios.

No final de cada item cadastrado, selecione a opção **Gerar objetos** para criar os rastreios (objetos de etiquetas) que serão utilizados pelos pedidos.

*Obs: Os rastreios já são gerados com o código verificador.*

<img src="https://dl.dropbox.com/s/1z76jz169hwrw6k/gamuza-etiquetas-gerando-rastreios.png" alt="" title="Gamuza - Magento - Gerando rastreios" />

**4 - Gerenciando objetos de etiquetas**

Neste painel conseguimos alterar manualmente cada rastreio gerado automaticamente pelo sistema.

<img src="https://dl.dropboxusercontent.com/s/7z13g1oos2sh306/gamuza-etiquetas-gerenciando-objetos-etiquetas.png" alt="" title="Gamuza Etiquetas - Magento - Gerenciando objetos de etiquetas" />

**5 - Gerenciando relatórios de etiquetas**

Para imprimir os relatórios, basta selecionar na mesma tela (Gamuza - Gerenciar Relatórios de Etiquetas)
a opção **Gerar Relatório** e enviar o arquivo para impressora ou Gerar um PDF.

<img src="https://dl.dropboxusercontent.com/s/9dul7ke1g8e7e3s/gamuza-etiquetas-gerando-relatorio.png" alt="" title="Gamuza Etiquetas - Magento - Gerenciando relatórios de etiquetas" />

<img src="https://dl.dropboxusercontent.com/s/8f2oc5rq9ctom36/gamuza-etiquetas-relatorio.png" alt="" title="Gamuza Etiquetas - Magento - Relatório" />

<h2>Geração de Etiquetas</h2>

- Para gerar a etiqueta há 2 formas:

Dentro do pedido no painel administrativo, já faturado, clique no botão **etiqueta**
para utilizar um rastreio gerado anteriormente no painel de etiquetas.

**Clique no botão etiquetas e seleção de rastreio disponível**

<img src="https://dl.dropboxusercontent.com/s/jkjgueci4dcmat0/gamuza-etiquetas-selecao-rastreio-disponivel.png" alt="" title="Gamuza Etiquetas - Magento - Seleção rastreio disponível" />

**Impressão**

<img src="https://dl.dropboxusercontent.com/s/inbo8nlda8qhi8i/gamuza-etiquetas-impressao.png" alt="" title="Gamuza Etiquetas - Magento - Impressão" />

*Ou:*

Acesse: Gamuza -> Gerenciar Relatórios de Etiquetas, marque um pedido
e escolha a opção **Gerar Entregas** (as entregas dos pedidos serão criadas
com os códigos de rastreio já inseridos).

**Gerando entregas automatizadas com o código de rastreio**

*Obs: Para cada entrega será enviado um e-mail de pedido despachado com o código de rastreio.*

<img src="https://dl.dropboxusercontent.com/s/gn5057bzen47p09/gamuza-etiquetas-gerando-entregas.png" alt="" title="Gamuza Etiquetas - Magento - Gerando entregas" />

