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
    public bool $showExisting = true;
    public bool $showNewTitle = false;
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
        $this->editor = $script->scripts;
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
        $this->showExisting = false;
        $this->showNewTitle = true;
        $this->showNewButton = false;
        $this->scriptId = 0;
    }

    public function saveNewScript(): void
    {

    }

    public function render()
    {
        $scripts = (new ScriptService())->getScriptList();

        return view('livewire.script-edit', ['scripts' => $scripts]);
    }
}
