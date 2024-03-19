<?php

namespace App\Livewire;

use App\Models\Connection;
use App\Models\Script;
use App\Services\ScriptService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ScriptEdit extends Component
{
    public int $connectionId = 0;
    public int $scriptId = 0;
    public array $scripts = [];
    public string $editor = '';
    public string $scriptTitle = '';
    public bool $showDelete = false;
    public bool $showNewButton = true;

    public function editScript(): void
    {
        if ($this->scriptId === 0) {
            $this->editor = '';
            return;
        }

        $script = Script::find($this->scriptId);

        if (! $script) {
            $this->editor = 'No Script selected.';
            return;
        }
        $this->scriptTitle = $script->script;
        $this->editor = $script->commands;
        $this->showDelete = true;
    }

    public function save(): void
    {
        $this->loading = true;
        if ($this->scriptId === 0) {
            $this->saveNewScript();
            return;
        }

        $script = Script::find($this->scriptId);

        $script->update([
            'host_id' => $this->connectionId,
            'script' => $this->scriptTitle,
            'commands' => $this->editor
        ]);

        $this->loadScripts();
        $this->loading = false;
    }

    public function setConnectionId(): void
    {
        if ($this->connectionId === 0) {
            return;
        }

        $connection = Connection::find($this->connectionId);
        if (! $connection) {
            $this->scripts = [];
            return;
        }

        $this->loadScripts();
    }

    public function newScript(): void
    {
        $this->showNewButton = false;
        $this->showDelete = false;
        $this->scriptId = 0;
        $this->scriptTitle = '';
        $this->editor = '';
        $this->dispatch('focusTitle');
    }

    public function saveNewScript(): void
    {
        Script::create([
            'host_id' => $this->connectionId,
            'script' => $this->scriptTitle,
            'commands' => $this->editor
        ]);

        $this->scriptTitle = '';
        $this->editor = '';
        $this->showNewButton = true;
        $this->loadScripts();

    }

    public function delete(): void
    {
        $this->loading = true;
        $script = Script::find($this->scriptId);
        $script->delete();
        $this->scriptTitle = '';
        $this->editor = '';
        $this->loadScripts();
        $this->loading = false;
    }

    public function clear(): void
    {
        $this->scriptId = 0;
        $this->scriptTitle = '';
        $this->editor = '';
        $this->showDelete = false;
        $this->showNewButton = true;
    }

    protected function loadScripts()
    {
        $this->scripts = (new ScriptService())->getScriptList($this->connectionId);
    }

    public function render()
    {
        return view('livewire.script-crud');
    }
}
