
# OlistPax

![Olist Paz](https://bit.ly/3vUDSLP)

# Apresentação
Desafio desenvolvido para processo seletivo na Olist Pax para desenvolvedor back-end PHP. 

Eesta documentação visa contribuir com o time de front-end proporcionando maior clareza no consumo da api.

## Objetivo da API

A API possui tres microsserviços com suas devidas responsabilidades.

Os microsserviços se dividem em três partes CATEGORIAS, PRODUTOS e ESTADOS BRASILEIROS.

[Consulte a Documentação no Postman](https://documenter.getpostman.com/view/9912123/TzCHCWFa#intro)

__Microsserviço Categoria__

>_desenvolvido para cadastrar categorias em uma base de dados local e posteriormente consultar, editar e deletar._

__Microsserviço Produto__  

>_desenvolvido para cadastrar produtos em uma base de dados local e posteriormente consultar, editar e deletar._

__Microsserviço Estados Brasileiros__

>_desenvolvido para consumir microsserviço externo e popular database local com todos estados brasileiros._

# Rotas, Autenticação e Códigos HTTP

### Url Base 

<http://localhost/olist>

## Autenticação
Não é necessário autenticar-se. API possui apenas rotas públicas.

## Success Code
- 200 Ok
- 201 Created


## Error Code
- 400 Bad Request
- 404 Not Found

## Indices

* [Rotas para Categoria](#rotas-para-categoria)

  * [/api/category](#1-apicategory)
  * [/api/category](#2-apicategory)
  * [/api/category/{id}](#3-apicategory{id})
  * [/api/category/{id}](#4-apicategory{id})
  * [/api/category/{id}](#5-apicategory{id})

* [Rotas para Estados Brasileiros](#rotas-para-estados-brasileiros)

  * [/api/states](#1-apistates)
  * [/api/states](#2-apistates)
  * [/api/states](#3-apistates)

* [Rotas para Produto](#rotas-para-produto)

  * [/api/product](#1-apiproduct)
  * [/api/product](#2-apiproduct)
  * [/api/product/{id}](#3-apiproduct{id})
  * [/api/product/{id}](#4-apiproduct{id})
  * [/api/product/{id}](#5-apiproduct{id})


--------


## Rotas para Categoria



### 1. /api/category


### Criar nova Categoria
Esta rota destina-se ao registro de uma nova categoria na base de dados.
Enviando os seguintes dados por form-data via POST.
- **name

**Regra de negócio da api**  

**campos obrigatórios

**Body exemplo para copiar e colar usando recurso Bulk Edit do postman**

name:Alimento


***Endpoint:***

```bash
Method: POST
Type: FORMDATA
URL: http://localhost/olist/api/category
```



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | alimento | Neste campo, deve ser informado o nome da categoria que será cadastrada no banco de dados. |



***More example Requests/Responses:***


##### I. Example Request: Criar categoria



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | alimento | Neste campo, deve ser informado o nome da categoria que será cadastrada no banco de dados. |



##### I. Example Response: Criar categoria
```js
{
    "status": "success",
    "class": "Controller/Category",
    "method": "create",
    "id": "1",
    "message": "categoria salva com sucesso"
}
```


***Status Code:*** 201

<br>



### 2. /api/category


### Listar todas categorias

Nesta rota é possível listar todas todas categorias cadastradas no banco de dados.

**Exemplo**

{url_base}/api/category


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://localhost/olist/api/category
```



***More example Requests/Responses:***


##### I. Example Request: Listar categorias



##### I. Example Response: Listar categorias
```js
{
    "status": "success",
    "class": "Controller/Category",
    "method": "list",
    "data": [
        {
            "id": "1",
            "name": "alimento",
            "created_at": "2021-03-25 15:49:26",
            "updated_at": "2021-03-25 15:49:26"
        },
        {
            "id": "2",
            "name": "bebida",
            "created_at": "2021-03-25 15:51:18",
            "updated_at": "2021-03-25 15:51:18"
        },
        {
            "id": "3",
            "name": "limpeza",
            "created_at": "2021-03-25 15:51:28",
            "updated_at": "2021-03-25 15:51:28"
        }
    ]
}
```


***Status Code:*** 200

<br>



### 3. /api/category/{id}


### Listar categoria por id

É possível consultar categorias passando o id no corpo da URI em uma requisição GET.

**Exemplo para consultar a categoria com id = 1**

{url_base}/api/category/1


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://localhost/olist/api/category/1
```



***More example Requests/Responses:***


##### I. Example Request: Buscar categoria por id



##### I. Example Response: Buscar categoria por id
```js
{
    "status": "success",
    "class": "Controller/Category",
    "method": "findById",
    "data": {
        "id": "1",
        "name": "alimento",
        "created_at": "2021-03-25 15:49:26",
        "updated_at": "2021-03-25 15:49:26"
    }
}
```


***Status Code:*** 200

<br>



### 4. /api/category/{id}


### Editar categoria por id

Para editar uma categoria é necessário enviar o id da categoria que deseja alterar.

**Exemplo para editar uma categoria com id = 1**

{url_base}/api/category/1

**Atenção**  

A alteração de uma categoria vai implicar em todos os produtos que estão relacionados a categoria.


***Endpoint:***

```bash
Method: POST
Type: FORMDATA
URL: http://localhost/olist/api/category/2
```



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | congelados | Deve enviar a novo nome da categoria. |



***More example Requests/Responses:***


##### I. Example Request: Editar categoria



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | congelados | Deve enviar a novo nome da categoria. |



##### I. Example Response: Editar categoria
```js
{
    "status": "success",
    "class": "Controller/Category",
    "method": "edit",
    "id": "2",
    "message": "categoria editada com sucesso"
}
```


***Status Code:*** 201

<br>



### 5. /api/category/{id}


### Deletar uma categoria

Deletar uma categoria enviando o id da categoria que deseja deletar via método DELETE.

**Exemplo para deletar a categoria com id = 1**

{url_base}/api/category/1

**Atenção**

Ao deletar uma categoria, automaticamente todos produtos vinculados a esta categoria também serão excluídos.


***Endpoint:***

```bash
Method: DELETE
Type: 
URL: http://localhost/olist/api/category/3
```



***More example Requests/Responses:***


##### I. Example Request: Deletar uma categoria



##### I. Example Response: Deletar uma categoria
```js
{
    "status": "sucess",
    "class": "Controller/Category",
    "method": "delete",
    "id": "3",
    "message": "categoria excluida com sucesso"
}
```


***Status Code:*** 200

<br>



## Rotas para Estados Brasileiros



### 1. /api/states


### Registrando Estados
Este endpoint irá consumir a api do IBGE que está filtrada para retornar o nome, a sigla e o id de cada estado.  
[Link da API do IBGE](https://servicodados.ibge.gov.br/api/v1/localidades/estados)

O microsserviço vai receber os dados em JSON, tratá-los e armazená-los no banco de dados local.

Logo abaixo pode ser encontrado um end-point que efetua a consulta na sua base de dados e lista todos estados no formato json.


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://localhost/olist/api/states
```



***More example Requests/Responses:***


##### I. Example Request: /api/states



##### I. Example Response: /api/states
```js
{
    "status": "success",
    "class": "Controller/BrazilState",
    "method": "index",
    "data": [
        {
            "id": "1",
            "state_id": "11",
            "name": "Rondônia",
            "sigla": "RO",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "2",
            "state_id": "12",
            "name": "Acre",
            "sigla": "AC",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "3",
            "state_id": "13",
            "name": "Amazonas",
            "sigla": "AM",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "4",
            "state_id": "14",
            "name": "Roraima",
            "sigla": "RR",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "5",
            "state_id": "15",
            "name": "Pará",
            "sigla": "PA",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "6",
            "state_id": "16",
            "name": "Amapá",
            "sigla": "AP",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "7",
            "state_id": "17",
            "name": "Tocantins",
            "sigla": "TO",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "8",
            "state_id": "21",
            "name": "Maranhão",
            "sigla": "MA",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "9",
            "state_id": "22",
            "name": "Piauí",
            "sigla": "PI",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "10",
            "state_id": "23",
            "name": "Ceará",
            "sigla": "CE",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "11",
            "state_id": "24",
            "name": "Rio Grande do Norte",
            "sigla": "RN",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "12",
            "state_id": "25",
            "name": "Paraíba",
            "sigla": "PB",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "13",
            "state_id": "26",
            "name": "Pernambuco",
            "sigla": "PE",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "14",
            "state_id": "27",
            "name": "Alagoas",
            "sigla": "AL",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "15",
            "state_id": "28",
            "name": "Sergipe",
            "sigla": "SE",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "16",
            "state_id": "29",
            "name": "Bahia",
            "sigla": "BA",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "17",
            "state_id": "31",
            "name": "Minas Gerais",
            "sigla": "MG",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "18",
            "state_id": "32",
            "name": "Espírito Santo",
            "sigla": "ES",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "19",
            "state_id": "33",
            "name": "Rio de Janeiro",
            "sigla": "RJ",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "20",
            "state_id": "35",
            "name": "São Paulo",
            "sigla": "SP",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "21",
            "state_id": "41",
            "name": "Paraná",
            "sigla": "PR",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "22",
            "state_id": "42",
            "name": "Santa Catarina",
            "sigla": "SC",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "23",
            "state_id": "43",
            "name": "Rio Grande do Sul",
            "sigla": "RS",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "24",
            "state_id": "50",
            "name": "Mato Grosso do Sul",
            "sigla": "MS",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "25",
            "state_id": "51",
            "name": "Mato Grosso",
            "sigla": "MT",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "26",
            "state_id": "52",
            "name": "Goiás",
            "sigla": "GO",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        },
        {
            "id": "27",
            "state_id": "53",
            "name": "Distrito Federal",
            "sigla": "DF",
            "created_at": "2021-03-25 19:03:58",
            "updated_at": "2021-03-25 19:03:58"
        }
    ]
}
```


***Status Code:*** 200

<br>



### 2. /api/states


### Listar todos estados registrados na base local
Este microsserviço consulta sua base de dados local e carrega todos estados cadastrados. Os dados são exibidos no formato json.


***Endpoint:***

```bash
Method: POST
Type: 
URL: http://localhost/olist/api/states
```



***More example Requests/Responses:***


##### I. Example Request: /api/states



##### I. Example Response: /api/states
```js
{
    "status": "success",
    "class": "BrazilStates",
    "method": "createStates",
    "message": "27 registros incluidos com sucesso"
}
```


***Status Code:*** 201

<br>



### 3. /api/states


### EXCLUIR TODOS ESTADOS DA TABELA

Excluir todos estados da tabela.

**Atenção**

Este microsservico foi criado unicamente para compor o CRUD de "Estados Brasileiros".

>A ação de excluir todos os dados de uma tabela não é recomendada.

Hipoteticamente se uma aplicação consumir os dados da tabela gerenciada por este metodo poderia ter sérios problemas. Após excluir todos os dados da tabela e a cada nova chamada do microsserviço (POST) /api/states para popular a tabela, os numeros de id proprietário (gerenciado pelo database local) seriam incrementados.

Para reduzir os danos a uma aplicacao que hipoteticamente esteja consumindo esta aplicação, adotei o metódo TRUNCATE para excluir os dados. Assim a cada nova insserção realizada pelo microsserviço (POST) /api/states os dados serao salvos com id iniciados com 1 e incrementado automaticamente, mantendo sempre a mesma sequencia.


***Endpoint:***

```bash
Method: DELETE
Type: 
URL: http://localhost/olist/api/states
```



***More example Requests/Responses:***


##### I. Example Request: /api/states



##### I. Example Response: /api/states
```js
{
    "status": "success",
    "class": "BrazilStates",
    "method": "createStates",
    "message": "registros excluidos com sucesso"
}
```


***Status Code:*** 200

<br>



##### II. Example Request: /api/states



##### II. Example Response: /api/states
```js
{
    "status": "success",
    "class": "BrazilStates",
    "method": "createStates",
    "message": "registros excluidos com sucesso"
}
```


***Status Code:*** 201

<br>



## Rotas para Produto



### 1. /api/product


### Criar novo produto
Para cadastrar um produto, é obrigatório enviar via form-data os seguintes dados
- **name 
- **category_id
- **price
- quantity

**Regra de negócio da api**

** campos obrigatórios

Observação 1:
O campo quantity não precisa ser enviado para a criação de um produto, contudo por padrão, um produto criado sem o envio do campo "quantity" será atribuido o valor 0 (zero).

Observação 2:
O id da categoria será validado pelo sistema e caso o id informado não esteja previamente cadastrado na base, o servidor lançará um erro 400 - bad request com a mensagem de "categoria inválida" e o produto não será salvo.

**Body exemplo para copiar e colar usando recurso Bulk Edit do postman**

name:Arroz  
category_id:2  
price:3.50  
quantity:10


***Endpoint:***

```bash
Method: POST
Type: FORMDATA
URL: http://localhost/olist/api/product
```



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | Arroz | Informe o nome do alimento que deseja cadastrar.
 |
| category_id | 1 | Informe o id da categoria que este alimento pertence.
 |
| price | 3.50 | Informe o valor do produto. |
| quantity | 10 | Informe a quantidade de produto que deseja cadastrar. Se não informar este campo o valor padrão é 0. |



***More example Requests/Responses:***


##### I. Example Request: Criar produto



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | Arroz | Informe o nome do alimento que deseja cadastrar.
 |
| category_id | 1 | Informe o id da categoria que este alimento pertence.
 |
| price | 3.50 | Informe o valor do produto. |
| quantity | 10 | Informe a quantidade de produto que deseja cadastrar. Se não informar este campo o valor padrão é 0. |



##### I. Example Response: Criar produto
```js
{
    "status": "success",
    "method": "create",
    "class": "Controller/Product",
    "id": "1",
    "data": "produto salvo com sucesso"
}
```


***Status Code:*** 201

<br>



### 2. /api/product


### listar todos produtos
Listar todos os produtos cadastrados com método GET.

**Exemplo para listar todos produtos**  

{url_base}/api/product

Sua requisição vai resultar em uma estrutura do tipo json para facilitar na integração de sua aplicação.


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://localhost/olist/api/product
```



***More example Requests/Responses:***


##### I. Example Request: Listar produtos



##### I. Example Response: Listar produtos
```js
{
    "status": "success",
    "class": "Controller/Product",
    "method": "list",
    "data": [
        {
            "id": "1",
            "category_id": "1",
            "name": "Arroz",
            "quantity": "10",
            "price": "3.50",
            "created_at": "2021-03-25 15:55:09",
            "updated_at": "2021-03-25 15:55:09"
        },
        {
            "id": "2",
            "category_id": "2",
            "name": "Peito de Frango",
            "quantity": "10",
            "price": "6.50",
            "created_at": "2021-03-25 16:04:52",
            "updated_at": "2021-03-25 16:04:52"
        }
    ]
}
```


***Status Code:*** 200

<br>



### 3. /api/product/{id}


Para filtrar o produto pelo id, é preciso fazer uma requisição GET com o numero do id informado na url.


***Endpoint:***

```bash
Method: GET
Type: 
URL: http://localhost/olist/api/product/1
```



***More example Requests/Responses:***


##### I. Example Request: Buscar produto por id



##### I. Example Response: Buscar produto por id
```js
{
    "status": "success",
    "class": "Controller/Product",
    "method": "findById",
    "data": {
        "id": "184",
        "category_id": "2",
        "name": "Arroz",
        "quantity": "10",
        "price": "3.50",
        "created_at": "2021-03-25 05:09:13",
        "updated_at": "2021-03-25 05:09:13"
    }
}
```


***Status Code:*** 200

<br>



### 4. /api/product/{id}


### editar um produto por id
Você pode editar qualquer um dos campos listados abaixo.
- name 
- category_id
- price
- quantity

**Regra de negócio da api**

Observação 1:
O campo quantity um editado sem enviar/atualizar o campo "quantity" será incrementado mais uma unidade em sua quantidade cadastrada no banco.

Observação 2:
O id da categoria será validado pelo sistema e caso o id informado não esteja previamente cadastrado na base, o servidor lançará um erro 400 - bad request com a mensagem de "categoria inválida" e o produto não será salvo.

**Body exemplo para copiar e colar usando recurso Bulk Edit do postman**

name:Arroz  
category_id:2  
price:3.50  
quantity:10


***Endpoint:***

```bash
Method: POST
Type: FORMDATA
URL: http://localhost/olist/api/product/1
```



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | café |  |
| category_id | 1 |  |



***More example Requests/Responses:***


##### I. Example Request: Editar produto



***Body:***

| Key | Value | Description |
| --- | ------|-------------|
| name | café |  |
| category_id | 1 |  |



##### I. Example Response: Editar produto
```js
{
    "status": "success",
    "class": "Controller/Product",
    "method": "edit",
    "id": "1",
    "message": "produto salvo com sucesso"
}
```


***Status Code:*** 201

<br>



### 5. /api/product/{id}


### Deletar um produto

Deletar um produto enviando o id do produto que deseja deletar via método DELETE.

**Exemplo para deletar um produto com id = 1**

{url_base}/api/product/1


***Endpoint:***

```bash
Method: DELETE
Type: 
URL: http://localhost/olist/api/product/55
```



***More example Requests/Responses:***


##### I. Example Request: Deletar produto



##### I. Example Response: Deletar produto
```js
{
    "status": "sucess",
    "class": "Controller/Product",
    "method": "delete",
    "id": "1",
    "message": "produto excluido com sucesso"
}
```


***Status Code:*** 200

<br>



---
[Back to top](#olistpax)
> Made with &#9829; by [thedevsaddam](https://github.com/thedevsaddam) | Generated at: 2021-03-26 15:40:32 by [docgen](https://github.com/thedevsaddam/docgen)
