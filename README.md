Ось чистий варіант як код-блок, щоб ти міг просто скопіювати (без зайвих id і форматування ChatGPT):

# 🚀 SHTST Project

## 📦 Підняття проекту

```bash
git clone https://github.com/SerhiiKozak/shtst.git
cd shtst

cp laravel/.env.example laravel/.env
# ⚠️ Відредагувати .env під своє середовище

docker compose up -d --build

docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
docker compose exec app php artisan optimize:clear
```

## 🌐 Доступ до проекту

Відкрити в браузері:

```
http://localhost:8000
```

Після цього — зареєструвати користувача.

> ⚠️ Тестові дані генеруються через `fake()`, тому вони **не статичні**.

---

# 🔌 API

## 📌 Створення завдання

```bash
curl -X POST http://localhost:8000/api/tickets \
  -F "name=John Doe" \
  -F "phone=+380501234567" \
  -F "email=john@test.com" \
  -F "theme=Bug report" \
  -F "text=Something is broken" \
  -F "files[]=@/path/to/file.pdf"
```

### ✔ Успішна відповідь

```json
{
  "success": true,
  "message": "Ticket created successfully",
  "ticket": {
    "id": 1
  }
}
```

### ❌ Помилка (валідація)

```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Invalid form data",
    "fields": {
      "phone": "Invalid phone format"
    }
  }
}
```

### ❌ Помилка (rate limit)

```json
{
  "success": false,
  "error": {
    "code": "RATE_LIMIT_EXCEEDED",
    "message": "Too many requests",
    "retry_after": 3600
  }
}
```

---

## 📋 Список завдань

```
GET /api/dashboard/tickets?status=new&email=test&sort=created_at&direction=desc
```

### Приклад відповіді

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "theme": "Bug",
      "text": "Something broken",
      "status": {
        "id": 1,
        "code": "new",
        "name": "New"
      },
      "customer": {
        "id": 1,
        "name": "John",
        "email": "john@test.com",
        "phone": "+380501234567"
      },
      "attachments": [],
      "created_at": "2026-04-07",
      "response_date": null
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "total": 1
  }
}
```

---

## 🔍 Перегляд завдання

```
GET /api/dashboard/tickets/{id}
```

### Приклад відповіді

```json
{
  "success": true,
  "data": {
    "id": 1,
    "theme": "Bug",
    "text": "Something broken",
    "status": {
      "code": "new",
      "name": "New"
    },
    "customer": {
      "name": "John",
      "email": "john@test.com",
      "phone": "+380501234567"
    },
    "attachments": [
      {
        "id": 10,
        "name": "file.pdf",
        "url": "http://localhost/storage/...",
        "size": 12345,
        "mime": "application/pdf"
      }
    ],
    "created_at": "...",
    "response_date": null
  }
}
```

---

## 🔄 Зміна статусу

```bash
curl -X PATCH http://localhost:8000/api/dashboard/tickets/1/status \
  -H "Content-Type: application/json" \
  -d '{"status":"in_progress"}'
```

### ✔ Успішна відповідь

```json
{
  "success": true,
  "data": {
    "id": 1,
    "status": {
      "code": "in_progress"
    }
  }
}
```

### ❌ Помилка

```json
{
  "success": false,
  "error": {
    "code": "INVALID_STATUS",
    "message": "Status not found"
  }
}
```

---

# 🏗 Архітектура та реалізація

## 1. Основні сутності

- `User`
- `Customer`
- `Ticket`
- `TicketStatus`

> `TicketStatus` винесено окремо для гнучкого керування статусами.

### Зв’язки

- Користувач → багато тікетів  
- Тікет → один користувач  
- Тікет → багато файлів  

Для файлів використано:

- `spatie/laravel-medialibrary`

---

## 2. Форма створення тікета

- Створено віджет з формою  
- Контролер зараз повертає тільки форму (може бути видалений)  
- Створення/редагування винесено в окремий API контролер  

### Додатково

- Централізований `Exception Handler`  
- Валідація форми  
- Rate limit: **1 запит / день**

---

## 3. Адмін-панель

Реалізовано через:

- `TicketResource`

Можливості:

- список тікетів  
- фільтрація  
- сортування  
- перегляд деталей  

---

## 4. Аутентифікація

Використано:

- `laravel/fortify`

### Нюанс

Роль користувача додається через Observer, але:

> ⚠️ При неправильному порядку міграцій можлива помилка, коли роль ще не існує.
