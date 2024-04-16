<?php

namespace Laravel\Scout\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'scout:flush')]
class FlushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:flush 
        {model : Class name of the model to flush}
        {--c|searchableAs= : Specific Hiring Org ID to flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Flush all of the model's records from the index";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $class = $this->argument('model');
        $searchableAs = $this->option('searchableAs');
        if ($searchableAs) {
            $model = $this->app->makeWith($class, ['hiring_organization_id' => $searchableAs]);
        } else {
            $model = new $class;
        }
    
        $model::removeAllFromSearch();

        $this->info('All ['.$class.'] records have been flushed.');
    }
}
