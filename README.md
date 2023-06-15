# vue-project

## Project Setup

```sh
npm install

```

## Run Project

```sh
npm run dev
```

# laravel-project

```sh
# Run 'composer i' to insatll library of laravel (note:* install composer first)
composer i

# change .env.copy or .env.example to .env and fill in project configuration for example database name, password, vnp_TmnCode (VNPAY),......

# create database
php artisan migrate

# insert users - roles - permissions
php artisan db:seed

# fake data categories table
php artisan shop:cate

# fake data products table
php artisan shop:product

# run project laravel
php artisan serve
```

# Display Screen

![Trang chủ](fontend-vue/snapshops/web1.png)

![Giỏ hàng](fontend-vue/snapshops/web2.png)

![Tra cứu đơn](fontend-vue/snapshops/web3.png)

![Quản lý sản phẩm](fontend-vue/snapshops/web4.png)

![Quản lý người dùng](fontend-vue/snapshops/web5.png)

![Trang chủ Admin](fontend-vue/snapshops/web6.png)
