<?php

namespace App\Livewire;

use App\Models\Command;
use App\Models\Modifier;
use App\Services\ShellService;
use Livewire\Component;

class Shell extends Component
{
    private ShellService $service;
    public string $output = '';
    public string $command = '';
    public string $modifier = '';
    public array $modifiers = [];
    public bool $showModifiers = false;
    public int $commandId = 0;
    public function __construct()
    {
        $this->service = new ShellService();
    }

    public function submit(): void
    {
        if ($this->command === '') {
            $this->output = 'Please enter a command.';
            return;
        }

        $this->output = $this->service->execute($this->command);
    }

    public function runCommand(): void
    {
        if ($this->modifier) {
            $this->modify();
            return;
        }

        if (! $this->commandId) {
            return;
        }

        $command = Command::find($this->commandId);

        if (! $command) {
            $this->output = 'No Command selected.';
            return;
        }

        $this->loading = true;
        $this->output = $this->service->execute($command->commands);
    }

    public function modify(): void
    {
        if ($this->modifier === '') {
            $this->runCommand();
            return;
        }

        $command = Command::find($this->commandId);

        $this->saveModifier($this->modifier);

        $this->output = $this->service->execute(
            $command->commands . ' ' . $this->modifier
        );
    }

    // Build a list of modifiers based on input field contents
    public function suggest(): void
    {
        if ($this->modifier === '') {
            $this->showModifiers = false;
            return;
        }
        $mods = Modifier::where('command', 'LIKE', '%' . $this->modifier . '%')
            ->pluck('command');

        $this->modifiers = $mods->toArray();

        $this->showModifiers = count($this->modifiers) > 0;
    }

    // A modifier (e.g., '| grep UN') was selected from dropdown
    public function selectModifier(string $modifier): void
    {
        $this->modifier = $modifier;
        $this->showModifiers = false;
    }


    public function clear(): void
    {
        $this->commandId = 0;
        $this->command = '';
        $this->modifier = '';
        $this->output = '';
    }

    public function render(): mixed
    {
        $commands = Command::all()
            ->pluck('script', 'id')
            ->toArray();

        return view('livewire.shell', ['commands' => $commands]);
    }

    protected function saveModifier(string $modifier)
    {
        $mod = Modifier::where('command', $modifier)->first();

        if ($mod) {
            return;
        }

        Modifier::create([
            'command' => $modifier
        ]);
    }
}
