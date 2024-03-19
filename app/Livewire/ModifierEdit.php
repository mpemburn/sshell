<?php

namespace App\Livewire;

use App\Models\Modifier;
use App\Services\ModifierService;
use Livewire\Component;

class ModifierEdit extends Component
{
    public int $modifierId = 0;
    public string $editor = '';
    public bool $showDelete = false;
    public bool $showNewButton = true;

    public function editModifier(): void
    {
        if ($this->modifierId === 0) {
            $this->editor = '';
            return;
        }

        $modifier = Modifier::find($this->modifierId);

        if (! $modifier) {
            $this->editor = 'No Modifier selected.';
            return;
        }
        $this->editor = $modifier->command;
        $this->showDelete = true;
    }

    public function save(): void
    {
        if ($this->modifierId === 0) {
            $this->saveNewModifier();
            return;
        }

        $modifier = Modifier::find($this->modifierId);

        $modifier->update([
            'command' => $this->editor
        ]);
    }

    public function newModifier(): void
    {
        $this->showNewButton = false;
        $this->showDelete = false;
        $this->modifierId = 0;
        $this->editor = '';
        $this->dispatch('focusTitle');
    }

    public function saveNewModifier(): void
    {
        Modifier::create([
            'command' => $this->editor
        ]);

        $this->editor = '';
        $this->showNewButton = true;
    }

    public function delete(): void
    {
        $modifier = Modifier::find($this->modifierId);
        $modifier->delete();
        $this->editor = '';
    }

    public function clear(): void
    {
        $this->modifierId = 0;
        $this->editor = '';
        $this->showDelete = false;
        $this->showNewButton = true;
    }

    public function render()
    {
        $modifiers = (new ModifierService())->getModifierList();

        return view('livewire.modifier-crud', ['modifiers' => $modifiers]);
    }
}
