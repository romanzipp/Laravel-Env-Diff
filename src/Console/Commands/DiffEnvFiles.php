<?php

namespace romanzipp\EnvDiff\Console\Commands;

use Illuminate\Console\Command;

class DiffEnvFiles extends Command
{
    const REGEX = '/^([A-Z0-9_]+)/';

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
        $exampleData = $this->getEnvContents('.env.example');

        $comparingFiles = array_merge(config('env-diff.additional_files'), [null]);

        foreach ($comparingFiles as $file) {

            $file = is_null($file) ? '.env' : $file;

            $this->info('');
            $this->info('Comparing environment file: ' . $file);
            $this->info('');

            $data = $this->getEnvContents($file);

            if ($data === null) {
                continue;
            }

            $this->iterateAndEcho($exampleData, $data, $file);

            if (!config('env-diff.reverse_example_check')) {
                continue;
            }

            $this->iterateAndEcho($data, $exampleData);
        }
    }

    /**
     * Iterate through env varaibles and show results
     * @param  array  $data
     * @param  array  $comparingData
     * @param  string $file
     * @return void
     */
    public function iterateAndEcho(array $data, array $comparingData, string $file = '.env.example'): void
    {
        foreach ($data as $line) {

            if (!preg_match(self::REGEX, $line, $match)) {
                continue;
            }

            $variable = $match[1];

            if (!$this->variableExists($variable, $comparingData)) {

                $dots = str_repeat('.', 20 - strlen($file));

                $this->warn('Missing variable in ' . $file . ' ' . $dots . ': ' . $variable);
            }
        }
    }

    /**
     * Get splitted contents of environment files
     * @param  string $file Env file name
     * @return array
     */
    protected function getEnvContents(string $file):  ? array
    {
        $content = @file_get_contents(base_path() . '/' . $file);

        if ($content === false) {
            $this->error('Environment file not found: ' . $file);
            return null;
        }

        $array = explode("\n", $content);

        $array = array_filter($array);

        return $array;
    }

    /**
     * Determine if a variable exists
     *
     * @param  string $variable Variable name
     * @param  array  $envData  Environment data
     * @return boolean
     */
    protected function variableExists(string $variable, array $envData) : bool
    {
        foreach ($envData as $envLine) {

            if (preg_match(self::REGEX, $envLine, $match)) {

                if ($match[1] == $variable) {
                    return true;
                }
            }
        }

        return false;
    }
}
