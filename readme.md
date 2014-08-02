minimum requirements:
PHP 5.4+
Redis (Cache, Queues)


artisan app:reset to reset application
`artisan generate:scaffold --fields="user:string, is_admin:boolean, phone:integer" LeaveHoliday` to generate from /app/templates/scaffolding
`artisan generate:datatables 'name:Name, status_id:Status' leave_holidays` to generate datatables