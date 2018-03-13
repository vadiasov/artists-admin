## Laravel ArtistsAdmin
This package creates DB artists. It serves CRUD pages for artists in administrative panel.

It includes a ServiceProvider to register the package and attach it to the output. 
It includes migrations to create DB artists.
Page Edit includes Photo of Artist. Admin can change it with cropping.

## Installation
Add the package to root composer.json:
````
"require": {
        ...
        "vadiasov/roles-admin": "dev-master",
  }
````
Then run:
````
composer update
````
Register package in config/app.php
````
'providers' => [
        /*
         * Package Service Providers...
         */
        Vadiasov\RolesAdmin\RolesServiceProvider::class,
````
Create model:
````
php artisan make:model Role
````
Publish migrations and seeds. Run:
````
php artisan vendor:publish
````
and enter appropriate number of this package (see terminal output after last command).


Migrate:
````
php artisan migrate
````
Seed if you need demo data:
````
php artisan db:seed class=RolesSeeder
````

## Routes
The routes are in the package:
````
admin/roles
admin/roles/create
admin/roles/{id}/edit
admin/roles/{id}/delete
````
