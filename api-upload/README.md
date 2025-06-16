
# 📑 API de Autenticação - Desafio Desenvolvedor

Esta API oferece autenticação baseada em OAuth2 usando Laravel Passport.

---

## 🔐 Registro de Usuário e Geração de Token

### Endpoint

`POST /api/register`

### Campos esperados no corpo da requisição:

| Campo     | Tipo   | Obrigatório | Descrição                   |
|-----------|--------|-------------|-----------------------------|
| name      | string | Não         | Nome do usuário             |
| email     | string | Sim         | Email do usuário (único)    |
| password  | string | Sim         | Senha com no mínimo 6 chars |

### Exemplo de requisição

```json
{
  "name": "Vinicius Vitorino",
  "email": "vitorino@email.com",
  "password": "123456"
}
```

### Exemplo de resposta

```json
{
  "user": {
    "id": 1,
    "name": "Vinicius Vitorino",
    "email": "vitorino@email.com",
    "created_at": "...",
    "updated_at": "..."
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGci...",
  "token_expires_at": "2025-07-15T13:23:00.000000Z"
}
```
---

## 🛠️ Configuração Inicial Obrigatória

Antes de usar a API, você **deve** criar um Personal Access Client.

### Comando:

```bash
php artisan passport:client --personal
```

Este comando gera o client necessário para `createToken()` funcionar corretamente no registro.

---

## ✅ Rotas protegidas

Após autenticação, envie o token no cabeçalho Authorization:

```
Authorization: Bearer {token}
```

---

# 📦 Dependências do Projeto

Este projeto foi desenvolvido com as seguintes dependências e requisitos.

## ✅ Requisitos Mínimos

- **PHP** `^8.2`
- **Laravel** `^11.0`
- **Composer**
- **MongoDB** (como banco NoSQL)
- **MySQL** (para usuários e autenticação)
- **Extensões PHP**: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`

---

## 📚 Dependências PHP

```json
"require": {
    "php": "^8.2",
    "laravel/framework": "^11.31",
    "laravel/helpers": "^1.7",
    "laravel/passport": "^13.0",
    "laravel/tinker": "^2.9",
    "maatwebsite/excel": "^3.1",
    "mongodb/laravel-mongodb": "^5.4",
    "prettus/l5-repository": "^2.10",
    "spatie/laravel-activitylog": "^4.10",
    "webpatser/laravel-uuid": "^4.0"
}


## 👨‍💻 Desenvolvido por

Vinicius Vitorino
