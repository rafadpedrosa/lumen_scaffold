<?php

namespace rafadpedrosa\lumen_scaffold;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LumenScaffoldCommand extends Command
{
    //init variables
    private $templates_dir;
    private $tmp_dir;
    private $controller_file;
    private $model;
    private $app_dir;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lumen_scaffold:start {model : model name}
                            {--m|migration=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold an model to a lumen way';

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        //init variables
        $this->model = '';
        $this->templates_dir = __DIR__ . '/templates/';
        $this->tmp_dir = $this->templates_dir . 'tmp';
        $this->controller_file = $this->tmp_dir . '/' . $this->model . 'Controller.php';
        $this->app_dir = __DIR__ . '/../../../../app';
    }

    /**
     * Compatiblity for Lumen 5.5.
     *
     * @return void
     */
    public function handle()
    {
        $this->fire();
    }

    private function getContentsAlreadyReplacedFromTemplateFile($file_name)
    {
        // Logic to read and replace file {template} names
        // I prefer do this way to improve my php skills
        $file = fopen($this->templates_dir . $file_name, 'r+');

        $contents = '';
        $old = '';
        $count = 0;
        $fileLength = 53;

        while (!feof($file)) {
            $new = fread($file, $fileLength);

            if (str_contains($old . $new, 'template}')) {
                $contents = substr($contents, 0, strlen($contents) - strlen($old));
                $increment = str_replace('{template}', $this->model, $old . $new);
                $increment = str_replace('{ltemplate}', strtolower($this->model), $increment);
            } else {
                $increment = $new;
            }

            $contents .= $increment;
            $count++;
            $old = $increment;
        }
        //FINISH READ
        fclose($file);
        return $contents;
    }

    public function writeAndConvertedContentOfModelOrControlerFile($file_name, $case)
    {
        $contents = $this->getContentsAlreadyReplacedFromTemplateFile($file_name);
        $file = fopen($this->controller_file, 'w+');
        fwrite($file, $contents);
        fclose($file);
        switch ($case) {
            case 1:
                //controller
                rename($this->controller_file, $this->app_dir . '/Http/Controllers/' . $this->model . 'Controller.php');
                break;
            case 1:
                //Model
                rename($this->controller_file, $this->app_dir . '/Http/Models/' . $this->model . '.php');
                break;
            case 3:
                //test
                rename($this->controller_file, $this->app_dir . '/../tests/' . $this->model . 'ApiTest.php');
                break;
            case 4:
                //seed
                rename($this->controller_file, $this->app_dir . '/../database/seeds/' . $this->model . 'TableSeed.php');
                break;
            case 5:
                //factory
                rename($this->controller_file, $this->app_dir . '/../database/factories/' . $this->model . 'Factory.php');
                break;
        }
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->model = $this->argument('model');
        try {

            if (!file_exists($this->tmp_dir))
                mkdir($this->tmp_dir);

            //WRITE
            $this->writeAndConvertedContentOfModelOrControlerFile('TemplateController.php' ,1);
            $this->writeAndConvertedContentOfModelOrControlerFile('model.php', 2);
            $this->writeAndConvertedContentOfModelOrControlerFile('TemplateApiTest.php', 3);
            $this->writeAndConvertedContentOfModelOrControlerFile('Seed.php', 4);
            $this->writeAndConvertedContentOfModelOrControlerFile('Factory.php', 5);

            // web.php
            file_put_contents($this->app_dir . '/../routes/web.php',
                '$router->resource(\'' . strtolower($this->model) . '\',\'' . $this->model . 'Controller\');',
                FILE_APPEND);

            // wagger tags
            file_put_contents($this->app_dir . '/Http/swagger/swaggerTags.php',
                "\n* @SWG\Tag("
                . "\n *   name=\"" . strtolower($this->model) . "s\","
                . "\n *   description=\"" . strtolower($this->model) . "s\"  API description\","
                . "\n *   @SWG\ExternalDocumentation("
                . "\n *     description=\","
                . "\n *     url=\"\""
                . "\n *   )"
                . "\n * )"
                . "\n **/ ",
                FILE_APPEND);

            // migrations
            if (!$this->option('migration'))
                shell_exec('composer dump-autoload');
            shell_exec('php artisan make:migration create_' . strtolower($this->model) . 's_table --create=' . strtolower($this->model) . 's');
        } finally {
            rmdir($this->tmp_dir);
        }
        echo "|--------------------------------------------------------------| \n";
        echo "|  Scaffold complete! See the new controler and we.php file!   | \n";
        echo "|--------------------------------------------------------------| \n";
    }
}
