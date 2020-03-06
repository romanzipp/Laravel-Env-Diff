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
     * Manually set variable data corresponding to file name.
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
        if ($file === null) {
            return $this->data;
        }

        return $this->data[$file] ?? [];
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

                if (in_array($key, $variables, false)) {
                    continue;
                }

                $variables[] = $key;
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

                if (count($unique) === 1 && $unique[0] === true) {
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

        $showValues = config('env-diff.show_values');

        foreach ($this->diff() as $variable => $containing) {

            $row = [$variable];

            foreach ($files as $file) {

                $value = null;

                if ( ! $showValues) {

                    $value = $this->valueNotFound();

                    if ($containing[$file] === true) {
                        $value = $this->valueOkay();
                    }

                } else {

                    $value = $this->getColoredString('MISSING', 'red');

                    $existing = $this->getData($file)[$variable] ?? null;

                    if ($existing !== null) {
                        $value = $existing;
                    }
                }

                $row[] = $value;
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
        return $this->getColoredString('Y', 'green');
    }

    /**
     * Get console table string value.
     *
     * @return string
     */
    private function valueNotFound(): string
    {
        return $this->getColoredString('N', 'red');
    }

    /**
     * Color a string for shell output if enabled via config.
     *
     * @param string $string
     * @param string $color
     * @return string
     */
    private function getColoredString(string $string, string $color): string
    {
        if ( ! config('env-diff.use_colors')) {
            return $string;
        }

        return (new Colors)->getColoredString($string, $color);
    }
}
