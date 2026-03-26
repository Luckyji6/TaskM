# TaskM

TaskM 是一个基于 PHP + MySQL + 原生 JavaScript 的任务管理应用。

## 技术栈

- 后端：PHP 8、PDO、MySQL
- 前端：HTML、原生 JavaScript、Materialize CSS
- 鉴权：PHP Session
- 数据：首次访问时自动初始化数据表

## 项目结构

```text
.
├── api/            接口目录
├── assets/         公共样式与脚本
├── config/         数据库配置
├── pages/          页面文件
├── index.html      入口页
└── README.md
```

## 环境要求

- Linux 服务器或本地开发环境
- PHP 8.0 及以上
- MySQL 5.7 及以上，或兼容版本
- Web 服务器：Nginx、Apache，或 PHP 内置服务器

## 部署前准备

### 1. 准备数据库

先确保 MySQL 服务已启动，并且有可用账号。

项目不会在文档中提供默认数据库密码。

数据库配置支持两种方式：

1. 环境变量：`TASKM_DB_HOST`、`TASKM_DB_NAME`、`TASKM_DB_USER`、`TASKM_DB_PASS`、`TASKM_DB_CHARSET`
2. 本地配置文件：复制 `config/db.example.php` 为 `config/db.local.php` 后填写你自己的数据库信息

`config/db.local.php` 已加入忽略列表，不会提交到仓库。

### 2. 准备站点目录

把项目文件上传到网站根目录，例如：

```bash
/www/wwwroot/taskm.ic8b.cn
```

确保 Web 服务器用户对该目录有读取权限。

## 部署方式一：Nginx + PHP-FPM

### 1. 创建站点

站点根目录指向项目目录：

```text
/www/wwwroot/taskm.ic8b.cn
```

### 2. 配置 PHP

确保站点使用 PHP 8 或更高版本。

### 3. 配置伪静态

本项目不依赖复杂路由，静态页面与 PHP 接口分目录放置，一般不需要额外伪静态规则。

如果是标准 Nginx + PHP-FPM，只要保证 `.php` 可以正常执行即可。

示例：

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

实际 `fastcgi_pass` 按你的服务器环境调整。

## 部署方式二：PHP 内置服务器

适合本地开发或临时预览。

在项目根目录执行：

```bash
php -S 0.0.0.0:8000
```

然后访问：

```text
http://127.0.0.1:8000
```

## 首次启动说明

项目会在首次请求数据库时自动执行初始化逻辑：

- 自动连接 MySQL
- 自动创建数据库 `taskm`（如果当前账号有权限）
- 自动创建以下表：
- `users`
- `tasks`
- `commits`

如果你的数据库账号没有创建数据库权限，也没关系，但你需要提前手动创建 `taskm` 数据库。

## 登录与注册流程

- 用户在前端输入明文密码
- 浏览器使用 SHA-256 先做一次哈希
- 服务端接收哈希值后，再用 bcrypt 保存
- 登录成功后，通过 PHP Session 维持登录状态

## 常见问题

### 1. 出现数据库连接错误

例如：

```text
SQLSTATE[HY000] [1045] Access denied
```

说明 MySQL 用户名或密码不对。

处理方式：

1. 检查环境变量或 `config/db.local.php`
2. 确认 `host`、`name`、`user`、`pass` 配置正确
3. 确认 MySQL 账号可以登录

可用命令测试：

```bash
mysql -u root -p
```

### 2. 页面能打开，但接口返回 500

常见原因：

- PHP 版本过低
- MySQL 配置错误
- PHP 没有启用 PDO 或 pdo_mysql

请先检查：

```bash
php -v
php -m | grep -E 'PDO|pdo_mysql'
```

### 3. 登录页一直不跳转

先检查浏览器开发者工具中的网络请求：

- `/api/auth/check.php`
- `/api/auth/login.php`

如果返回 401，说明当前未登录，这是正常现象。
如果返回 500，通常是后端配置问题。

## 文件修改建议

- 页面布局主要在 `pages/*.html`
- 公共样式在 `assets/css/app.css`
- 公共脚本在 `assets/js/app.js`
- 数据库连接入口与公共函数在 `config/db.php`
- 本地数据库敏感配置建议放在 `config/db.local.php`
- 业务接口在 `api/`

## 生产环境建议

- 不要把真实敏感配置写进 `README.md`、公开仓库或可提交文件
- 生产环境建议使用权限更小的专用数据库账号
- 使用 HTTPS
- 定期备份数据库

## 维护说明

如果你要继续扩展功能，建议优先遵循：

- 保持接口返回 JSON
- 所有数据库操作使用预处理语句
- 前端渲染用户输入时做转义
- 页面尽量复用 `assets/css/app.css` 与 `assets/js/app.js`
