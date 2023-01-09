## Requirements

- php 8.1
- composer
- docker 
- docker-compose

## Start

```
composer install

alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

sail up -d

sail php artisan migrate
sail npm install
sail npm run build

```