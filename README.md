~FIX THE README~

# lumen-scaffold

Scaffold for lumen created by rafadpedrosa.

It's the moustly simple scaffold ever! 

Maybe it's what you want :)
Maybe not :(

# Usage

add to your composer.json -> "rafadpedrosa/lumen_scaffold": "dev-master" package

Since it's not downloadable from composer repo, you need to import by repository:

"repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/rafadpedrosa/lumen_scaffold.git"
    }
  ]

and than "composer install"

OBS: to create a resource method for create all paths more fast, you have to change the application to mine in app.php like so:

$app = new \rafadpedrosa\lumen_scaffold\config\Application(
    realpath(__DIR__ . '/../')
);

And now ou are ready to go! 

php artisan lumen_scaffold:start your_model_here {--m|migration=1} 
php artisan lumen_scaffold:start car // no migration is created
php artisan lumen_scaffold:start car -m // migration is created
