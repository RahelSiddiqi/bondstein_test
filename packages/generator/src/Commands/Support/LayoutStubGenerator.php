<?php

namespace Rahel\Generator\Commands\Support;

class LayoutStubGenerator
{
    /**
     * Name for the model
     * @var string
     */
    public string $name;

    /**
     * Fields for the model
     * @var array
     */
    public array $columns;

    /**
     * Stub contents
     * @var string
     */
    public string $contents;

    /**
     * Generate Model for this name
     * @param mixed $name
     * @param mixed $columns
     * @return void
     */
    public function __construct(string $name, array $columns)
    {
        $this->name    = $name;
        $this->columns = $columns;
    }

    /**
     * Generate new model
     * @param string $name
     * @param array $columns
     * @return self
     */
    public static function generate(string $name, array $columns): self
    {
        return new static($name, $columns);
    }

    /**
     * @param $search
     * @param $replace
     */
    public function replace($search, $replace): void
    {
        $this->contents = str_replace('$' . strtoupper($search) . '$', $replace, $this->contents);
    }
    public function save(): void
    {
        $stub           = Stub::create('layout.stub', 'resources/views/layouts');
        $this->contents = $stub->getContents();

        $filename = 'app' . '.blade.php';

        $stub->saveTo($filename, $this->contents);
    }
}
