<?php

namespace LowB\Ladmin\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use LowB\Ladmin\Config\Facades\LadminConfig;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'ladmin:make:controller {handle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make admin controller';

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var string
     */
    protected $handleName;

    public function handle()
    {
        $this->handleName = $this->getHandleInput();
        $validHandleNames = ['auth', 'Auth', 'Profile', 'profile', 'Dashboard', 'dashboard'];

        if (!in_array($this->handleName, $validHandleNames)) {
            $this->error('Invalid handle name. The handleName must be one of: ' . implode(', ', $validHandleNames));

            return false;
        }
        $this->controllerName = Str::studly($this->handleName) . 'Controller';

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
    protected function getHandleInput()
    {
        return trim($this->argument('handle'));
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    protected function getStub()
    {
        return __DIR__ . '\\..\\stubs\\Controllers\\' . Str::studly($this->handleName) . 'Controller.stub';
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace(
            [
                'DummyNamespace',
            ],
            [
                LadminConfig::config('namespace.controller'),
            ],
            $stub
        );
    }
}
