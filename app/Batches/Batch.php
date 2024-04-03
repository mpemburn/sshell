<?php

namespace App\Batches;

use App\Facades\Reader;
use App\Interfaces\BatchInterface;
use App\Services\ShellService;
use Illuminate\Support\Collection;

abstract class Batch implements BatchInterface
{
    protected array $commands = [];
    protected ?Collection $batch;
    protected ShellService $service;

    public function __construct()
    {
        $this->service = new ShellService();
    }

    /**
     * @return Collection|null
     */
    public function setConnection(string $connection): self
    {
        $this->service->connect($connection);

        return $this;
    }

    public function getBatchFile(string $filePath): self
    {
        $this->batch = Reader::getContentsAsCollection($filePath);

        return $this;
    }

    /**
     * @return array
     */
    public function run(): void
    {
        if (! $this->batch) {
            return;
        }

        $this->batch->each(function ($item) {
            if (empty($item)) {
                return;
            }
            $script = $this->buildScript($item);

            echo $this->service->execute($script) . PHP_EOL;
        });

    }

    protected function buildScript(string $item): string
    {
        $script = '';
        collect($this->commands)->each(function ($command) use ($item, &$script) {
            if (str_contains($command, '{{ item }}')) {
                $command = str_replace('{{ item }}', $item, $command);
            }
            $script .= $command . ';' . PHP_EOL;
        });

        return $script;
    }
}
