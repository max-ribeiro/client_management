# 📞 Sistema de Gestão de Clientes com API, Webhooks, VOIP e Relatórios

## 📋 Descrição
Este projeto é uma aplicação desenvolvida em **Laravel** que implementa um **CRUD de clientes** com suporte a:
- Armazenamento em banco de dados relacional (MySQL);
- Separação de entidades **Cliente**, **Endereço** e **Foto**;
- Envio de **webhooks** para sistemas externos ao criar ou atualizar clientes;
- Integração com **provedor VOIP** para realizar chamadas a clientes com telefone cadastrado;
- **Tarefas agendadas** para envio de e-mail de boas-vindas 30 minutos após cadastro;
- **Relatórios** com gráficos sobre os dados cadastrados;
- Funcionalidades extras sugeridas para enriquecimento de dados e segmentação.

---

## 📑 Sumário
1. [Planejamento](#-planejamento)
2. [Configuração para Executar](#-configuração-para-executar)
3. [Modelagem do Banco de Dados](#-modelagem-do-banco-de-dados)
4. [Requisições da API](#-requisições-da-api)
    - [Criar Cliente](#criar-cliente)
    - [Listar Clientes](#listar-clientes)
    - [Visualizar Cliente](#visualizar-cliente)
    - [Atualizar Cliente](#atualizar-cliente)
    - [Remover Cliente](#remover-cliente)
5. [Webhooks](#-webhooks)
6. [Tarefas Agendadas](#-tarefas-agendadas)
7. [Funcionalidades Extras](#-funcionalidades-extras)

---

## 📌 Planejamento

### Objetivos
- Criar uma API robusta e extensível para gerenciamento de clientes;
- Garantir organização dos dados por meio de normalização (clientes, endereços e fotos separados);
- Permitir integração simples com sistemas externos via webhook e VOIP;
- Gerar insights a partir dos dados cadastrados.

### Stack Utilizada
- **PHP** 8.4
- **Laravel** 12
- **MySQL** 8.x

---
![Project MVP Planning](https://maxribeiro.tech/public/img/client_management_mvp.png)

## ⚙ Configuração para Executar
docker:
./vendor/bin/sail up

migrations:
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate --env=testing 

testes:
Feature
./vendor/bin/sail artisan test --testsuite=Feature

JWT:
./vendor/bin/sail php artisan jwt:secret

