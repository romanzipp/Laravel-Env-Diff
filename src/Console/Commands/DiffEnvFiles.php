<?php

namespace romanzipp\EnvDiff\Console\Commands;

use Illuminate\Console\Command;
use romanzipp\EnvDiff\Services\DiffService;

class DiffEnvFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diff:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a visual Diff of .env and .env.example files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = array_merge(['.env'], config('env-diff.additional_files'));

        $service = new DiffService;
        $service->add($files);

        $service->displayTable();
    }
}
