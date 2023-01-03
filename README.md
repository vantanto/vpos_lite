
# 🛒 vpos_lite - Point Of Sales (Lite Version)

Point of Sales to manage order and purchase transactions with stock system. Powered by laravel 9 and AdminLTE template.


## 📸 Showcase

<p align="center">
<img src="./public/assets/demo.gif" width="600"><br>
</p>


## ⚡ Features

- Order Transaction
- Purchase Transaction
- Stock System
- Order Profit per Product


## 🚀 Ship vpos_lite

vpos_lite require PHP >= 8.0.

Simply you can clone this repository:

```bash
git clone https://github.com/vantanto/vpos_lite.git
cd vpos_lite
```

Install dependencies using composer

```bash
composer install
```

Copy and Setup database in `.env` file

```bash
cp .env.example .env
```

Generate key & Run migration, seeding & Start local developement

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

You can now access the server at http://localhost:8000

> **📃**
> View more documentation in <a href="https://vantanto.github.io/pages/documentation/vpos_lite.html" target="_blank">here</a>.


## 📝 Credit

#### Special Thanks
- [Laravel](https://laravel.com/)
- [AdminLTE](https://adminlte.io/)

This project is [MIT](https://github.com/vantanto/vpos_lite/blob/master/LICENSE) licensed.