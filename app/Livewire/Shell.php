<?php

namespace App\Livewire;

use App\Models\Script;
use App\Models\Modifier;
use App\Services\ScriptService;
use App\Services\ShellService;
use Livewire\Component;

class Shell extends Component
{
    private ShellService $service;
    public string $output = '';
    public string $command = '';
    public string $modifier = '';
    public array $modifiers = [];
    public bool $shouldSaveModifier = false;
    public bool $showModifiers = false;
    public int $scriptId = 0;
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

    public function runScript(): void
    {
        if ($this->modifier) {
            $this->modify();
            return;
        }

        if ($this->scriptId === 0) {
            return;
        }

        $script = Script::find($this->scriptId);

        if (! $script) {
            $this->output = 'No Script selected.';
            return;
        }

        $this->loading = true;
        $this->output = $this->service->execute($script->commands);
    }

    public function modify(): void
    {
        if ($this->modifier === '') {
            $this->runScript();
            return;
        }

        $script = Script::find($this->scriptId);

        if ($this->shouldSaveModifier) {
            $this->saveModifier();
        }

        $this->output = $this->service->execute(
            $script->commands . ' ' . $this->modifier
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
        $this->scriptId = 0;
        $this->command = '';
        $this->modifier = '';
        $this->output = '';
    }

    public function render(): mixed
    {
        $scripts = (new ScriptService())->getScriptList();

        return view('livewire.shell', ['scripts' => $scripts]);
    }

    public function saveModifier():void
    {
        $mod = Modifier::where('command', $this->modifier)->first();

        if ($mod) {
            return;
        }

        Modifier::create([
            'command' => $this->modifier
        ]);

        $this->shouldSaveModifier = false;
    }
}
