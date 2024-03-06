<?php

namespace App\Services;

use App\Models\Script;

class ScriptService
{
    public function getScriptList(int $connectionId): array
    {
        return Script::where('host_id', $connectionId)
            ->pluck('script', 'id')
            ->toArray();
    }
}
