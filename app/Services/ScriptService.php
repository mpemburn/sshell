<?php

namespace App\Services;

use App\Models\Script;

class ScriptService
{
    public function getScriptList(): array
    {
        return Script::all()
            ->pluck('script', 'id')
            ->toArray();
    }
}
