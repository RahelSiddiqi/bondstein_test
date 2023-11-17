<?php

namespace Rahel\Generator\Commands\Support;

use Illuminate\Support\Str;

class ModelStubGenerator
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
        $stub           = Stub::create('model.stub', 'app/Models');
        $this->contents = $stub->getContents();
        $this->replace('namespace', 'App\Models');
        $this->replace('class', ucfirst($this->name));
        $columns = '[';
        foreach ($this->columns as $column) {
            $columns .= next($this->columns) ? "'$column'" . ', ' : "'$column'";
        }
        $columns .= ']';
        $this->replace('fillable', $columns);

        $filename = ucfirst($this->name) . '.php';

        $stub->saveTo($filename, $this->contents);
    }
}

/**
 * What does the acronym SDK stand for?
 * Flutter is written in which language?
 * What are the limitations of Flutter?
 * Can you tell us how many kinds of widgets there are in Flutter?
 * Name the different types of build modes in Flutter.
 * What is the use of the Async Await function?
 * Explain the term “Tree shaking” in Flutter.
 * What’s the function of the future in Dart?
 */
