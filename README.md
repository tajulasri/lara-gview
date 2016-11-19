##Laravel view generator
This package is just for generate single blade view for laravel 5.Instead of bundle (index,show,edit,add )

1.Installation
```php
	"tajul-asri/lara-gview": "1.0"
```


2.Register service provider
```php
	LaraGview\LaraGViewServiceProvider::class
```

3.Generate single view command
```php
	php artisan lgview:make my_single_blade_view 
```

4.Generate with directory
```php
	php artisan lgview:make my_single_blade_view --path=users
```
```php
	php artisan lgview:make my_single_blade_view --path=users.admin
```

Dont hesitate to contact me at mtajulasri[at]gmail.com
