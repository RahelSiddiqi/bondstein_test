<?php

namespace Rahel\Generator\Commands\Support;

use Carbon\Carbon;
use Illuminate\Support\Str;

class MigrationStubGenerator
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
        $stub           = Stub::create('migration.stub', 'database/migrations');
        $this->contents = $stub->getContents();
        $this->replace('table', strtolower(Str::plural($this->name)));
        $columns = '';
        foreach ($this->columns as $column) {
            $columns .= '$table->string(\'' . strtolower($column) . '\');' . PHP_EOL;
        }
        $this->replace('fields', $columns);

        $filename = Carbon::now()->format('Y_m_d_s') . '_create_' . strtolower(Str::plural($this->name)) . '_table.php';

        $stub->saveTo($filename, $this->contents);
    }
}
