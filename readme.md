#Laravel Base

Quickly scaffold out a fully functional app within seconds. Come on, be lazy.


## Features


- Role Based Access Control (RBAC) :- Fully functioning role based access control with permission level granularity.
- Policy & Validation Enforcement :- Set policies and validation rules per each controller route
- Audit Logs :- Changes to models are stored into the database for audit purposes
- Auth Logs :- Login / Logout / Register actions are logged for audit purposes
- Menu Manager :- Fully integrated with RBAC to ensure only privileged users can see and access the links.
- Datatables :- Fully-ajaxified datatables that ensures the best user experience.
- User management :- Full control of you application's users including changing passwords, deactivating, blacklisting and login as user
- Authentication :- Login, Logout, Registration, Forgot Password - your usual stuff for authentication
- Translation :- Easy support for multiple language
- Module based loading :- All routes and resources are loaded via the ServiceProvider. Don't want a module? Remove the service provider.
- Scaffold Generator :- Pure joy from all of the above with just one command


## Getting Started

1. `composer create-project zulfajuniadi/laravel-base`
2. Create your database
3. `php artisan app:install`