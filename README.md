![Form Cinch Logo](src/public/images/form-cinch-logo.png)

## About FormCinch
FormCinch is a simple GUI to help you create forms for your Laravel application. <strong>This is a work in progress and not ready for deployment to a production site.</strong>

##Installation
Run in the terminal: 

````
composer require ng-media/formcinch
````

Publish the config, migrations, and views
````
php artisan vendor:publish --provider="Ngmedia\FormCinch\FormCinchServiceProvider"
````

Run the migrations
````
php artisan migrate
````

You should should have access to the FormCinch config as well as the views to style the forms the way you like.


## License

FormCinch is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
