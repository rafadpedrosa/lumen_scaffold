~FIX THE README~

# lumen-scaffold

Scaffold for lumen created by rafadpedrosa. It's the moustly simple scaffold ever! 

Maybe it's what you want :)
Maybe not :(

# Install / Usage

Add this package to your composer.json 

>  "rafadpedrosa/lumen_scaffold": "dev-master"

Since it's not downloadable from composer repo, you need to import by repository:

> "repositories": [
>     {
>       "type": "vcs",
>       "url": "https://github.com/rafadpedrosa/lumen_scaffold.git"
>     }
>   ]

then, "composer install"

OBS: to create a resource method for create all paths more fast, you have to change the application to mine in app.php like so:

> $app = new \rafadpedrosa\lumen_scaffold\config\Application(
>     realpath(__DIR__ . '/../')
> );

Add the command into your kernel.php
> \rafadpedrosa\lumen_scaffold\LumenScaffoldCommand::class,

then...
*Create folder ../Http/Models and ../Http/swagger* 
~PS: I need to add the swagger files... other wise this repo will still be understandable :(~

And now ou are ready to go! 

> php artisan lumen_scaffold:start your_model_here {--m|migration=1}

> php artisan lumen_scaffold:start car // no migration is created

> php artisan lumen_scaffold:start car -m // migration is created 


  **Using validations!**

If you want to validate something, use **$this->validate()** like in the lumen site. But it's a problem if you try to do it using jsons. So, to mitigate this, the is an middliware JsonApiMiddleware that can be used to make the json request be validated. Just add it in your app.php 


PS: This solution was retrived by some laracast (y)
