<?php

namespace LaraGview\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\FileSystem\FileSystem;

class GenerateView extends Command
{

    /*
        
        title   : php artisan console generate view laravel 5
        version : 1.0
        author  : tajul asri rosli
        email   : <mtajulasri@gmail.com>

     */
    
    /**
     * directory
     * @var [type]
     */
    protected $directory;


    /**
     * [$default_resource_path description]
     * @var string
     */
    protected $default_resource_path;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {page} {--path=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create view for laravel 5.';

    /**
     * DIRECTORY SEPARATOR ALIAS
     */
    

    /**
     * [$config description]
     * @var [type]
     */
    protected $config;


    /**
     * [$filesystem description]
     * @var [type]
     */
    protected $filesystem;


    const DS = DIRECTORY_SEPARATOR;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConfigRepository $config,FileSystem $filesystem)
    {
        parent::__construct();
        $this->config = $config;
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
 
        $this->directory = $this->option('path');
        $this->directory = explode('.',$this->directory);
        $this->directory = implode('/',$this->directory);

        $action = $this->createViewfile($this->argument('page'));

        if($this->createViewfile($this->argument('page')))
        {
            return $this->info("view successfully created..");
        }
    }

    protected function createViewfile($file) 
    {

        $create_dir = $this->default_resource_path.static::DS.$this->directory;
        $full_path = $this->default_resource_path.static::DS.$this->directory.static::DS.$file;

        if(! $this->filesystem->exists($full_path)) { //should be check whether file is exists or not
            return file_put_contents($file,$this->loadViewStub());
        }
        else
        {
            if ($this->confirm('File are exists.Do you wish to continue? [yes|no]'))
            {
                return file_put_contents($file,$this->loadViewStub());   
            }
        }
    
    }


    protected function loadViewStub() {

        return file_get_contents(__DIR__.'../Stubs/view.stubs');
    }
    /**
     * [getViewConfigPath description]
     * @return [type] [description]
     */
    protected function getViewConfigPath() {
        return $this->config->get('views.path');
    }
}

