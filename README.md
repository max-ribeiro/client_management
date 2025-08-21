# Tecnologias principais
- PHP 8.4
- Laravel 12
- MySql 8
- Node 20
# Getting Started
## 1. Configurações de ambiente(.env)
Para adicionar o arquivo .env ao projeto, podemos renomear o arquivo **.env.example**, caso esteja na pasta do projeto usando o terminal, executar o comando: `cp .env.example .env`
## 2. Docker
baixar o docker https://docs.docker.com/engine/install/
acessar o diretorio do projeto e executar o
comando `docker compose up -d` que vai prepara e executar os containeres do projeto

> comando: docker compose -d

3 containeres serão criados:
- max-app 
- max-mysql
- max-node

```
docker exec -it max-app bash
```
e depois execute os comandos
 ``` bash
php artisan key:generate
```

 ``` bash
php artisan migrate`
```

``` bash
php artisan jwt:secret
```

Com isso ja sera possivel utilizar a API e acessar o Front-end da aplicação

# API - Criando um novo usuario
Para utilizar tanto o **app front-end** quanto a **API**, precisamos criar um usuario que vai se autenticar usando JWT, para isso faça uma requisição do tipo `POST` para a rota http://localhost:8000/api/auth/register contendo o seguinte payload:
``` json
{
    "name":"usernam",
    "email":"user@email.com",
    "password":"secret123"
}
```
Retornando assim o token para enviarmos no header das requisições. O usuario registrado aqui pode ser utilizado para logar no app frontend.

Outras requisições podem ser vistas nas
Collections do POSTMan

Drive: https://drive.google.com/file/d/1qVZj_1hwl7szAxqAMlnQVUJuuZ7E-oDR/view?usp=sharing

https://.postman.co/workspace/Personal-Workspace~3652d823-c286-414e-925d-4aa36f43f895/collection/8513761-3d36e437-8c69-4d6d-95b1-609016c2f50e?action=share&creator=8513761

# Aplicação Front-end Web
Caso os serviços do docker estejam ativos, basta acessar o endereço `localhost:8000/`
Faça login com o usuario criado via API