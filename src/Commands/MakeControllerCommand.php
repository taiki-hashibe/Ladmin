<?php

namespace LowB\Ladmin\Commands;

use Illuminate\Console\GeneratorCommand;
use LowB\Ladmin\Config\Facades\LadminConfig;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'ladmin:make:controller {query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make admin crud controller';

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var string
     */
    protected $queryName;

    public function handle()
    {
        $this->queryName = $this->getQueryInput();
        $this->controllerName = class_basename($this->queryName) . 'CrudController';

        $name = $this->qualifyClass(LadminConfig::config('namespace.controller') . '\\' . $this->controllerName);
        $path = $this->getPath($name);
        $this->makeDirectory($path);
        $this->files->put($path, $this->sortImports($this->buildClass($name)));
        return true;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getQueryInput()
    {
        return trim($this->argument('query'));
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function getStub()
    {
        return __DIR__ . '\\..\\stubs\\Controllers\\CrudController.stub';
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace(
            [
                'DummyNamespace',
                'DummyControllerName',
            ],
            [
                LadminConfig::config('namespace.controller'),
                $this->controllerName,
            ],
            $stub
        );
    }
}
