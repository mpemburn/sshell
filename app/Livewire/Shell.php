<?php

namespace App\Livewire;

use App\Models\Script;
use App\Models\Modifier;
use App\Services\ScriptService;
use App\Services\ShellService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Shell extends Component
{
    protected ShellService $service;
    protected ScriptService $scriptService;
    public bool $connected = false;
    public string $output = '';
    public string $command = '';
    public string $modifier = '';
    public array $modifiers = [];
    public bool $loading = false;
    public bool $shouldSaveModifier = false;
    public bool $showModifiers = false;
    public bool $disableModify = false;
    public int $scriptId = 0;

    public function __construct()
    {
        $connectionName = ShellService::getConnection();
        $this->service = new ShellService();
        $this->scriptService = new ScriptService();

        $result = $this->service->connect($connectionName);
        if ($result) {
            $this->output = "Connected to \"{$connectionName}\"";
            $this->connected = true;
        } else {
            $this->connected = false;
            $this->output = "Connection to \"{$connectionName}\" failed: " . $this->service->getError();
        }
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
        $this->disableModify = true;
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

        $this->disableModify = false;
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

        if ($script) {
            $this->output = $this->service->execute(
                $script->commands . ' ' . $this->modifier
            );
        }
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

    public function clear(): void
    {
        $this->scriptId = 0;
        $this->command = '';
        $this->modifier = '';
        $this->output = '';
    }

    public function render(): mixed
    {
        $scripts = $this->scriptService->getScriptList(ShellService::getConnectionId());

        //$this->output = 'Connected to ' . ShellService::getConnectionName();

        return view('livewire.shell', ['scripts' => $scripts]);
    }
}
