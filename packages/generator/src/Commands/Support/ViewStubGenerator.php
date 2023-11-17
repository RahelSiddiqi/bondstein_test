<?php

namespace Rahel\Generator\Commands\Support;

use Illuminate\Support\Str;

class ViewStubGenerator
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
        $stub           = Stub::create('index.stub', 'resources/views/' . Str::plural(strtolower($this->name)));
        $this->contents = $stub->getContents();
        $this->replace('model', ucfirst($this->name));

        $columns = '<table class="table-auto">';
        $columns .= '<thead><tr>';
        $columns .= '<th>SL</th>';
        foreach ($this->columns as $column) {
            $columns .= '<th>' . $column . '</th>';
        }
        $columns .= '</tr></thead>';
        $columns .= '<tbody>';
        $columns .= ' @foreach ($data as $d)';
        $columns .= '<tr>';

        foreach ($this->columns as $column) {
            $columns .= '<td>{{ $d->' . strtolower($column) . '}}</td>';
            if (!next($this->columns)) {
                $columns .= '<td><a href="{{ route(\'' . Str::plural(strtolower($this->name)) . '.edit\',[\'' . strtolower($this->name) . '\' => $d->id]) }}">Edit</a></td>';
                $columns .= '<td><form method="POST" action="{{ route(\'' . Str::plural(strtolower($this->name)) . '.destroy\',[\'' . strtolower($this->name) . '\' => $d->id]) }}">';
                $columns .= ' @method(\'delete\') @csrf <button type="submit" class="btn btn-danger btn-sm">Delete</button></form></td>';
            }
        }
        $columns .= '</tr>';
        $columns .= '@endforeach';
        $columns .= '</tbody>';
        $columns .= '</table>';
        $this->replace('data', $columns);

        $filename = 'index' . '.blade.php';

        $stub->saveTo($filename, $this->contents);
    }
}
