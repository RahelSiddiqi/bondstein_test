<?php

namespace Rahel\Generator\Commands;

use Illuminate\Console\Command;
use Rahel\Generator\Commands\Support\ControllerStubGenerator;
use Rahel\Generator\Commands\Support\CreateStubGenerator;
use Rahel\Generator\Commands\Support\EditStubGenerator;
use Rahel\Generator\Commands\Support\LayoutStubGenerator;
use Rahel\Generator\Commands\Support\MigrationStubGenerator;
use Rahel\Generator\Commands\Support\ModelStubGenerator;
use Rahel\Generator\Commands\Support\RequestStubGenerator;
use Rahel\Generator\Commands\Support\RouteStubGenerator;
use Rahel\Generator\Commands\Support\ViewStubGenerator;

class GeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:new {name}';

    /**
     * The name for the model we will generate.
     *
     * @var string
     */
    protected $name;

    /**
     * The name for the model we will generate.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->name = ucfirst($this->argument('name'));

        $add_col = strtolower($this->ask('Would you like to add new column? [y/n]'));
        while ($add_col == 'y' || $add_col == 'yes') {
            $column          = $this->ask('enter the column name: ');
            $this->columns[] = $column;
            $add_col         = strtolower($this->ask('Would you like to add new column? [y/n]'));
        }
        MigrationStubGenerator::generate($this->name, $this->columns)->save();
        ModelStubGenerator::generate($this->name, $this->columns)->save();
        RequestStubGenerator::generate($this->name, $this->columns)->save();
        RouteStubGenerator::generate($this->name, $this->columns)->save();
        LayoutStubGenerator::generate($this->name, $this->columns)->save();
        CreateStubGenerator::generate($this->name, $this->columns)->save();
        EditStubGenerator::generate($this->name, $this->columns)->save();
        ViewStubGenerator::generate($this->name, $this->columns)->save();
        ControllerStubGenerator::generate($this->name, $this->columns)->save();
        $this->call('migrate:fresh');
        return 0;
    }
}
