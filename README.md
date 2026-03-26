# TaskM

[中文文档](./README.zh-CN.md)

TaskM is a task management web application built with PHP, MySQL, and vanilla JavaScript.

## Tech Stack

- Backend: PHP 8, PDO, MySQL
- Frontend: HTML, vanilla JavaScript, Materialize CSS
- Auth: PHP Session
- Data: tables are initialized automatically on first request

## Project Structure

```text
.
├── api/            API endpoints
├── assets/         Shared styles and scripts
├── config/         Database configuration
├── pages/          Page files
├── index.html      Entry page
└── README.md
```

## Requirements

- Linux server or local development environment
- PHP 8.0+
- MySQL 5.7+ or compatible versions
- Web server: Nginx, Apache, or PHP built-in server

## Before Deployment

### 1. Prepare the database

Make sure MySQL is running and you have a valid account.

The project does not expose any default database password in the documentation.

You can configure the database in either of these ways:

1. Environment variables: `TASKM_DB_HOST`, `TASKM_DB_NAME`, `TASKM_DB_USER`, `TASKM_DB_PASS`, `TASKM_DB_CHARSET`
2. Local config file: copy `config/db.example.php` to `config/db.local.php` and fill in your own database credentials

`config/db.local.php` is ignored by Git and will not be committed.

### 2. Prepare the site directory

Upload the project to your site root, for example:

```bash
/www/wwwroot/taskm.ic8b.cn
```

Make sure the web server user can read the directory.

## Deployment Option 1: Nginx + PHP-FPM

### 1. Create the site

Point the site root to:

```text
/www/wwwroot/taskm.ic8b.cn
```

### 2. Configure PHP

Use PHP 8 or later.

### 3. Configure routing

This project does not require complex rewrite rules. Static pages and PHP APIs are stored in separate directories, so basic PHP execution is enough.

Example:

```nginx
server {
    listen 80;
    server_name taskm.ic8b.cn;
    root /www/wwwroot/taskm.ic8b.cn;
    index index.html index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }
}
```

Adjust `fastcgi_pass` for your server.

## Deployment Option 2: PHP Built-in Server

Suitable for local development or quick preview.

Run in the project root:

```bash
php -S 0.0.0.0:8000
```

Then open:

```text
http://127.0.0.1:8000
```

## First Run Behavior

On the first database request, the project will automatically:

- connect to MySQL
- create the `taskm` database if the current account has permission
- create these tables:
- `users`
- `tasks`
- `commits`

If your database account cannot create databases, create `taskm` manually in advance.

## Login and Registration Flow

- The user enters a plain-text password in the frontend
- The browser hashes it once with SHA-256
- The server stores the received hash using bcrypt
- After login, PHP Session keeps the user signed in

## Common Issues

### 1. Database connection error

For example:

```text
SQLSTATE[HY000] [1045] Access denied
```

This usually means the MySQL username or password is incorrect.

How to check:

1. Check environment variables or `config/db.local.php`
2. Confirm `host`, `name`, `user`, and `pass` are correct
3. Confirm the MySQL account can log in

You can test with:

```bash
mysql -u root -p
```

### 2. The page opens but the API returns 500

Common causes:

- PHP version is too old
- MySQL configuration is wrong
- PDO or `pdo_mysql` is not enabled

Check:

```bash
php -v
php -m | grep -E 'PDO|pdo_mysql'
```

### 3. The login page does not redirect

Check these network requests in the browser devtools:

- `/api/auth/check.php`
- `/api/auth/login.php`

If the API returns 401, that is normal when not logged in.
If it returns 500, it is usually a backend configuration issue.

## File Guide

- Page layouts: `pages/*.html`
- Shared styles: `assets/css/app.css`
- Shared scripts: `assets/js/app.js`
- Database entry and shared helpers: `config/db.php`
- Local sensitive database config: `config/db.local.php`
- Business APIs: `api/`

## Production Suggestions

- Never put real secrets in `README.md`, public repositories, or tracked files
- Use a dedicated low-privilege database account in production
- Enable HTTPS
- Back up the database regularly

## Maintenance Notes

If you continue extending the project, keep these rules:

- Return JSON from APIs
- Use prepared statements for all database operations
- Escape user input before rendering in the frontend
- Reuse `assets/css/app.css` and `assets/js/app.js` where possible
