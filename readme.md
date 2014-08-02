minimum requirements:
PHP 5.4+
Redis (Cache, Queues)

artisan generate:datatable --fields="Todo:name:string, Done:is_done:boolean:default(0), User ID:user_id:integer" todos

git clone https://github.com/zulfajuniadi/laravel-base.git . && rm -rf .git && composer update