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
                            {--options : options}';

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
        $this->controller_file = $this->tmp_dir . '/' . $this->model . 'Controler.php';
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

    private function getContentsAlreadyModifiedFromTemplateFile()
    {
        // Logic to read and replace file {template} names
        // I prefer do this way to improve my php skills
        $file = fopen($this->templates_dir . 'TemplateController.php', 'r+');

        $contents = '';
        $old = '';
        $count = 0;
        $fileLength = 53;

        while (!feof($file)) {
            $new = fread($file, $fileLength);

            if (str_contains($old . $new, '{template}')) {

                $contents = substr($contents, 0, strlen($contents) - strlen($old));
                $increment = str_replace('{template}', $this->model, $old . $new);
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
            $contents = $this->getContentsAlreadyModifiedFromTemplateFile();
            $file = fopen($this->controller_file, 'w+');
            fwrite($file, $contents);
            fclose($file);
            rename($this->controller_file, $this->app_dir . '/Http/Controllers/' . $this->model . 'Controler.php');
        } finally {
            rmdir($this->tmp_dir);
        }
//        echo $this->argument('model');
        echo "|--------------------------------------------------------------| \n";
        echo "|  Scaffold complete! See the new controler and we.php file!   | \n";
        echo "|--------------------------------------------------------------| \n";
    }
}