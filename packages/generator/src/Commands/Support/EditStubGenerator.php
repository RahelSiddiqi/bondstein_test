<?php

namespace Rahel\Generator\Commands\Support;

use Illuminate\Support\Str;

class EditStubGenerator
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
        $stub           = Stub::create('edit.stub', 'resources/views/' . Str::plural(strtolower($this->name)));
        $this->contents = $stub->getContents();
        $this->replace('model', ucfirst($this->name));

        $columns = '<form  class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post" action="{{route(\'' . Str::plural(strtolower($this->name)) . '.update\',' . '[\'' . strtolower($this->name) . '\' => $data->id])}}">';
        $columns .= '@csrf';
        $columns .= ' @method(\'PUT\')';
        foreach ($this->columns as $column) {
            $columns .= '<div class="mb-4">';
            $columns .= '<label class="block text-gray-700 text-sm font-bold mb-2">' . ucfirst($column) . '</label>';
            $columns .= '<input value="{{$data->' . strtolower($column) . '}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="' . $column . '" type="text" placeholder="Enter ' . ucfirst($this->name) . '">';
            $columns .= '</div>' . PHP_EOL;
        }
        $columns .= '<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Save</button></form>';
        $this->replace('data', $columns);

        $filename = 'edit' . '.blade.php';

        $stub->saveTo($filename, $this->contents);
    }
}
