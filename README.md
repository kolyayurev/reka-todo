## Start

```
composer install

alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

sail up -d

sail php artisan migrate
sail npm install
sail npm run build

```