# 📂 API de Upload de Arquivos (Oliveira Trust) - Desafio Desenvolvedor

API desenvolvida em **Laravel 11** com suporte a **upload de arquivos**, **armazenamento em MongoDB**, histórico em **MySQL** e autenticação via **Laravel Passport**.

> Inspirada no processo de consulta de arquivos públicos da B3: [Boletim Diário B3](https://www.b3.com.br/pt_br/market-data-e-indices/servicos-de-dados/market-data/consultas/boletim-diario/dados-publicos-de-produtos-listados-e-de-balcao/)

---

## ✅ Requisitos

- PHP ^8.2
- Composer
- MongoDB local ou Atlas
- MySQL 5.7+ ou 8.x
- Laravel 11.x
- Extensões PHP:
  - `ext-mongodb`
  - `ext-fileinfo`
  - `openssl`
  - `pdo`
  - `mbstring`
  - `tokenizer`
  - `xml`
  - `bcmath`
  - `ctype`
  - `json`

---

## 🧱 Tecnologias & Pacotes

- laravel/framework ^11.31
- passport ^13.0
- mongodb/laravel-mongodb ^5.4
- maatwebsite/excel ^3.1
- prettus/l5-repository ^2.10
- spatie/laravel-activitylog ^4.10
- webpatser/laravel-uuid ^4.0

---

## 🚀 Como rodar localmente

### 1. Clonar o repositório

```bash
git clone https://github.com/vitorinovinicius/desafio-desenvolvedor.git
cd desafio-desenvolvedor/api-upload
git checkout vinicius-oliveira-vitorino
```

### 2. Instalar as dependências

```bash
composer install
```

### 3. Copiar o arquivo `.env`

```bash
cp .env.example .env
```

### 4. Gerar chave da aplicação

```bash
php artisan key:generate
```

### 5. Configurar `.env`:
Exemplo de configuração para MySQL e MongoDB no Docker:

```env
APP_NAME=Laravel
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

MONGO_DB_HOST=mongodb
MONGO_DB_PORT=27017
MONGO_DB_DATABASE=laravel_mongo

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=
```

### 6. Rodar as migrations

```bash
php artisan migrate --seed
```

### 7. Criar cliente do Passport

#### A. Login com e-mail/senha (Password Grant):

```bash
php artisan passport:client --password
```

#### B. Token pessoal (Personal Access Token):

```bash
php artisan passport:client --personal
```

---
### 8. Como autenticar no Insomnia com Laravel Passport

#### Usuário criado no seed

`User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('123456'),
]);`

#### Passo 1: Obter o Access Token via Password Grant

##### 1. Crie uma nova requisição POST no Insomnia para:

`POST http://localhost:8000/api/oauth/token`

##### 2. No corpo (Body) selecione JSON e envie os dados:

`{
  "grant_type": "password",
  "client_id": "SEU_CLIENT_ID",
  "client_secret": "SEU_CLIENT_SECRET",
  "username": "test@example.com",
  "password": "123456",
  "scope": ""
}`
*Nota: Substitua SEU_CLIENT_ID e SEU_CLIENT_SECRET pelos valores do client criado com php artisan passport:client --password.*

##### 3. A resposta terá um JSON com o access token:

`{
  "token_type": "Bearer",
  "expires_in": 31536000,
  "access_token": "eyJ0eXAiOiJKV1QiLCJh...",
  "refresh_token": "def50200c7e3d5..."
}`

#### Passo 2: Usar o token para autenticar requisições protegidas

##### 1. Em suas requisições protegidas (ex: upload):

```md
1. No Insomnia, abra a requisição desejada.
2. Clique na aba "Auth".
3. Selecione o tipo "Bearer Token".
4. Cole o valor do `access_token` obtido no passo anterior.
```

##### 2. Agora pode fazer requisições autenticadas, por exemplo:
`POST http://localhost:8000/api/uploads
Headers:
  Authorization: Bearer eyJ0eXAiOiJKV1QiLCJh...

Body (form-data):
  file: [seu arquivo .csv ou .xlsx]
`

## Dica extra
### Para facilitar testes, você também pode gerar um token pessoal via:

`php artisan passport:client --personal`
___

## 📦 Endpoints

### 🔐 Autenticação

| Método | Rota           | Descrição                 |
|--------|----------------|---------------------------|
| POST   | /oauth/token   | Login via client/password |
| POST   | /register      | Registro + token pessoal  |

---

### 📁 Uploads

| Método | Rota       | Descrição                        |
|--------|------------|----------------------------------|
| POST   | /uploads   | Upload de arquivos (.xlsx/.csv)  |
| GET    | /uploads   | Listagem de histórico de uploads |

---

#### Exemplos de uso

##### 1. Upload de arquivo (POST /uploads)

```bash
curl -X POST http://localhost/api/uploads \
-H "Authorization: Bearer SEU_ACCESS_TOKEN" \
-F "file=@/caminho/para/seu/arquivo.csv"
```

Ou usando Insomnia/Postman:

- Método: POST  
- URL: `http://localhost/api/uploads`  
- Headers:  
  - Authorization: `Bearer SEU_ACCESS_TOKEN`  
- Body: form-data  
  - chave: `file`  
  - valor: selecione o arquivo `.csv` ou `.xlsx`

---

##### 2. Listar histórico de uploads (GET /uploads)

```bash
curl -X GET http://localhost/api/uploads \
-H "Authorization: Bearer SEU_ACCESS_TOKEN"
```

Resposta típica (JSON):

```json
[
  {
    "id": 1,
    "file_name": "arquivo.csv",
    "uuid": "abc123def456",
    "file_path": "uploads/arquivo.csv",
    "status": "Processing",
    "created_at": "2025-06-15T13:00:00Z"
  },
  {
    "id": 2,
    "file_name": "dados.xlsx",
    "uuid": "xyz789uvw123",
    "file_path": "uploads/dados.xlsx",
    "status": "Completed",
    "created_at": "2025-06-14T11:30:00Z"
  }
]
```

---

### 🔎 Consulta

| Método | Rota       | Descrição                      |
|--------|------------|--------------------------------|
| GET    | /records   | Busca por TckrSymb e RptDt     |

---

#### Exemplo de consulta com filtros

```bash
curl -X GET "http://localhost/api/records?TckrSymb=PETR4&RptDt=2024-05-01" \
-H "Authorization: Bearer SEU_ACCESS_TOKEN"
```

Resposta exemplo:

```json
[
  {
    "TckrSymb": "PETR4",
    "RptDt": "2024-05-01",
    "Open": 27.45,
    "Close": 27.80,
    "Volume": 1250000
  },
  {
    "TckrSymb": "PETR4",
    "RptDt": "2024-05-01",
    "Open": 27.50,
    "Close": 27.90,
    "Volume": 980000
  }
]
```

## 🧠 Sobre a Arquitetura

- Uploads em `storage/app/private/uploads/`
- Conteúdo do arquivo armazenado no **MongoDB**
- Histórico de uploads salvo em **MySQL**
- Estrutura modular com Criteria, Helpers, Jobs, Repositories, Services.

---

## 📂 Estrutura de Pastas

```
app/
├── Criteria/
├── Helpers/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   ├── Resources/
├── Imports/
├── Jobs/
├── Models/
├── Repositories/
├── Services/
├── Traits/
```

---

## 🧪 Testes

```bash
php artisan test
```

---
---

## 🚀 Rodando com Docker

1. **Build dos containers:**
   ```sh
   docker-compose build --no-cache
   ```
2. **Suba o ambiente:**
   ```sh
   docker-compose up
   ```
3. **Acesse a aplicação:**
   - API: http://localhost:8080

4. **Comandos úteis:**
   - Rodar migrations:
     ```sh
     docker-compose exec app php artisan migrate
     ```
   - Gerar chaves do Passport (não roda migrations):
     ```sh
     docker-compose exec app php artisan passport:client --password
     ```
   - Rodar fila:
     ```sh
     docker-compose exec app php artisan queue:work
     ```

5. **Variáveis de ambiente:**
   - O arquivo `.env` já está preparado para uso com Docker (MySQL, MongoDB, etc).

___

## 📘 Referências

- https://laravel.com/docs/11.x
- https://laravel.com/docs/11.x/passport
- https://laravel-excel.com/
- https://github.com/mongodb/laravel-mongodb

---

## 👨‍💻 Autor

Desenvolvido por [@vitorinovinicius](https://github.com/vitorinovinicius)
