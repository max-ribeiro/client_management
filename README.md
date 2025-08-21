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

``` bash
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

# Chamada VOIP - Twilio
Para configuração da chamada de voz será necessario criar uma conta na https://www.twilio.com/en-us 
Sera necessario vincular um numero de celular a sua conta.
Logo no começo na aba verificações teremos 2 dados importantes, utilizaremos elas para preencher o nosso arquivo`.env`:

```
TWILIO_SID=
TWILIO_AUTH_TOKEN=
TWILIO_PHONE_NUMBER=
```

| Importante! Lembrar que a versão gratuita da twilio consegue efetuar chamada de audio apenas para numeros
cadastrados na whitelist da plataforma deles, isso pode ser feito na aba "Phone numbers" > "Verified Caller IDs".

Essa chamada é disparada ao clicar no telefone do contato lista de contatos do "app front end".

# Webhook
Toda vez que criamos ou editarmos um cliente, uma chamada é feita para o endereço do webhook configurado no env:
```
WEBHOOK_SERVER_URL=https://webhook.site/137bcfd9-9d8b-43b5-bce0-cd672c45cb63    
WEBHOOK_SERVER_SECRET='$2y$12$R3ImPliuEFmHUzlgyDRHDeYNF1crOOj21akfL5qD3VfvZ4rO68W12'
```
Para que isso funcion sera necessario executar o comando
``` bash
docker exec -it max-app bash
```
``` bash
php artisan queue:work
```
Com isso, sempre que houver as alterações citadas acima, uma tarefa será agendado e as informações enviadas para
o endereço configurado.

# Agendamento de mensagem
Ao criar um novo usario, um agendamento de envio de mensagem de boas vindas é feito.
Podemos usar um servidor SMTP como Mailgun, Google, Outlook porem para testes, podemos verificar o email
enviado nos logs do laravel:
```
MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

`/storage/logs/laravel.log`