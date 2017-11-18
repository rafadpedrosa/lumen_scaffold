<?php

namespace rafadpedrosa\lumen_scaffold;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LumenScaffoldCommand extends Command
{
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
    protected $signature = 'lumen_scaffold:start {--model : model name}
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

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        echo('FUI CHAMADO!');
    }
}