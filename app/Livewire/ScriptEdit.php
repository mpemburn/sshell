<?php

namespace App\Livewire;

use App\Models\Script;
use App\Services\ScriptService;
use Livewire\Component;

class ScriptEdit extends Component
{
    public int $scriptId = 0;
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
        if ($this->scriptId === 0) {
            $this->saveNewScript();
            return;
        }

        $script = Script::find($this->scriptId);

        $script->update([
            'script' => $this->scriptTitle,
            'scripts' => $this->editor
        ]);
    }

    public function newScript(): void
    {
        $this->showNewButton = false;
        $this->scriptId = 0;
        $this->scriptTitle = '';
        $this->editor = '';
        $this->dispatch('focusTitle');
    }

    public function saveNewScript(): void
    {
        Script::create([
            'script' => $this->scriptTitle,
            'commands' => $this->editor
        ]);

        $this->scriptTitle = '';
        $this->editor = '';
        $this->showNewButton = true;
    }

    public function delete(): void
    {
        $script = Script::find($this->scriptId);
        $script->delete();
        $this->scriptTitle = '';
        $this->editor = '';
    }

    public function clear(): void
    {
        $this->scriptId = 0;
        $this->scriptTitle = '';
        $this->editor = '';
        $this->showDelete = false;
    }

    public function render()
    {
        $scripts = (new ScriptService())->getScriptList();

        return view('livewire.script-edit', ['scripts' => $scripts]);
    }
}
