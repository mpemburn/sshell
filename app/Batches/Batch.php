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
    protected ?string $workingDir = null;
    protected ShellService $service;

    public function __construct()
    {
        $this->service = new ShellService();
    }

    public function setConnection(?string $connection): self
    {
        if ($connection) {
            $this->service->connect($connection);
        }

        return $this;
    }

    public function setWorkingDirectory(?string $workingDir): self
    {
        if ($workingDir) {
            $this->workingDir = $workingDir;
        }

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
            /* The connection and environment can be set
                at the top of the batch file ([name].txt:
                conn=[predefined connection]
                dir=[working directory]
            */
            if ($this->setVarsFromBatchFile($item)) {
                return;
            }

            $script = $this->buildScript($item);

            echo $this->service->execute($script) . PHP_EOL;
        });

    }

    protected function setVarsFromBatchFile(string $item): bool
    {
        $var = preg_replace('/([\w]+=)(.*)/', '$2', $item);

        if (str_starts_with($item, 'conn=')) {
            $this->setConnection($var);

            return true;
        }
        if (str_starts_with($item, 'dir=')) {
            $this->setWorkingDirectory($var);

            return true;
        }

        return false;
    }

    protected function buildScript(string $item): string
    {
        $script = '';
        collect($this->commands)->each(function ($command) use ($item, &$script) {
            if ($this->workingDir && str_contains($command, '{{ env }}')) {
                $command = str_replace('{{ env }}', $this->workingDir, $command);
            }
            if (str_contains($command, '{{ item }}')) {
                $command = str_replace('{{ item }}', $item, $command);
            }
            $script .= $command . ';' . PHP_EOL;
        });

        return $script;
    }
}
