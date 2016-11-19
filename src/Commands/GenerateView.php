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
    protected $signature = 'lgview::make {page} {--path=default}';

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
    

    const FILE_EXTENSION = '.blade.php';
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

        if($this->createViewfile($this->argument('page')))
        {
            return $this->info("view successfully created..");
        }
    }

    protected function createViewfile($file) 
    {

        $this->default_resource_path = $this->getViewConfigPath();
        $create_dir = $this->default_resource_path.static::DS.$this->directory;
        $full_path = $this->default_resource_path.static::DS.$this->directory.static::DS.$file.static::FILE_EXTENSION;
        
        if(! $this->filesystem->exists($create_dir)) { //should be check whether file is exists or not
            @$this->filesystem->makeDirectory($create_dir,493,true);
        }

        if($this->option('path')) {
            
            if($this->filesystem->isWritable($create_dir)) {
                return file_put_contents($full_path,$this->loadViewStub(),true);
            }
            else {

                return $this->error('Current directory are not has any permission.');
            }
        }
       
        if($this->filesystem->isWritable($create_dir)) {
            if($this->filesystem->exists($full_path)) {

                if($this->confirm('view already exists.Overwrite content?','[yes|no]')) {
                     return file_put_contents($full_path,$this->loadViewStub(),true);
                }
            }
            else {

                return file_put_contents($full_path,$this->loadViewStub(),true);
            }
        }
        
        else {

            return $this->error('Current directory are not has any permission.');
        }
    
    }


    protected function loadViewStub() {

        return file_get_contents(__DIR__.'/../Stubs/view.stubs',true);
    }
    /**
     * [getViewConfigPath description]
     * @return [type] [description]
     */
    protected function getViewConfigPath() {
        return $this->config->get('view.paths')[0];
    }
}

