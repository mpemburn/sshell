<?php

namespace App\Livewire;

use App\Models\Command;
use App\Services\ShellService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Shell extends Component
{
    private ShellService $service;
    public string $output;
    public string $command;
    public string $modifier;
    public int $commandId = 0;
    public $items = ['| grep UN', 'Item 2', 'Item 3'];
    public function __construct()
    {
        $this->service = new ShellService();
    }

    public function submit(): void
    {
        $this->output = $this->service->execute($this->command);
    }

    public function runCommand(): void
    {
        if ($this->modifier) {
            $this->modify();

            return;
        }

        $command = Command::find($this->commandId);

        $this->output = $this->service->execute($command->commands);
    }

    public function modify(): void
    {
        if ($this->modifier === '') {
            $this->runCommand();

            return;
        }

        $command = Command::find($this->commandId);

        $this->output = $this->service->execute(
            $command->commands . $this->modifier
        );
    }

    public function handleItemClick(string $item)
    {
        Log::debug($item);
    }

    public function render(): mixed
    {
        $commands = Command::all()
            ->pluck('script', 'id')
            ->toArray();

        return view('livewire.shell', ['commands' => $commands]);
    }
}
