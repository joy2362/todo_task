# 📝 Task Management App (Laravel + Vue 3)

A full-stack Task Management App built using **Laravel 12 (API)** and **Vue 3** as a **SPA frontend inside the Laravel project**.

---

## 🚀 Features

- Laravel API with Sanctum Authentication
- Task CRUD with Enum-based Status
- SPA using Vue 3 + Vite
- Pinia, Vue Router, Axios
- Tailwind CSS
- API Documentation with Scribe or Swagger
- PHPUnit Testing

---


## 🧾 Table of Contents

- [Clone the Project](#clone-the-project)
- [Setup the Project](#️setup-the-project)
- [Run the Project](#run-the-project)
- [API Documentation](#api-documentation)
- [Run Tests](#run-tests)
- [API Routes Overview](#api-routes-overview)

---


## 📥 Clone the Project

```bash
git clone https://github.com/joy2362/todo_task
cd todo_task
```
## ⚙️ Setup the Project
### 1. Install PHP dependencies

```bash
composer install
```

### 2. Copy the .env file and generate the app key

```bash
cp .env.example .env
php artisan key:generate
```
### 3. Configure your database in .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```
### 4. Run migrations

```bash
php artisan migrate
```

### 5. (Optional) Seed dummy data

```bash
php artisan db:seed
```

### 6. Install Node dependencies:

```bash
npm install
```
## ▶️ Run the Project

### 1. Run the server:

```bash
php artisan serve
```

### 2. Run Vite dev server:

```bash
npm run dev
```
The API will be available at: http://localhost:8000

## 📚 API Documentation
### Generate api doc
```bash
php artisan l5-swagger:generate
```
The API documentation is available at: http://localhost:8000/api/docs

## 🧪 Run Tests
### Run the test suite using PHPUnit:

```bash
php artisan test
```
### Tests included:

- User registration

- User login

- Authenticated user logout

- Create/View/Update/Delete task

- Mark task as complete

- Auth protection and validation


## 📌 API Routes Overview

| Method | Endpoint                             | Description               |
| ------ | ------------------------------------ | ------------------------- |
| POST   | `/api/v1/register`                   | Register user             |
| POST   | `/api/v1/login`                      | Login user                |
| GET    | `/api/v1/me`                         | Get current user (auth)   |
| GET    | `/api/v1/logout`                     | Logout user (auth)        |
| GET    | `/api/v1/task`                       | List all tasks (auth)     |
| GET    | `/api/v1/task/{id}`                  | View a single task (auth) |
| POST   | `/api/v1/task`                       | Create a task (auth)      |
| PUT    | `/api/v1/task/{id}`                  | Update a task (auth)      |
| DELETE | `/api/v1/task/{id}`                  | Delete a task (auth)      |
| GET    | `/api/v1/task/{id}/mark-as-complete` | Mark task complete (auth) |
