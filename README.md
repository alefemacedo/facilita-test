# Facilita Test

Prova prática de desenvolvedor PHP da Facilita

- O arquivo model.mdj contém o MER da base de dados; este pode ser aberto com o Star UML

## Client

### Dependências
- NodeJS
- Npm

### Estrutura do projeto client
- src/api: Arquivos com chamadas da API
- src/views: Views da aplicação
- src/components: Components de uso geral em views e outros components
- src/router/index.js: Arquivo com as rotas da aplicação
- src/utils/request.js: Arquivo com a configuração do service do Axios para chamadas AJAX

### Instalar as dependências do projeto
- npm install

### Rodar o servidor node
- npm run serve

## API

### Dependências
- PHP7
- MySql
- Composer

### Estrutura do projeto da API
- app/Models: Classes Model
- app/Http/Controllers: Classes Controller que recebem as requisições
- app/Services: Classes Service para executar as regras de negócio e interações com o banco de dados
- routes/web.php: Arquivo de rotas da API
- database/migrations: Arquivos de migrations para criação da estrutura do banco de dados

### Instalar dependências do projeto
- composer install

### Configurações do banco de dados
- cp .env.example .env
- Configure dentro do arquivo .env os dados necessários para conexão com o banco de dados

### Rode o servidor PHP
- php -S localhost:8080 -t public/