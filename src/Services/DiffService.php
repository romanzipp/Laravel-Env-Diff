<?php

namespace romanzipp\EnvDiff\Services;

use Dotenv\Dotenv;
use LucidFrame\Console\ConsoleTable;
use Wujunze\Colors;

class DiffService
{
    /**
     * File & env variables.
     *
     * @var array
     */
    private $data;

    /**
     * Console table.
     *
     * @var ConsoleTable|null
     */
    private $table;

    /**
     * Base path for loading .env files.
     *
     * @var string|null
     */
    private $path;

    public function __construct(string $path = null)
    {
        $this->path = $path;
    }

    /**
     * Add a new .env file and store the loaded data.
     *
     * @param string|array $file File name/s
     */
    public function add($file): void
    {
        $files = is_array($file) ? $file : [$file];

        foreach ($files as $envFile) {

            $this->setData(
                $envFile,
                Dotenv::createMutable($this->path, $file)->load()
            );
        }
    }

    /**
     * Manually set variable data corresponsing to file name.
     *
     * @param string $file
     * @param array $data
     */
    public function setData(string $file, array $data): void
    {
        $this->data[$file] = $data;
    }

    /**
     * Get data.
     *
     * @param string|null $file
     * @return array
     */
    public function getData(string $file = null): array
    {
        return $file === null ? $this->data : ($this->data[$file] ?? []);
    }

    /**
     * Create a diff of all registered env variables.
     *
     * @return array
     */
    public function diff(): array
    {
        $variables = [];

        foreach ($this->data as $file => $vars) {
            foreach ($vars as $key => $value) {
                if ( ! in_array($key, $variables)) {
                    $variables[] = $key;
                }
            }
        }

        $hideExisting = config('env-diff.hide_existing');

        $diff = [];

        foreach ($variables as $variable) {

            $containing = [];

            foreach ($this->data as $file => $vars) {
                $containing[$file] = array_key_exists($variable, $vars);
            }

            if ($hideExisting) {

                $unique = array_unique(array_values($containing));

                if (count($unique) == 1 && $unique[0] === true) {
                    continue;
                }
            }

            $diff[$variable] = $containing;
        }

        return $diff;
    }

    /**
     * Build table.
     *
     * @return ConsoleTable
     */
    public function buildTable(): ConsoleTable
    {
        $this->table = new ConsoleTable;

        $this->table->setPadding(1);
        $this->table->setIndent(0);

        $files = array_keys($this->data);

        $headers = ['Variable'];

        foreach ($files as $file) {
            $headers[] = $file;
        }

        $this->table->setHeaders($headers);

        foreach ($this->diff() as $variable => $containing) {

            $row = [$variable];

            foreach ($files as $file) {
                $row[] = $containing[$file] == true ? $this->valueOkay() : $this->valueNotFound();
            }

            $this->table->addRow($row);
        }

        return $this->table;
    }

    /**
     * Build & display table.
     *
     * @return void
     */
    public function displayTable(): void
    {
        $this->buildTable()->display();
    }

    /**
     * Get console table string value.
     *
     * @return string
     */
    private function valueOkay(): string
    {
        return config('env-diff.use_colors') ? (new Colors)->getColoredString('y', 'green') : 'y';
    }

    /**
     * Get console table string value.
     *
     * @return string
     */
    private function valueNotFound(): string
    {
        return config('env-diff.use_colors') ? (new Colors)->getColoredString('n', 'red') : 'n';
    }
}
