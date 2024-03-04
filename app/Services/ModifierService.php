<?php

namespace App\Services;

use App\Models\Modifier;

class ModifierService
{
    public function getModifierList(): array
    {
        return Modifier::all()
            ->pluck('command', 'id')
            ->toArray();
    }
}
